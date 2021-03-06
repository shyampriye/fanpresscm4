<?php /* @var $theView \fpcm\view\viewVars */ ?>
<div>
    <div class="row py-3">
        <div class="col-sm-12 col-md-4">
            <b><?php $theView->write('MODULES_LIST_NAME'); ?>:</b>
        </div>
        <div class="col-sm-12 col-md-8"><?php print $theView->escape($moduleName); ?></div>
    </div>

    <div class="row py-3">
        <div class="col-sm-12 col-md-4">
            <b><?php $theView->write('MODULES_LIST_VERSION_REMOTE'); ?>:</b>
        </div>
        <div class="col-sm-12 col-md-8"><?php print $theView->escape($moduleVersion); ?></div>
    </div>

    <div class="row py-3">
        <div class="col-sm-12 col-md-4">
            <b><?php $theView->write('MODULES_LIST_AUTHOR'); ?>:</b>
        </div>
        <div class="col-sm-12 col-md-8"><?php print $theView->escape($moduleAuthor); ?></div>
    </div>

    <div class="row py-3">
        <div class="col-sm-12 col-md-4 align-self-center">
            <b><?php $theView->write('MODULES_LIST_LINK'); ?>:</b>
        </div>
        <div class="col-sm-12 col-md-8">
            <?php $theView->linkButton('link')->setRel('external')->setUrl($moduleLink)->setTarget('_blank')->setText($moduleLink)->setIcon('external-link-square-alt'); ?>
        </div>
    </div>

    <div class="row py-3">
        <div class="col-sm-12 col-md-4">
            <b><?php $theView->write('MODULES_LIST_REQUIRE_FPCM'); ?>:</b>
        </div>
        <div class="col-sm-12 col-md-8"><?php print $theView->escape($moduleSysVer); ?></div>
    </div>

    <div class="row py-3">
        <div class="col-sm-12 col-md-4">
            <b><?php $theView->write('MODULES_LIST_REQUIRE_PHP'); ?>:</b>
        </div>
        <div class="col-sm-12 col-md-8"><?php print $theView->escape($modulePhpVer); ?></div>
    </div>

    <div class="row pt-3 pb-1">
        <div class="col-sm-12">
            <b><?php $theView->write('MODULES_LIST_DESCRIPTION'); ?>:</b>
        </div>
    </div>

    <div class="row pt-1 pb-3">
        <div class="col-sm-12">
            <div class="pre-box">
                <?php print $theView->escape($moduleDescription); ?></div>
            </div>
    </div>

    <div class="row py-3">
        <div class="col-sm-12 col-md-4 py-3 py-md-0">
            <?php $theView->linkButton('download')->setRel('external')->setReadonly(!$moduleDownload)->setUrl($moduleDownload)->setIcon('cloud-download-alt')->setText('MODULES_LIST_DOWNLOAD'); ?>
        </div>
        <div class="col-sm-12 col-md-auto py-3 py-md-0 align-self-center">
            <b><?php print $theView->write('FILE_LIST_FILEHASH'); ?>:</b> <?php print $theView->escapeVal($moduleHash); ?>
        </div>
    </div>
</div>
