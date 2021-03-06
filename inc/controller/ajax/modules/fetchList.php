<?php

/**
 * FanPress CM 4.x
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\controller\ajax\modules;

/**
 * AJAX-Controller der die Aktionen im Module-Manager ausführt
 * 
 * @package fpcm\controller\ajax\modules\moduleactions
 * @author Stefan Seehafer <sea75300@yahoo.de>
 */
class fetchList extends \fpcm\controller\abstracts\ajaxController implements \fpcm\controller\interfaces\isAccessible {

    use \fpcm\controller\traits\common\dataView;

    /**
     *
     * @var int
     */
    protected $tab;

    /**
     *
     * @var string
     */
    protected $mode;

    /**
     *
     * @var \fpcm\module\modules
     */
    protected $modules;

    /**
     *
     * @var array
     */
    protected $installed;

    /**
     *
     * @var array
     */
    protected $permArr = [];

    public function isAccessible(): bool
    {
        return $this->permissions->system->options && $this->permissions->modules->configure;
    }

    /**
     * 
     * @return string
     */
    protected function getViewPath() : string
    {
        return '';
    }

    /**
     * Request-Handler
     * @return bool
     */
    public function request()
    {
        $this->response = new \fpcm\model\http\response;

        $this->mode = $this->request->fromGET('mode', [
            \fpcm\model\http\request::FILTER_FIRSTUPPER
        ]);

        $fn = 'fetch'.$this->mode;
        if (!method_exists($this, $fn)) {
            $this->response->setReturnData([ 'exec' => 0 ])->fetch();
        }

        return call_user_func([$this, $fn]);
    }

    /**
     * Controller-Processing
     */
    public function process()
    {
        $this->initDataView();
        
        $dvVars = $this->dataView->getJsVars();
        $dbName = $this->getDataViewName();
        
        $this->response->setReturnData([
            'dataViewVars' => $dvVars['dataviews'][$dbName],
            'dataViewName' => $dbName,
            'loadTab' => $this->tab
        ])->fetch();

    }

    /**
     * 
     * @return bool
     */
    private function fetchLocal()
    {
        $this->tab = 0;
        $this->modules->updateFromFilesystem();
        $this->items = $this->modules->getFromDatabase(true);
        $this->itemsCount = count($this->items);
        return true;
    }

    /**
     * 
     * @return bool
     */
    private function fetchRemote()
    {
        $this->tab = 1;
        $this->installed = $this->modules->getKeysFromDatabase();
        $this->items = $this->modules->getFromRepository();
        $this->itemsCount = count($this->items);
        return true;
    }

    /**
     * 
     * @return string
     */
    protected function getDataViewName()
    {
        return 'modules'.$this->mode;
    }

    /**
     * 
     * @return array
     */
    protected function getDataViewCols()
    {
        $fn = 'getCols'.$this->mode;
        if (!method_exists($this, $fn)) {
            $this->returnData['exec'] = 0;
            $this->getSimpleResponse();
        }        
        
        return call_user_func([$this, $fn]);
    }

    /**
     * 
     * @return array
     */
    private function getColsLocal()
    {
        return [
            (new \fpcm\components\dataView\column('buttons', ''))->setAlign('center')->setSize(3),
            (new \fpcm\components\dataView\column('description', 'MODULES_LIST_NAME'))->setAlign('center')->setSize(4),
            (new \fpcm\components\dataView\column('key', 'MODULES_LIST_KEY'))->setAlign('center')->setSize(4),
            (new \fpcm\components\dataView\column('version', 'MODULES_LIST_VERSION_LOCAL'))->setAlign('center')->setSize(1)
        ];
    }

    /**
     * 
     * @return array
     */
    private function getColsRemote()
    {
        return [
            (new \fpcm\components\dataView\column('buttons', ''))->setAlign('center')->setSize(3),
            (new \fpcm\components\dataView\column('description', 'MODULES_LIST_NAME'))->setAlign('center')->setSize(4),
            (new \fpcm\components\dataView\column('key', 'MODULES_LIST_KEY'))->setAlign('center')->setSize(4),
            (new \fpcm\components\dataView\column('version', 'MODULES_LIST_VERSION_REMOTE'))->setAlign('center')->setSize(1)
        ];
    }

    /**
     * 
     * @param \fpcm\module\module $item
     * @return \fpcm\components\dataView\row
     */
    protected function initDataViewRow($item)
    {
        $fn = 'initRow'.$this->mode;
        if (!method_exists($this, $fn)) {
            $this->returnData['exec'] = 0;
            $this->getSimpleResponse();
        }        

        return call_user_func([$this, $fn], $item);
    }

    /**
     * 
     * @param \fpcm\module\module $item
     * @return \fpcm\components\dataView\row
     */
    protected function initRowLocal($item)
    {
        $config = $item->getConfig();
        
        $key = $config->key;
        $hash = \fpcm\classes\tools::getHash($key);
        
        $buttons = [];        
        if (!$item->isInstallable()) {
            $buttons[] = (new \fpcm\view\helper\icon('project-diagram'))->setText('MODULES_FAILED_DEPENCIES')->setClass('fpcm-ui-padding-lg-right fpcm-ui-important-text')->setSize('lg');
        }

        if (!$item->hasFilesListFile()) {
            $buttons[] = (new \fpcm\view\helper\icon('exclamation-triangle'))->setText('UPDATE_VERSIONCECK_FILETXT_ERR2')->setClass('fpcm-ui-padding-lg-right fpcm-ui-important-text')->setSize('lg');
        }

        if (!$item->isWritable()) {
            $buttons[] = (new \fpcm\view\helper\icon('times-circle'))->setText('MODULES_FAILED_FSWRITE')->setClass('fpcm-ui-padding-lg-right fpcm-ui-important-text')->setSize('lg');
        }

        $buttons[] = (new \fpcm\view\helper\linkButton('info'.$hash))
                            ->setText('MODULES_LIST_INFORMATIONS')
                            ->setIcon('info-circle')
                            ->setClass('fpcm-ui-modulelist-info')
                            ->setIconOnly(true)
                            ->setUrl($this->getControllerLink('modules/info', ['key' => $item->getKey()]));

        $hasUpdates = $this->permissions->modules->install && $item->hasUpdates();
        $hasLocalUpdates = $this->permissions->modules->install && $item->hasLocalUpdates();
        if ($item->isInstalled()) {

            if ($this->permissions->modules->configure) {
                
                if ($item->isActive()) {
                    
                    if ($item->hasConfigure()) {
                        $buttons[]  = (new \fpcm\view\helper\linkButton('configure'.$hash))
                                        ->setText('MODULES_LIST_CONFIGURE')
                                        ->setIcon('cogs')
                                        ->setIconOnly(true)
                                        ->setClass('fpcm-ui-modulelist-action-local')
                                        ->setUrl(\fpcm\classes\tools::getFullControllerLink('modules/configure', ['key' => $item->getKey()]));
                    }
                    
                    $buttons[]  = (new \fpcm\view\helper\button('disable'.$hash))->setText('MODULES_LIST_DISABLE')->setIcon('toggle-off')->setIconOnly(true)->setData(['key' => $item->getKey(), 'action' => 'disable'])->setClass('fpcm-ui-modulelist-action-local');
                }
                else {
                    
                    $buttons[]  = (new \fpcm\view\helper\button('enable'.$hash))->setText('MODULES_LIST_ENABLE')->setIcon('toggle-on')->setIconOnly(true)->setData(['key' => $item->getKey(), 'action' => 'enable'])->setClass('fpcm-ui-modulelist-action-local');
                }
                
            }

            if ($this->permissions->modules->uninstall && !$item->isActive() && $item->isWritable()) {
                $buttons[] = (new \fpcm\view\helper\button('uninstall'.$hash))->setText('MODULES_LIST_UNINSTALL')->setIcon('minus-circle')->setIconOnly(true)->setData(['key' => $item->getKey(), 'action' => 'uninstall'])->setClass('fpcm-ui-modulelist-action-local');
            }

            if ($hasUpdates) {
                $buttons[] = (new \fpcm\view\helper\linkButton('update'.$hash))
                        ->setUrl(\fpcm\classes\tools::getFullControllerLink('package/modupdate', ['key' => $item->getKey()]))
                        ->setText('MODULES_LIST_UPDATE')
                        ->setIcon('sync')
                        ->setIconOnly(true)
                        ->setClass('fpcm-ui-modulelist-action-local-update');
            }

            if ($hasLocalUpdates && !$hasUpdates) {
                $buttons[] = (new \fpcm\view\helper\linkButton('update'.$hash))
                    ->setUrl(\fpcm\classes\tools::getFullControllerLink('package/modupdate', ['key' => $item->getKey(), 'update-db' => 1]))
                    ->setText('MODULES_LIST_UPDATE')
                    ->setIcon('sync')
                    ->setIconOnly(true)
                    ->setClass('fpcm-ui-modulelist-action-local-update');
            }
        }
        
        if (!$item->isInstalled()) {
            if ($this->permissions->modules->install) {
                $buttons[] = (new \fpcm\view\helper\button('install'.$hash))->setText('MODULES_LIST_INSTALL')->setIcon('plus-circle')->setIconOnly(true)->setData(['key' => $item->getKey(), 'action' => 'install', 'dir' => true])->setClass('fpcm-ui-modulelist-action-local')->setReadonly(!$item->isInstallable());
            }            

            if ($this->permissions->modules->uninstall && $item->isWritable()) {
                $buttons[] = (new \fpcm\view\helper\button('delete'.$hash))->setText('MODULES_LIST_DELETE')->setIcon('trash')->setIconOnly(true)->setData(['key' => $item->getKey(), 'action' => 'delete'])->setClass('fpcm-ui-modulelist-action-local');
            }            
        }

        $class = ($hasUpdates ? 'fpcm-ui-important-text' : '');
        
        return new \fpcm\components\dataView\row([
            new \fpcm\components\dataView\rowCol('buttons', implode('', $buttons)),
            new \fpcm\components\dataView\rowCol('description', new \fpcm\view\helper\escape($config->name ), $class ),
            new \fpcm\components\dataView\rowCol('key', new \fpcm\view\helper\escape($key), $class ),
            new \fpcm\components\dataView\rowCol('version', new \fpcm\view\helper\escape($config->version), $class )
        ]);
    }

    /**
     * 
     * @param \fpcm\module\repoModule $item
     * @return \fpcm\components\dataView\row
     */
    protected function initRowRemote($item)
    {
        $config = $item->getConfig();
        
        $key = $config->key;
        $hash = \fpcm\classes\tools::getHash($key);
        
        $buttons = [];        
        if (!$item->isInstallable()) {
            $buttons[] = (new \fpcm\view\helper\icon('project-diagram'))->setText('MODULES_FAILED_DEPENCIES')->setClass('fpcm-ui-padding-lg-right fpcm-ui-important-text');
        }

        $buttons[] = (new \fpcm\view\helper\linkButton('info'.$hash))
                    ->setText('MODULES_LIST_INFORMATIONS')
                    ->setIcon('info-circle')
                    ->setClass('fpcm-ui-modulelist-info')
                    ->setIconOnly(true)
                    ->setUrl($this->getControllerLink('modules/info', ['key' => $item->getKey(), 'repo' => 1]));

        if ($this->permissions->modules->install && !in_array($item->getKey(), $this->installed) ) {
            $buttons[] = (new \fpcm\view\helper\linkButton('install'.$hash))
                    ->setUrl(\fpcm\classes\tools::getFullControllerLink('package/modinstall', ['key' => $item->getKey()]))
                    ->setText('MODULES_LIST_INSTALL')
                    ->setIcon('plus-circle')
                    ->setIconOnly(true)
                    ->setClass('fpcm-ui-modulelist-action-remote')
                    ->setReadonly(!$item->isInstallable());
        }

        return new \fpcm\components\dataView\row([
            new \fpcm\components\dataView\rowCol('buttons', implode('', $buttons)),
            new \fpcm\components\dataView\rowCol('description', new \fpcm\view\helper\escape($config->name ) ),
            new \fpcm\components\dataView\rowCol('key', new \fpcm\view\helper\escape($key) ),
            new \fpcm\components\dataView\rowCol('version', new \fpcm\view\helper\escape($config->version) )
        ]);
    }

    /**
     * 
     * @return bool
     */
    protected function initActionObjects()
    {
        $this->modules = new \fpcm\module\modules();
        return true;
    }

}

?>
