<?php

/**
 * FanPress CM 4.x
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\module;

/**
 * Module tools trait
 * 
 * @package fpcm\module\tools
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2020, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 * @since FPCM 4.4
 */
trait tools {

    /**
     * Get module object instance
     * @param type $key
     * @return \fpcm\module\module
     */
    final protected function getObject(string $key = '', bool $initDb = true) : module
    {
        if (!trim($key)) {
            $key = $this->getModuleKey();
        }

        return new module($key, $initDb);
    }

    /**
     * Returns modul key based on current class
     * @return string
     */
    final protected function getModuleKey() : string
    {
        $class = get_class($this);
        $stack = \fpcm\classes\loader::stackPull('modulekeys');
        if (isset($stack[$class])) {
            return $stack[$class];
        }

        $stack[$class] = \fpcm\module\module::getKeyFromClass($class);
        \fpcm\classes\loader::stackPush('modulekeys', $stack);
        return $stack[$class];
    }

    /**
     * Returns language variable with module prefix
     * @param string $var
     * @return string
     */
    protected function addLangVarPrefix($var) : string
    {
        return \fpcm\module\module::getLanguageVarPrefixed($this->getModuleKey()).strtoupper($var);
    }

    /**
     * Additional initialize process after @see self::__construct
     * @return boolean
     */
    protected function initConstruct() : bool
    {
        return true;
    }

}
