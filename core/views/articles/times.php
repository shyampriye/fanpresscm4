<?php
    if ($timesMode) {
        $timeInfoCreate = $theView->lang->translate('EDITOR_AUTHOREDIT', array(
            '{{username}}' => isset($users[$article->getCreateuser()]) ? $users[$article->getCreateuser()] : $theView->lang->translate('GLOBAL_NOTFOUND'),
            '{{time}}'     => \fpcm\view\helper::dateText($article->getCreatetime(), false, true)
        ));

        $timeInfoChange = $theView->lang->translate('EDITOR_LASTEDIT', array(
            '{{username}}' => isset($users[$article->getChangeuser()]) ? $users[$article->getChangeuser()] : $theView->lang->translate('GLOBAL_NOTFOUND'),
            '{{time}}'     => \fpcm\view\helper::dateText($article->getChangetime(), false, true)
        ));         
    } else {
        $timeInfoCreate = $theView->lang->translate('EDITOR_AUTHOREDIT', array(
            '{{username}}' => isset($users[$article->getCreateuser()]) ? $users[$article->getCreateuser()]->getDisplayname() : $theView->lang->translate('GLOBAL_NOTFOUND'),
            '{{time}}'     => \fpcm\view\helper::dateText($article->getCreatetime(), false, true)
        ));

        $timeInfoChange = $theView->lang->translate('EDITOR_LASTEDIT', array(
            '{{username}}' => isset($users[$article->getChangeuser()]) ? $users[$article->getChangeuser()]->getDisplayname() : $theView->lang->translate('GLOBAL_NOTFOUND'),
            '{{time}}'     => \fpcm\view\helper::dateText($article->getChangetime(), false, true)
        ));        
    }            
?>

<div class="fpcm-ui-editor-metabox-left">    
    <div class="fpcm-ui-ellipsis"><?php print $timeInfoCreate; ?><br>
    <?php print $timeInfoChange; ?>
    <?php if (!$timesMode && $isRevision) : ?><br>
        <b><?php $theView->lang->write('TEMPLATE_ARTICLE_SOURCES'); ?>:</b>
        <?php print $article->getSources(); ?>
    <?php endif; ?>
    
    </div>
</div>

<?php if (!$timesMode) : ?>
<!-- Shortlink layer -->  
<div class="fpcm-ui-dialog-layer fpcm-ui-hidden fpcm-editor-dialog" id="fpcm-dialog-editor-shortlink"></div>
<?php endif; ?>