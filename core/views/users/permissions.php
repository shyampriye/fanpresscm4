<div class="fpcm-inner-wrapper">
    
    <form method="post" action="<?php print $theView->self; ?>?module=users/permissions&roll=<?php print $rollId; ?>">
        <div class="fpcm-tabs-general" id="fpcm-tabs-permissions">
            <ul>
                <li><a href="#tabs-permissions-group"><?php $theView->write('HL_OPTIONS_PERMISSIONS'); ?>: <?php print $rollname; ?></a></li>                
            </ul>

            <div id="tabs-permissions-group">

                <div class="fpcm-ui-permissions-container">
                    <div class="fpcm-ui-permissions-container-inner">
                        <h2><?php $theView->write('PERMISSION_ARTICLES'); ?></h2>
                        <?php foreach ($permissions['article'] as $key => $value) : ?>
                            <?php fpcm\view\helper::checkbox("permissions[article][{$key}]", '', 1, $theView->translate('PERMISSION_ARTICLE_'.strtoupper($key)), "{$rollId}_article_{$key}", $value, false); ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="fpcm-ui-permissions-container">
                    <div class="fpcm-ui-permissions-container-inner">
                        <h2><?php $theView->write('PERMISSION_COMMENTS'); ?></h2>
                        <?php foreach ($permissions['comment'] as $key => $value) : ?>
                            <?php fpcm\view\helper::checkbox("permissions[comment][{$key}]", '', 1, $theView->translate('PERMISSION_COMMENT_'.strtoupper($key)), "{$rollId}_comment_{$key}", $value, false); ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="fpcm-ui-clear"></div>

                <div class="fpcm-ui-permissions-container">
                    <div class="fpcm-ui-permissions-container-inner">
                        <h2><?php $theView->write('PERMISSION_UPLOADS'); ?></h2>
                        <?php foreach ($permissions['uploads'] as $key => $value) : ?>
                            <?php fpcm\view\helper::checkbox("permissions[uploads][{$key}]", '', 1, $theView->translate('PERMISSION_UPLOADS_'.strtoupper($key)), "{$rollId}_uploads_{$key}", $value, false); ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="fpcm-ui-permissions-container">
                    <div class="fpcm-ui-permissions-container-inner">
                        <h2><?php $theView->write('PERMISSION_SYSTEM'); ?></h2>
                        <?php foreach ($permissions['system'] as $key => $value) : ?>
                            <?php $readOnly = ($key == 'permissions' && $rollId == 1) ? true : false; ?>
                            <?php fpcm\view\helper::checkbox("permissions[system][{$key}]", '', 1, $theView->translate('PERMISSION_SYSTEM_'.strtoupper($key)), "{$rollId}_system_{$key}", $value, $readOnly); ?>
                            <?php if ($readOnly) : ?><input type="hidden" name="<?php print "permissions[system][{$key}]"; ?>" value="1"><?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="fpcm-ui-permissions-container">
                    <div class="fpcm-ui-permissions-container-inner">
                        <h2><?php $theView->write('PERMISSION_MODULES'); ?></h2>
                        <?php foreach ($permissions['modules'] as $key => $value) : ?>
                            <?php fpcm\view\helper::checkbox("permissions[modules][{$key}]", '', 1, $theView->translate('PERMISSION_MODULES_'.strtoupper($key)), "{$rollId}_modules_{$key}", $value, false); ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="fpcm-ui-clear"></div>

            </div>
        </div>

        <div class="fpcm-ui-hidden"><?php fpcm\view\helper::saveButton('permissionsSave', 'fpcm-loader'); ?></div>

        <?php $theView->pageTokenField('pgtkn'); ?>

    </form>

</div>