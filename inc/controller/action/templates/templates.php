<?php

/**
 * Template controller
 * @author Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2011-2018, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

namespace fpcm\controller\action\templates;

class templates extends \fpcm\controller\abstracts\controller {

    /**
     *
     * @var \fpcm\model\pubtemplates\article
     */
    protected $articleTemplate;

    /**
     *
     * @var \fpcm\model\pubtemplates\article
     */
    protected $articleSingleTemplate;

    /**
     *
     * @var \fpcm\model\pubtemplates\comment
     */
    protected $commentTemplate;

    /**
     *
     * @var \fpcm\model\pubtemplates\commentform
     */
    protected $commentFormTemplate;

    /**
     *
     * @var \fpcm\model\pubtemplates\latestnews
     */
    protected $latestNewsTemplate;

    /**
     *
     * @var \fpcm\model\pubtemplates\tweet
     */
    protected $tweetTemplate;

    /**
     * 
     * @return array
     */
    protected function getPermissions()
    {
        return ['system' => 'templates'];
    }

    /**
     * 
     * @return string
     */
    protected function getViewPath()
    {
        return 'templates/overview';
    }

    /**
     * 
     * @return string
     */
    protected function getHelpLink()
    {
        return 'HL_OPTIONS_TEMPLATES';
    }

    /**
     * Request-Handler
     * @return boolean
     */
    public function request()
    {
        $editor = new \fpcm\components\editor\htmlEditor();

        $this->view->addCssFiles($editor->getCssFiles());

        $jsFiles = $editor->getJsFiles();
        $this->view->addJsFiles($jsFiles);

        $this->articleTemplate = new \fpcm\model\pubtemplates\article($this->config->articles_template_active);

        if ($this->config->articles_template_active != $this->config->article_template_active) {
            $this->articleSingleTemplate = new \fpcm\model\pubtemplates\article($this->config->article_template_active);
        }

        $this->commentTemplate = new \fpcm\model\pubtemplates\comment($this->config->comments_template_active);
        $this->commentFormTemplate = new \fpcm\model\pubtemplates\commentform();
        $this->latestNewsTemplate = new \fpcm\model\pubtemplates\latestnews();
        $this->tweetTemplate = new \fpcm\model\pubtemplates\tweet();

        if ($this->buttonClicked('uploadFile') && \fpcm\classes\http::getFiles()) {
            $uploader = new \fpcm\model\files\fileuploader(\fpcm\classes\http::getFiles());
            $res = $uploader->processArticleTemplateUpload();

            if ($res == true) {
                $this->view->addNoticeMessage('SAVE_SUCCESS_UPLOADTPLFILE');
            } else {
                $this->view->addErrorMessage('SAVE_FAILED_UPLOADTPLFILE');
            }

            return true;
        }

        $delFiles = $this->getRequestVar('deltplfiles', [
            \fpcm\classes\http::FILTER_BASE64DECODE
        ]);
        if ($this->buttonClicked('fileDelete') && is_array($delFiles) && count($delFiles)) {

            $deletedOk = [];
            $deletedFailed = [];

            foreach ($delFiles as $delFile) {

                $articleTplFile = new \fpcm\model\files\templatefile($delFile);
                if (!$articleTplFile->delete()) {
                    $deletedFailed[] = \fpcm\model\files\ops::removeBaseDir($delFile);
                    continue;
                }

                $deletedOk[] = \fpcm\model\files\ops::removeBaseDir($delFile);
            }

            if (count($deletedOk)) {
                $this->view->addNoticeMessage('DELETE_SUCCESS_FILES', array('{{filenames}}' => implode(', ', $deletedOk)));
            }
            if (count($deletedFailed)) {
                $this->view->addErrorMessage('DELETE_FAILED_FILES', array('{{filenames}}' => implode(', ', $deletedFailed)));
            }

            return true;
        }

        if ($this->buttonClicked('saveTemplates') && !is_null($this->getRequestVar('template'))) {

            $this->cache->cleanup();

            $templateContents = $this->getRequestVar('template', [
                \fpcm\classes\http::FILTER_TRIM,
                \fpcm\classes\http::FILTER_STRIPSLASHES
            ]);

            $tplSaveError = [];
            $tplSaveOk = [];
            foreach ($templateContents as $templateName => $newContent) {
                $tplObj = $this->{$templateName . 'Template'};
                $tplObj->setContent($newContent);

                $res = $tplObj->save();

                if (is_null($res) && $templateName == 'commentForm') {
                    $this->view->addErrorMessage('SAVE_FAILED_TEMPLATE_CF_URLMISSING');
                } elseif (!$res) {
                    $tplSaveError[] = $tplObj->getFilename();
                } else {
                    $tplSaveOk[] = $tplObj->getFilename();
                }
            }

            if (count($tplSaveError)) {
                $this->view->addErrorMessage('SAVE_FAILED_TEMPLATE', array('{{filenames}}' => implode(', ', $tplSaveError)));
            }

            if (count($tplSaveOk)) {
                $this->view->addNoticeMessage('SAVE_SUCCESS_TEMPLATE', array('{{filenames}}' => implode(', ', $tplSaveOk)));
            }
        }

        return true;
    }

    /**
     * Controller-Processing
     * @return boolean
     */
    public function process()
    {
        $this->view->assign('replacementsArticle', $this->articleTemplate->getReplacementTranslations('TEMPLATE_ARTICLE_'));
        $this->view->assign('contentArticle', $this->articleTemplate->getContent());

        if ($this->config->articles_template_active != $this->config->article_template_active) {
            $this->view->assign('replacementsArticleSingle', $this->articleSingleTemplate->getReplacementTranslations('TEMPLATE_ARTICLE_'));
            $this->view->assign('contentArticleSingle', $this->articleSingleTemplate->getContent());
        }

        $this->view->assign('replacementsComment', $this->commentTemplate->getReplacementTranslations('TEMPLATE_COMMMENT_'));
        $this->view->assign('contentComment', $this->commentTemplate->getContent());

        $this->view->assign('replacementsCommentForm', $this->commentFormTemplate->getReplacementTranslations('TEMPLATE_COMMMENTFORM_'));
        $this->view->assign('contentCommentForm', $this->commentFormTemplate->getContent());

        $this->view->assign('replacementsLatestNews', $this->latestNewsTemplate->getReplacementTranslations('TEMPLATE_ARTICLE_'));
        $this->view->assign('contentLatestNews', $this->latestNewsTemplate->getContent());

        $this->view->assign('replacementsTweet', $this->tweetTemplate->getReplacementTranslations('TEMPLATE_ARTICLE_'));
        $this->view->assign('contentTweet', $this->tweetTemplate->getContent());

        $this->view->assign('allowedTags', htmlentities($this->articleTemplate->getAllowedTags(', ')));

        $this->view->addJsVars(['templateId' => 1, 'jqUploadInit' => 0]);
        $this->view->addJsLangVars(['HL_TEMPLATE_PREVIEW', 'TEMPLATE_HL_DRAFTS_EDIT']);
        $this->view->addJsFiles(['fileuploader.js', 'templates.js']);

        $this->initDataView();
        
        $translInfo = array(
            '{{filecount}}' => 1,
            '{{filesize}}' => \fpcm\classes\tools::calcSize(\fpcm\classes\baseconfig::uploadFilesizeLimit(true), 0)
        );
        $this->view->assign('maxFilesInfo', $this->lang->translate('FILE_LIST_PHPMAXINFO', $translInfo));
        $this->view->assign('actionPath', \fpcm\classes\tools::getFullControllerLink('modules/list'));
        $this->view->assign('styleLeftMargin', true);

        $this->view->setFormAction('templates/templates');
        $this->view->addButtons([
            (new \fpcm\view\helper\button('showpreview', 'showpreview'))->setText('GLOBAL_PREVIEW')->setIcon('eye')->setClass('fpcm-ui-maintoolbarbuttons-tab1'),
            (new \fpcm\view\helper\saveButton('saveTemplates', 'save1'))->setClass('fpcm-ui-maintoolbarbuttons-tab1 fpcm-ui-button-confirm'),
            (new \fpcm\view\helper\saveButton('saveTemplates', 'save2'))->setClass('fpcm-ui-maintoolbarbuttons-tab2 fpcm-ui-button-confirm fpcm-ui-hidden'),
            (new \fpcm\view\helper\deleteButton('fileDelete'))->setClass('fpcm-ui-maintoolbarbuttons-tab3 fpcm-ui-button-confirm fpcm-ui-hidden')
        ]);

        $this->view->render();
    }
    
    private function initDataView()
    {
        $tplfilelist = new \fpcm\model\files\templatefilelist();

        $dataView = new \fpcm\components\dataView\dataView('draftfiles');
        $dataView->addColumns([
            (new \fpcm\components\dataView\column('select', ''))->setSize('05')->setAlign('center'),
            (new \fpcm\components\dataView\column('button', ''))->setSize(2)->setAlign('center'),
            new \fpcm\components\dataView\column('filename', 'FILE_LIST_FILENAME'),
            (new \fpcm\components\dataView\column('filesize', 'FILE_LIST_FILESIZE'))->setSize(2)
        ]);
        
        $items = $tplfilelist->getFolderObjectList();
        if (!count($items)) {

            $dataView->addRow(
                new \fpcm\components\dataView\row([
                    new \fpcm\components\dataView\rowCol('col', 'GLOBAL_NOTFOUND2', 'fpcm-ui-padding-md-lr'),
                ],
                '',
                false,
                true
            ));
            
            $this->view->addDataView($dataView);
            return true;
        }

        /* @var $templateFile \fpcm\model\files\tempfile */
        foreach ($items as $templateFile) {

            $buttons = [
                '<div class="fpcm-ui-controlgroup">',
                (new \fpcm\view\helper\linkButton(uniqid()))->setText('GLOBAL_DOWNLOAD')->setUrl($templateFile->getFileUrl())->setIcon('download')->setIconOnly(true)->setTarget('_blank'),
                (new \fpcm\view\helper\editButton(uniqid()))->setUrlbyObject($templateFile)->setClass('fpcm-articletemplates-edit'),
                '</div>'
            ];

            $dataView->addRow(new \fpcm\components\dataView\row([
                new \fpcm\components\dataView\rowCol('select', (new \fpcm\view\helper\checkbox('deltplfiles[]', 'chbx' . md5($templateFile->getFilename()) ))->setClass('fpcm-ui-list-checkbox')->setValue(base64_encode($templateFile->getFilename())), '', \fpcm\components\dataView\rowCol::COLTYPE_ELEMENT),
                new \fpcm\components\dataView\rowCol('button', implode('', $buttons) ),
                new \fpcm\components\dataView\rowCol('filename', new \fpcm\view\helper\escape($templateFile->getFilename()) ),
                new \fpcm\components\dataView\rowCol('filesize', \fpcm\classes\tools::calcSize($templateFile->getFilesize()) )
            ]));
        }
        
        $this->view->addDataView($dataView);
    }
}

?>
