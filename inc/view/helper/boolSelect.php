<?php

/**
 * FanPress CM 4
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\view\helper;

/**
 * Bool select menu view helper object
 * 
 * @package fpcm\view\helper
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
final class boolSelect extends select {

    /**
     * Optional init function
     * @return void
     */
    protected function init()
    {
        parent::init();
        $this->class .= ' fpcm-ui-input-boolselect';
        $this->firstOption = self::FIRST_OPTION_DISABLED;
        $this->setOptions([
            'GLOBAL_YES' => 1,
            'GLOBAL_NO' => 0
        ]);
    }

}

?>