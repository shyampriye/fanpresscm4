<?php

/**
 * Smiley edit controller
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\controller\action\smileys;

class smileyedit extends smileybase {

    public function process()
    {
        $this->view->assign('tabAction', 'EDIT');
        $this->view->setFormAction('smileys/edit', [
            'id' => $this->smiley->getId()
        ]);
        parent::process();
    }

}

?>
