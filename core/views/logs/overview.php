<?php /* @var $theView \fpcm\view\viewVars */ ?>
<div class="row no-gutters fpcm-ui-full-height">
    <div class="col-12">
        <div class="fpcm-content-wrapper fpcm-ui-full-height">
            <div class="fpcm-ui-tabs-general" id="fpcm-tabs-logs">
                <ul>
                    <?php foreach ($logs as $log) : ?><?php print $log; ?><?php endforeach; ?>
                </ul>         

                <div id="loader"></div>

            </div>
        </div>
    </div>
</div>