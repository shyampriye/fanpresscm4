<?php

/**
 * FanPress CM 4.x
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\model\theme;

/**
 * ACP navigation Objekt
 * 
 * @author Stefan Seehafer aka imagine <sea75300@yahoo.de>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 * @package fpcm\model\theme
 */
class navigation extends \fpcm\model\abstracts\staticModel {

    /**
     * Konstruktor
     */
    public function __construct()
    {
        parent::__construct();

        $this->cacheName = 'theme/navigation_' . $this->session->getUserId();
    }

    /**
     * Navigation rendern
     * @return array
     */
    public function render()
    {
        if (!$this->cache->isExpired($this->cacheName)) {
            return $this->cache->read($this->cacheName);
        }

        $this->permissions = \fpcm\classes\loader::getObject('\fpcm\model\system\permissions');

        $navigation = $this->getNavigation();
        $navigation = $this->events->trigger('navigation\render', $navigation);

        foreach ($navigation as &$moduleOptions) {
            $moduleOptions = $this->checkPermissions($moduleOptions);
        }

        $this->cache->write($this->cacheName, $navigation, $this->config->system_cache_timeout);

        return $navigation;
    }

    /**
     * Berechtigungen für Zugriff auf Module prüfen
     * @param array $navigation
     * @return array
     */
    private function checkPermissions($navigation)
    {
        /* @var $value navigationItem */
        foreach ($navigation as $key => &$value) {

            if (is_array($value)) {
                trigger_error('Using an array as navigation item is deprecated as of FPCM 3.5. Create an instance of "\fpcm\model\theme\navigationItem" instead.' . PHP_EOL . print_r($value, true));
                $value = navigationItem::createItemFromArray($value);
            }

            if ($value->hasSubmenu()) {
                $value->setSubmenu($this->checkPermissions($value->getSubmenu()));
            }

            if ($value->hasPermission()) {

                if ($this->permissions->check($value->getPermission())) {
                    continue;
                }

                unset($navigation[$key]);
            }
        }

        return $navigation;
    }

    /**
     * Baut Navigation auf
     * @return array
     */
    private function getNavigation()
    {
        return $this->events->trigger('navigation\add', [
            'showMenu' => array(
                navigationItem::createItemFromArray([
                    'url' => '#',
                    'description' => $this->language->translate('NAVIGATION_SHOW'),
                    'icon' => 'fa fa-bars',
                    'id' => 'showMenu',
                    'class' => 'fpcm-navigation-noclick'
                ])
            ),
            'dashboard' => array(
                navigationItem::createItemFromArray([
                    'url' => 'system/dashboard',
                    'description' => $this->language->translate('HL_DASHBOARD'),
                    'icon' => 'fa fa-home',
                ])
            ),
            'addnews' => array(
                navigationItem::createItemFromArray([
                    'url' => 'articles/add',
                    'permission' => array('article' => 'add'),
                    'description' => $this->language->translate('HL_ARTICLE_ADD'),
                    'icon' => 'fa fa-pen-square'
                ])
            ),
            'editnews' => array(
                navigationItem::createItemFromArray([
                    'url' => '#',
                    'permission' => array('article' => 'edit'),
                    'description' => $this->language->translate('HL_ARTICLE_EDIT'),
                    'icon' => 'fa fa-book',
                    'submenu' => self::editorSubmenu(),
                    'class' => 'fpcm-navigation-noclick',
                    'id' => 'nav-id-editnews'
                ])
            ),
            'comments' => array(
                navigationItem::createItemFromArray([
                    'url' => 'comments/list',
                    'permission' => array('article' => array('editall', 'edit'), 'comment' => array('editall', 'edit')),
                    'description' => $this->language->translate('HL_COMMENTS_MNG'),
                    'icon' => 'fa fa-comments',
                    'id' => 'nav-item-editcomments'
                ])
            ),
            'filemanager' => array(
                navigationItem::createItemFromArray([
                    'url' => 'files/list&mode=1',
                    'permission' => array('uploads' => 'visible'),
                    'description' => $this->language->translate('HL_FILES_MNG'),
                    'icon' => 'fa fa-folder-open'
                ])
            ),
            'options' => array(
                navigationItem::createItemFromArray([
                    'url' => '#',
                    'permission' => array('system' => 'options'),
                    'description' => $this->language->translate('HL_OPTIONS'),
                    'icon' => 'fa fa-cog',
                    'class' => 'fpcm-navigation-noclick',
                    'id' => 'fpcm-options-submenu',
                    'submenu' => $this->optionSubmenu()
                ])
            ),
            'modules' => array(
                navigationItem::createItemFromArray([
                    'url' => '#',
                    'permission' => array('system' => 'options', 'modules' => 'configure'),
                    'description' => $this->language->translate('HL_MODULES'),
                    'icon' => 'fa fa-plug',
                    'class' => 'fpcm-navigation-noclick',
                    'submenu' => $this->modulesSubmenu()
                ])
            ),
//            'help' => array(
//                navigationItem::createItemFromArray([
//                    'url' => 'system/help',
//                    'description' => $this->language->translate('HL_HELP'),
//                    'icon' => 'fa fa-question-circle'
//                ])
//            ),
            'after' => []
        ]);
    }

    /**
     * Erzeugt Submenü für News bearbeiten
     * @return array
     */
    private function editorSubmenu()
    {
        return [
            navigationItem::createItemFromArray([
                'url' => 'articles/listall',
                'permission' => array('article' => 'edit', 'article' => 'editall'),
                'description' => $this->language->translate('HL_ARTICLE_EDIT_ALL'),
                'icon' => 'fa fa-book fa-fw'
            ]),
            navigationItem::createItemFromArray([
                'url' => 'articles/listactive',
                'permission' => array('article' => 'edit'),
                'description' => $this->language->translate('HL_ARTICLE_EDIT_ACTIVE'),
                'icon' => 'far fa-newspaper fa-fw'
            ]),
            navigationItem::createItemFromArray([
                'url' => 'articles/listarchive',
                'permission' => array('article' => 'edit', 'article' => 'editall', 'article' => 'archive'),
                'description' => $this->language->translate('HL_ARTICLE_EDIT_ARCHIVE'),
                'icon' => 'fa fa-archive fa-fw'
            ]),
            navigationItem::createItemFromArray([
                'url' => 'articles/trash',
                'permission' => array('article' => 'delete'),
                'description' => $this->language->translate('ARTICLES_TRASH'),
                'icon' => 'far fa-trash-alt fa-fw'
            ])
        ];
    }

    /**
     * Erzeugt Optionen-Submenü
     * @return array
     */
    private function optionSubmenu()
    {
        $data = array(
            navigationItem::createItemFromArray([
                'url' => 'system/options',
                'permission' => array('system' => 'options'),
                'description' => $this->language->translate('HL_OPTIONS_SYSTEM'),
                'icon' => 'fa fa-cog fa-fw'
            ]),
            navigationItem::createItemFromArray([
                'url' => 'users/list',
                'permission' => array('system' => 'users', 'system' => 'rolls'),
                'description' => $this->language->translate('HL_OPTIONS_USERS'),
                'id' => 'nav-item-users',
                'icon' => 'fa fa-users fa-fw'
            ]),
            navigationItem::createItemFromArray([
                'url' => 'ips/list',
                'permission' => array('system' => 'ipaddr'),
                'description' => $this->language->translate('HL_OPTIONS_IPBLOCKING'),
                'id' => 'nav-item-ips',
                'icon' => 'fa fa-globe fa-fw'
            ]),
            navigationItem::createItemFromArray([
                'url' => 'wordban/list',
                'permission' => array('system' => 'wordban'),
                'description' => $this->language->translate('HL_OPTIONS_WORDBAN'),
                'id' => 'nav-item-wordban',
                'icon' => 'fa fa-ban fa-fw'
            ]),
            navigationItem::createItemFromArray([
                'url' => 'categories/list',
                'permission' => array('system' => 'categories'),
                'description' => $this->language->translate('HL_CATEGORIES_MNG'),
                'id' => 'nav-item-categories',
                'icon' => 'fa fa-tags fa-fw'
            ]),
            navigationItem::createItemFromArray([
                'url' => 'templates/templates',
                'permission' => array('system' => 'templates'),
                'description' => $this->language->translate('HL_OPTIONS_TEMPLATES'),
                'icon' => 'fa fa-code fa-fw'
            ]),
            navigationItem::createItemFromArray([
                'url' => 'smileys/list',
                'permission' => array('system' => 'smileys'),
                'description' => $this->language->translate('HL_OPTIONS_SMILEYS'),
                'id' => 'nav-item-smileys',
                'icon' => 'far fa-smile fa-fw'
            ]),
            navigationItem::createItemFromArray([
                'url' => 'system/crons',
                'permission' => array('system' => 'crons'),
                'description' => $this->language->translate('HL_CRONJOBS'),
                'icon' => 'fa fa-history fa-fw'
            ]),
            navigationItem::createItemFromArray([
                'url' => 'system/logs',
                'permission' => array('system' => 'logs'),
                'description' => $this->language->translate('HL_LOGS'),
                'icon' => 'fa fa-exclamation-triangle fa-fw'
            ])
        );

        if (\fpcm\classes\loader::getObject('\fpcm\classes\database')->getDbtype() == \fpcm\classes\database::DBTYPE_MYSQLMARIADB) {
            $data[] = navigationItem::createItemFromArray([
                        'url' => 'system/backups',
                        'permission' => array('system' => 'backups'),
                        'description' => $this->language->translate('HL_BACKUPS'),
                        'icon' => 'fa fa-life-ring fa-fw'
            ]);
        }

        return $data;
    }

    /**
     * Erzeugt Submenü in Module
     * @return array
     */
    private function modulesSubmenu()
    {

        $items = array(
            navigationItem::createItemFromArray([
                'url' => 'modules/list',
                'permission' => ['modules' => ['install', 'uninstall', 'configure', 'enable']],
                'description' => $this->language->translate('HL_MODULES_MNG'),
                'icon' => 'fa fa-plug fa-fw'
            ])
        );

        $eventResult = $this->events->trigger('navigation\addSubmenuModules', $items);
        if (count($eventResult) == count($items)) {
            return $items;
        }

        $eventResult[0]->setSpacer(true);

        return $eventResult;
    }

}
