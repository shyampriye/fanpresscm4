<?php

/**
 * FanPress CM 4.x
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\model\packages;

use fpcm\classes\baseconfig;
use fpcm\model\abstracts\remoteModel;
use fpcm\model\files\fileOption;

/**
 * Repository class
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2011-2020, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
final class repository extends remoteModel {

    const FOPT_UPDATES = 'updates.yml';

    const FOPT_MODULES = 'modules.yml';

    /**
     * Repository check sources
     * @var array
     */
    private $files = [];

    /**
     * Current repo source
     * @var string
     */
    private $current = '';

    /**
     * Konstruktor
     * @return bool
     */
    public function __construct()
    {
        parent::__construct();

        $minorVer = $this->config->getVersionNumberString();

        $this->files = [
            baseconfig::$updateServer.'release.yml' => self::FOPT_UPDATES,
            baseconfig::$updateServer.'release'.$minorVer.'.yml' => self::FOPT_UPDATES,
            baseconfig::$moduleServer.'release.yml' => self::FOPT_MODULES,
            baseconfig::$moduleServer.'release'.$minorVer.'.yml' => self::FOPT_MODULES
        ];

        return true;
    }
    
    /**
     * Fetchs data from remote repository source
     * @param bool $cliOutput
     * @return bool
     */
    public function fetchRemoteData($cliOutput = false)
    {
        clearstatcache();
        foreach ($this->files as $rem => $local) {

            if ($cliOutput) {
                \fpcm\model\cli\io::output('Fetch package information from '.$rem.'...');
            }
            else {
                fpcmLogCron('Fetch package information from '.$rem);
            }

            if (strpos(get_headers($rem)[0], 'HTTP/1.1 404 Not Found') !== false) {
                continue;
            }

            $this->remoteServer = $rem;
            $this->current      = $local;

            $success = parent::fetchRemoteData();
            
            if ($cliOutput && $success !== true) {
                \fpcm\model\cli\io::output('Error while retrieving information from '.$rem.'!', true);
            }

            if ($success !== true) {
                return $success;
            }

            if ($cliOutput) {
                \fpcm\model\cli\io::output('Update local package information storage...');
            }

            if (!$this->saveRemoteData()) {
                if ($cliOutput) {
                    \fpcm\model\cli\io::output('Error during update of package information storage!');
                }
                
                return false;
            }
            
            if ($cliOutput) {
                \fpcm\model\cli\io::output('Update check finished successfully!');
            }
        }

        return true;
    }

    /**
     * Writes remote repository data to local storage
     * @return bool
     */
    protected function saveRemoteData()
    {
        $storage = new fileOption($this->current);
        return $storage->write($this->remoteData);
    }

}

?>