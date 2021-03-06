<?php

/**
 * FanPress CM 4.x
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\classes;

/**
 * Cache system
 * 
 * @package fpcm\classes\cache
 * @author Stefan Seehafer aka imagine <fanpress@nobody-knows.org>
 * @copyright (c) 2011-2020, Stefan Seehafer
 */
final class cache {

    const CLEAR_ALL = '*';

    /**
     * Crypt Object
     * @var crypt
     */
    private $crypt;

    /**
     * Basis-Pfad für Cache
     * @var string
     */
    private $basePath;

    /**
     * Konstruktor
     * @return void
     */
    public function __construct()
    {
        $this->crypt = loader::getObject('\fpcm\classes\crypt');
        $this->basePath = dirs::getDataDirPath(dirs::DATA_CACHE);

        if (!isset($GLOBALS['fpcm']['stack'])) {
            $GLOBALS['fpcm']['stack'] = [];
        }
    }

    /**
     * Ist Cache-Inhalt veraltet
     * @param string $cacheName Cache-Name
     * @return bool
     */
    public function isExpired($cacheName)
    {
        if (defined('FPCM_INSTALLER_NOCACHE') && FPCM_INSTALLER_NOCACHE) {
            return true;
        }

        $file = new \fpcm\model\files\cacheFile($cacheName);
        return $file->expires() <= time() ? true : false;
    }

    /**
     * Cache-Inhalt schreiben
     * @param string $cacheName Cache-Name
     * @param mixed $data
     * @param int $expires
     * @return bool
     */
    public function write($cacheName, $data, $expires = 0)
    {
        if (defined('FPCM_INSTALLER_NOCACHE') && FPCM_INSTALLER_NOCACHE) {
            return false;
        }

        $file = new \fpcm\model\files\cacheFile($cacheName);
        return $file->write($data, $expires ? $expires : FPCM_CACHE_DEFAULT_TIMEOUT);
    }

    /**
     * Cache-Inhalt lesen
     * @param string $cacheName Cache-Name
     * @return string
     * @return mixed
     */
    public function read($cacheName)
    {
        if (defined('FPCM_INSTALLER_NOCACHE') && FPCM_INSTALLER_NOCACHE) {
            return false;
        }

        $file = new \fpcm\model\files\cacheFile($cacheName);
        $content = $file->read();

        return substr($content, 0, 2) == 'a:' || substr($content, 0, 2) == 'o:' ? unserialize($content) : $content;
    }

    /**
     * Cache-Inhalt lesen
     * @param string $cacheName Cache-Name
     * @return string
     */
    public function getExpirationTime($cacheName)
    {
        if (defined('FPCM_INSTALLER_NOCACHE') && FPCM_INSTALLER_NOCACHE)
            return false;

        $file = new \fpcm\model\files\cacheFile($cacheName);
        return $file->expires();
    }

    /**
     * Cachew bereinigen
     * @param string $cacheName
     * @return bool
     */
    public function cleanup($cacheName = null)
    {
        $isModuleCleanup = substr($cacheName, -1) === \fpcm\classes\cache::CLEAR_ALL ? true : false;
        if ($cacheName !== null && !$isModuleCleanup) {
            $file = new \fpcm\model\files\cacheFile($cacheName);
            return $file->cleanup();
        }

        if ($isModuleCleanup) {
            $cacheName = strtolower(substr($cacheName, 0, -2));
            if (!defined('FPCM_CACHEMODULE_DEBUG') || !FPCM_CACHEMODULE_DEBUG) {
                $cacheName = md5($cacheName);
            }

            $cacheFiles = glob($this->basePath . DIRECTORY_SEPARATOR . $cacheName . DIRECTORY_SEPARATOR . '*' . \fpcm\model\files\cacheFile::EXTENSION_CACHE);
        } else {
            $cacheFiles = $this->getCacheComplete();
        }

        if (!is_array($cacheFiles) || !count($cacheFiles)) {
            return false;
        }

        foreach ($cacheFiles as $cacheFile) {

            if (!file_exists($cacheFile)) {
                continue;
            }

            if (!is_writable($cacheFile)) {
                trigger_error('Unable to delete cache file '.$cacheFile.', cache file is not writable.');
                continue;
            }

            unlink($cacheFile);
        }

        return true;
    }

    /**
     * Gibt aktuelle Größe des Caches in byte zurück
     * @return int
     */
    public function getSize()
    {
        return array_sum(array_map('filesize', $this->getCacheComplete()));
    }

    /**
     * Liefert alle *.cache-Dateien in cache-ordner zurück
     * @return array
     * @since FPCM 3.4
     */
    public function getCacheComplete()
    {
        return array_merge(glob($this->basePath . '/*' . \fpcm\model\files\cacheFile::EXTENSION_CACHE), glob($this->basePath . '/*/*' . \fpcm\model\files\cacheFile::EXTENSION_CACHE));
    }

}
