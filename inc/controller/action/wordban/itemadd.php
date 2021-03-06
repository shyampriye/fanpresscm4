<?php

/**
 * Wordban item add controller
 * @item Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\controller\action\wordban;

class itemadd extends \fpcm\controller\abstracts\controller implements \fpcm\controller\interfaces\isAccessible {

    protected $item;

    /**
     * 
     * @return bool
     */
    public function isAccessible(): bool
    {
        return $this->permissions->system->wordban;
    }

    protected function getViewPath() : string
    {
        return 'wordban/itemadd';
    }

    protected function getHelpLink()
    {
        return 'HL_OPTIONS_WORDBAN';
    }

    protected function getActiveNavigationElement()
    {
        return 'submenu-itemnav-item-wordban';
    }

    public function request()
    {
        $this->item = new \fpcm\model\wordban\item();
        $this->save();
        return true;
    }

    public function process()
    {
        $this->view->assign('item', $this->item);
        $this->view->setFieldAutofocus('wbitemsearchtext');
        $this->view->setFormAction('wordban/add');
        $this->view->addButton(new \fpcm\view\helper\saveButton('wbitemSave'));
        $this->view->addJsFiles(['texts.js']);
        $this->view->render();
    }

    private function save()
    {
        if (!$this->buttonClicked('wbitemSave')) {
            return true;
        }
        
        if (!$this->checkPageToken()) {
            $this->view->addErrorMessage('CSRF_INVALID');
            return true;
        }

        $data = $this->request->fromPOST('wbitem');

        if (!trim($data['searchtext']) || !trim($data['replacementtext'])) {
            $this->view->addErrorMessage('SAVE_FAILED_WORDBAN');
            return true;
        }
        
        $this->item->setSearchtext($data['searchtext']);
        $this->item->setReplacementtext($data['replacementtext']);
        $this->item->setReplaceTxt(isset($data['replacetxt']) ? $data['replacetxt'] : 0);
        $this->item->setLockArticle(isset($data['lockarticle']) ? $data['lockarticle'] : 0);
        $this->item->setCommentApproval(isset($data['commentapproval']) ? $data['commentapproval'] : 0);

        if ($this->item->save() !== true) {
            $this->view->addErrorMessage('SAVE_FAILED_WORDBAN');
            return true;
        }

        $this->redirect('wordban/list', array('added' => 1));
        return true;
    }
}

?>