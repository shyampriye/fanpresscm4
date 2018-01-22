<?php
    /**
     * Temp file object
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2018, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace fpcm\model\files;

    /**
     * Temp file object
     * 
     * @package fpcm\model\files
     * @author Stefan Seehafer <sea75300@yahoo.de>
     */
    final class tempfile extends \fpcm\model\abstracts\file {

        /**
         * Konstruktor
         * @param string $filename Dateiname
         * @param string $content Dateiinhalt
         */
        public function __construct($filename = '') {
            parent::__construct(\fpcm\classes\dirs::getDataDirPath(\fpcm\classes\dirs::DATA_TEMP, md5($filename).'.tmp'));
            
            $this->init();
        }
        
        /**
         * Speichert eine neue temporäre Datei in data/temp/
         * @return bool
         */
        public function save() {
            if ($this->exists()) $this->delete ();
            return file_put_contents($this->fullpath, $this->content);            
        }
        
        /**
         * Initialisiert Objekt einer temporären Datei
         * @return void
         */
        public function init() {
            
            if (!$this->exists()) return;
            
            $this->content = file_get_contents($this->fullpath);
            
        }
    }
?>