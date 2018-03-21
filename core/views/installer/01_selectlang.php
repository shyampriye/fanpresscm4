<?php /* @var $theView \fpcm\view\viewVars */ ?>
<div class="col-12 col-sm-8 col-md-6 fpcm-ui-center">
    <div class="fpcm-ui-controlgroup">
        <?php $theView->select('language')->setOptions($languages)->setSelected('de')->setFirstOption(\fpcm\view\helper\select::FIRST_OPTION_DISABLED); ?>
        <?php $theView->submitButton('submitNext')->setText('GLOBAL_NEXT')->setClass('fpcm-installer-next-'.$currentStep)->setIcon('chevron-circle-right'); ?>
    </div>
</div>