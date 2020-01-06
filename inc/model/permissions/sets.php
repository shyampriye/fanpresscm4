<?php

/**
 * FanPress CM 4.x
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\model\permissions;

/**
 * Permission sets
 * 
 * @package fpcm\model\permissions
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2011-2020, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 * @since FPCM 4.4
 */
class sets {

    final public static function getDefault() : array 
    {
        return [
            'article' => (new items\article(null))->getDefault(),
            'comment' => (new items\comment(null))->getDefault(),
            'system'  => (new items\system(null))->getDefault(),
            'uploads' => (new items\uploads(null))->getDefault(),
            'modules' => (new items\modules(null))->getDefault()
        ];
    }

    final public static function getAllFalse() : array 
    {
        return [
            'article' => (new items\article(null))->getAllFalse(),
            'comment' => (new items\comment(null))->getAllFalse(),
            'system'  => (new items\system(null))->getAllFalse(),
            'uploads' => (new items\uploads(null))->getAllFalse(),
            'modules' => (new items\modules(null))->getAllFalse()
        ];
    }
    
}
