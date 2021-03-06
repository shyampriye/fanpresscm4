<?php /* @var $theView fpcm\view\viewVars */ ?>
<?php if ($showExtended) : ?>
    <div class="row no-gutters">
        <div class="col-12">
            <fieldset>
                <legend><?php $theView->write('USERS_AVATAR'); ?></legend>

                <?php if ($showImage) : ?>
                <div class="row no-gutters fpcm-ui-padding-md-tb">
                    <div class="col-12 fpcm-ui-padding-none-lr">
                        <div class="fpcm-ui-controlgroup fpcm-ui-margin-lg-bottom" id="user_profile_image_buttons">
                            <?php $theView->button('addFile')->setText('FILE_FORM_FILEADD')->setIcon('plus'); ?>
                            <?php $theView->submitButton('uploadFile')->setText('FILE_FORM_UPLOADSTART')->setIcon('upload'); ?>
                            <?php $theView->resetButton('cancelUpload')->setText('FILE_FORM_UPLOADCANCEL')->setIcon('ban'); ?>
                            <?php if ($avatar) : ?><?php $theView->deleteButton('fileDelete')->setClass('fpcm-ui-button-confirm'); ?><?php endif; ?>
                            <input type="file" name="files" class="fpcm-ui-fileinput-select fpcm-ui-hidden">
                        </div>

                        <?php if ($avatar) : ?>
                            <div class="col-12 col-sm-6 col-lg-4 fpcm-ui-padding-none-lr fpcm-filelist-thumb-box fpcm-ui-center">
                                <div class="fpcm-filelist-thumb-box-inner fpcm-ui-background-transition fpcm-ui-padding-md-all fpcm-ui-margin-md-all">
                                    <div class="fpcm-ui-center">
                                        <img src="<?php print $avatar; ?>">
                                    </div>
                                </div>
                            </div>                        
                        <?php else: ?>
                            <p class="fpcm-ui-padding-none fpcm-ui-margin-none"><?php $theView->icon('image')->setStack('ban fpcm-ui-important-text')->setStackTop(true); ?>
                            <?php $theView->write('GLOBAL_NOTFOUND'); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php endif; ?>
            </fieldset>
        </div>
    </div>

    <div class="row no-gutters">
        <div class="col-12">
            <fieldset class="fpcm-ui-margin-md-top">
                <legend><?php $theView->write('USERS_BIOGRAPHY'); ?></legend>

                <div class="row fpcm-ui-padding-md-tb">
                    <div class="col-12 fpcm-ui-padding-none-lr">
                        <?php $theView->textarea('data[usrinfo]')->setValue(str_replace(['\n', '\n\r', '\r', PHP_EOL], '', $author->getUsrinfo()))->setClass('fpcm-ui-textarea-medium fpcm-ui-full-width') ?>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>

<?php endif; ?>
