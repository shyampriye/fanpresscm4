<?php

/**
 * FanPress CM 4
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\model\comments;

/**
 * Kommentar-Listen-Objekt
 * 
 * @package fpcm\model\comments
 * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
class commentList extends \fpcm\model\abstracts\tablelist {

    use permissions;

    /**
     * articlelist Objekt
     * @var \fpcm\model\articles\articlelist
     * @since FPCM 3.3
     */
    protected $articleList;

    /**
     * Liste mit IDs von Artikeln, die vom aktuelle Benutzer verschrieben wurden
     * @var array
     * @since FPCM 3.3
     */
    protected $ownArticleIds = false;

    /**
     * Permission Object
     * @var \fpcm\model\system\permissions
     * @since FPCM 3.3
     */
    protected $permissions = false;

    /**
     * Konstruktor
     */
    public function __construct()
    {
        $this->table = \fpcm\classes\database::tableComments;

        if (is_object(\fpcm\classes\loader::getObject('\fpcm\model\system\session')) && \fpcm\classes\loader::getObject('\fpcm\model\system\session')->exists()) {
            $this->permissions = \fpcm\classes\loader::getObject('\fpcm\model\system\permissions');
        }

        parent::__construct();
    }

    /**
     * Liefert ein array aller Kommentare
     * @return array
     */
    public function getCommentsAll()
    {
        $list = $this->dbcon->selectFetch( (new \fpcm\model\dbal\selectParams())->setTable($this->table)->setWhere( '1=1'.$this->dbcon->orderBy( ['createtime DESC'] ))->setFetchAll(true) );
        return $this->createCommentResult($list);
    }

    /**
     * Liefert ein array der Kommentare, welcher mit der Bedingung übereinstimmen
     * @param int $articleId Artikel-ID
     * @param bool $private private Kommentare ja/nein
     * @param bool $hideUnapproved genehmigte Kommentare ja/nein
     * @param bool $spam als Spam markierte Kommentare ja/nein
     * @return array
     */
    public function getCommentsByCondition($articleId, $private = 0, $hideUnapproved = 1, $spam = 0)
    {
        $conditions = new search();
        $conditions->articleid = $articleId;
        $conditions->private = $private;
        $conditions->spam = $spam;
        $conditions->approved = $hideUnapproved;
        $conditions->searchtype = 0;
        $conditions->deleted = 0;

        return $this->getCommentsBySearchCondition($conditions);
    }

    /**
     * Liefert ein array der Kommentare, welcher mit der Bedingung übereinstimmen
     * @param search $conditions
     * @return array
     */
    public function getCommentsBySearchCondition(search $conditions)
    {
        $where = [];
        $valueParams = [];

        $searchTypeAllNmw = in_array($conditions->searchtype, [\fpcm\model\comments\search::TYPE_ALL, \fpcm\model\comments\search::TYPE_NAMEMAILWEB]);
        if ($conditions->text && $searchTypeAllNmw) {
            $where[] = "name " . $this->dbcon->dbLike() . " ?";
            $valueParams[] = "%{$conditions->text}%";
        }

        if ($conditions->text && $searchTypeAllNmw) {
            $where[] = "email " . $this->dbcon->dbLike() . " ?";
            $valueParams[] = "%{$conditions->text}%";
        }

        if ($conditions->text && $searchTypeAllNmw) {
            $where[] = "website " . $this->dbcon->dbLike() . " ?";
            $valueParams[] = "%{$conditions->text}%";
        }

        if ($conditions->text) {
            $where[] = "text " . $this->dbcon->dbLike() . " ?";
            $valueParams[] = "%{$conditions->text}%";
        }

        if (count($where) && $searchTypeAllNmw) {
            $where = ['(' . implode(' OR ', $where) . ')'];
        }

        if ($conditions->datefrom) {
            $where[] = "createtime >= ?";
            $valueParams[] = $conditions->datefrom;
        }

        if ($conditions->dateto) {
            $where[] = "createtime <= ?";
            $valueParams[] = $conditions->dateto;
        }

        if ($conditions->spam && $conditions->spam > -1) {
            $where[] = "spammer = ?";
            $valueParams[] = (int) $conditions->spam;
        }

        if ($conditions->private && $conditions->private > -1) {
            $where[] = "private = ?";
            $valueParams[] = (int) $conditions->private;
        }

        if ($conditions->approved && $conditions->approved > -1) {
            $where[] = "approved = ?";
            $valueParams[] = (int) $conditions->approved;
        }

        if ($conditions->deleted !== null) {
            $where[] = "deleted = ?";
            $valueParams[] = (int) $conditions->deleted;
        }

        if ($conditions->articleid) {
            $where[] = "articleid = ?";
            $valueParams[] = (int) $conditions->articleid;
        }

        if ($conditions->ipaddress) {
            $where[] = "ipaddress = ?";
            $valueParams[] = $conditions->ipaddress;
        }
        
        if (!count($where)) {
            $where = ['1=1'];
        }

        $combination = $conditions->combination ? $conditions->combination : 'AND';

        $eventData = $this->events->trigger('comments\getByCondition', [
            'conditions' => $conditions,
            'where' => $where,
            'values' => $valueParams
        ]);

        $where = $eventData['where'];
        $where = implode(" {$combination} ", $where);
        $valueParams = $eventData['values'];

        $where2 = [];
        $where2[] = $this->dbcon->orderBy( ($conditions->orderby ? $conditions->orderby : ['createtime ASC']) );

        $limit = $conditions->limit;
        if ($limit) {
            $where2[] = $this->dbcon->limitQuery($limit[0], $limit[1]);
        }

        $where .= ' ' . implode(' ', $where2);

        $obj = (new \fpcm\model\dbal\selectParams())
                ->setTable($this->table)
                ->setFetchAll(true)
                ->setWhere($where)
                ->setParams($valueParams);

        return $this->createCommentResult($this->dbcon->selectFetch($obj));
    }

    /**
     * Löscht Kommentare
     * @param array $ids
     * @return bool
     */
    public function deleteComments(array $ids)
    {
        if (!count($ids)) {
            return false;
        }

        $this->cache->cleanup();

        /* @var $session \fpcm\model\system\session */
        $session = \fpcm\classes\loader::getObject('\fpcm\model\system\session');
        $userId = $session->exists() ? $session->getUserId() : 0;

        return $this->dbcon->update(
            $this->table,
            ['deleted', 'changetime', 'changeuser'],
            [1, time(), $userId],
            'id IN ('.implode(', ', array_map('intval', $ids)).')'
        );
    }

    /**
     * Löscht Kommentare für einen Artikel mit übergebener/n ID(s)
     * @param int|array $article_ids
     * @return bool
     */
    public function deleteCommentsByArticle($article_ids)
    {
        if (!is_array($article_ids)) {
            $article_ids = [$article_ids];
        }

        $this->cache->cleanup();

        /* @var $session \fpcm\model\system\session */
        $session = \fpcm\classes\loader::getObject('\fpcm\model\system\session');
        $userId = $session->exists() ? $session->getUserId() : 0;

        return $this->dbcon->update(
            $this->table,
            ['deleted', 'changetime', 'changeuser'],
            [1, time(), $userId],
            'articleid IN ('.implode(', ', array_map('intval', $article_ids)).')'
        );
    }

    /**
     * Zählt Kommentare für alle Artikel
     * @param array $articleIds
     * @param bool $private
     * @param bool $approved
     * @param bool $spam
     * @param bool $getCached
     * @return bool
     */
    public function countComments(array $articleIds = [], $private = null, $approved = null, $spam = null, $getCached = true)
    {
        $cacheName = \fpcm\model\articles\article::CACHE_ARTICLE_MODULE . '/' . __FUNCTION__ . \fpcm\classes\tools::getHash(json_encode(func_get_args()));

        if (!$this->cache->isExpired($cacheName) && $getCached) {
            return $this->cache->read($cacheName);
        }

        $where = count($articleIds) ? "articleid IN (" . implode(',', $articleIds) . ")" : '1=1';
        $where .= is_null($private) ? '' : ' AND private = ' . $private;
        $where .= is_null($approved) ? '' : ' AND approved = ' . $approved;
        $where .= is_null($spam) ? '' : ' AND spammer = ' . $spam;
        $where .= ' AND deleted = 0';

        $res = array_combine($articleIds, array_fill(0, count($articleIds), 0));

        $obj = (new \fpcm\model\dbal\selectParams())->setTable($this->table)->setItem('articleid, count(id) AS count')->setWhere("{$where} GROUP BY articleid")->setFetchAll(true);        
        $articleCounts = $this->dbcon->selectFetch($obj);
        if (!count($articleCounts)) {
            return $res;
        }

        foreach ($articleCounts as $articleCount) {
            $res[$articleCount->articleid] = $articleCount->count;
        }

        $this->cache->write($cacheName, $res, $this->config->system_cache_timeout);
        return $res;
    }

    /**
     * Zählt Kommentare für alle Artikel, die Privat oder nicht genehmigt sind
     * @param array $articleIds
     * @return array
     */
    public function countUnapprovedPrivateComments(array $articleIds = [])
    {
        $cacheName = \fpcm\model\articles\article::CACHE_ARTICLE_MODULE . '/' . __FUNCTION__ . \fpcm\classes\tools::getHash(implode(':', $articleIds));
        if (!$this->cache->isExpired($cacheName)) {
            return $this->cache->read($cacheName);
        }

        $where = count($articleIds) ? "articleid IN (" . implode(',', $articleIds) . ")" : '1=1';
        $where .= " AND (private = 1 OR approved = 0) AND deleted = 0 GROUP BY articleid";

        $obj = (new \fpcm\model\dbal\selectParams())->setTable($this->table)->setItem('articleid, count(id) AS count')->setWhere($where)->setFetchAll(true);        
        $articleCounts = $this->dbcon->selectFetch($obj);
        if (!count($articleCounts)) {
            return [0];
        }

        $res = [];
        foreach ($articleCounts as $articleCount) {
            $res[$articleCount->articleid] = $articleCount->count;
        }

        $this->cache->write($cacheName, $res, $this->config->system_cache_timeout);

        return $res;
    }

    /**
     * Zählt Kommentare anhand von Bedingung
     * @param search $conditions
     * @return int
     */
    public function countCommentsByCondition(search $conditions)
    {
        $where = ['id > 0'];

        if ($conditions->private) {
            $where[] = 'private = 1';
        }

        if ($conditions->unapproved) {
            $where[] = 'approved = 0';
        }

        if ($conditions->spam) {
            $where[] = 'spammer = 1';
        }

        $where[] = ($conditions->deleted ? 'deleted = 1' : 'deleted = 0');

        $combination = $conditions->combination ? $conditions->combination : 'AND';
        
        return $this->dbcon->count(
            $this->table,
            '*',
            $this->events->trigger('comments\getByConditionCount', implode(" {$combination} ", $where))
        );
    }

    /**
     * Gibt Zeit zurück, wenn von der aktuellen IP der letzte Kommentar geschrieben wurde
     * @return int
     */
    public function getLastCommentTimeByIP()
    {
        $where = 'deleted = 0 AND ipaddress ' . $this->dbcon->dbLike() . ' ?' . $this->dbcon->orderBy(array('createtime ASC')) . $this->dbcon->limitQuery(0, 1);
        $obj = (new \fpcm\model\dbal\selectParams())->setTable($this->table)->setItem('createtime')->setWhere($where)->setParams([\fpcm\classes\http::getIp()]);
        $res = $this->dbcon->selectFetch($obj);

        return isset($res->createtime) ? $res->createtime : 0;
    }

    /**
     * Prüft ob für die in Daten eines neuen Kommentars bereits Kommentare als Spam markiert wurden
     * @param \fpcm\model\comments\comment $comment
     * @return boolean true, wenn Anzahl größer als in $this->config->comments_markspam_commentcount definiert
     */
    public function spamExistsbyCommentData(comment $comment)
    {
        $count = $this->dbcon->count($this->table, 'id', implode(' OR ', [            
            'name ' . $this->dbcon->dbLike() . ' ?',
            'email ' . $this->dbcon->dbLike() . ' ?',
            'website ' . $this->dbcon->dbLike() . ' ?',
            'ipaddress ' . $this->dbcon->dbLike() . ' ?'
        ]) . ' AND spammer = 1 AND deleted = 0',
        [            
            $comment->getName(), '%' .
            $comment->getEmail() . '%',
            '%' . $comment->getWebsite() . '%',
            $comment->getIpaddress()
        ]);

        return $count >= $this->config->comments_markspam_commentcount ? true : false;
    }

    /**
     * Massenbearbeitung
     * @param array $commentIds
     * @param array $fields
     * @since FPCM 3.6
     */
    public function editCommentsByMass(array $commentIds, array $fields)
    {
        if (!count($commentIds)) {
            return false;
        }

        $result = $this->events->trigger('comments\massEditBefore', [
            'fields' => $fields,
            'commentIds' => $commentIds
        ]);

        foreach ($result as $key => $val) {
            ${$key} = $val;
        }

        if (isset($fields['spammer']) && $fields['spammer'] === -1) {
            unset($fields['spammer']);
        }

        if (isset($fields['approved']) && $fields['approved'] === -1) {
            unset($fields['approved']);
        }

        if (isset($fields['private']) && $fields['private'] === -1) {
            unset($fields['private']);
        }

        if (isset($fields['articleid']) && $fields['articleid'] < 1) {
            unset($fields['articleid']);
        }

        if (!count($fields)) {
            return false;
        }

        $where = 'id IN (' . implode(',', $commentIds) . ')';
        $result = $this->dbcon->update($this->table, array_keys($fields), array_values($fields), $where);

        $this->cache->cleanup();
        return $result;
    }

    /**
     * Empty trash bin
     * @return bool
     */
    public function emptyTrash() : bool
    {
        $this->cache->cleanup();
        return $this->dbcon->delete($this->table, 'deleted = 1');
    }

    /**
     * Empty trash by date
     * @return bool
     */
    public function emptyTrashByDate() : bool
    {
        $this->cache->cleanup();
        return $this->dbcon->delete($this->table, 'deleted = ? AND changetime <= ?', [
            1, time() - $this->config->system_trash_cleanup * FPCM_DATE_SECONDS
        ]);
    }

    /**
     * Empty trash bin
     * @return bool
     */
    public function retoreComments(array $ids)
    {
        $this->cache->cleanup();

        /* @var $session \fpcm\model\system\session */
        $session = \fpcm\classes\loader::getObject('\fpcm\model\system\session');
        $userId = $session->exists() ? $session->getUserId() : 0;

        return $this->dbcon->update(
            $this->table,
            ['deleted', 'changetime', 'changeuser'],
            [ 0, time(), $userId],
            'id IN ('.implode(',', array_map('intval', $ids)).') AND deleted = 1'
        );
    }

    /**
     * Erzeugt Listen-Result-Array
     * @param array $list
     * @return array
     */
    private function createCommentResult($list)
    {
        $res = [];

        foreach ($list as $listItem) {
            $object = new comment();
            if (!$object->createFromDbObject($listItem)) {
                continue;
            }
            $this->checkEditPermissions($object);
            $res[$object->getId()] = $object;
        }

        return $res;
    }

}
