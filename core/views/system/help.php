<div id="fpcm-ui-tabs-help" class="fpcm-ui-tabs-general fpcm-ui-tabs-help">
    <ul>
        <li><a href="#tabs-help-general"><?php $theView->write($headline); ?></a></li>
    </ul>
    <div id="tabs-help-general">
        
        <h3 id="fpcm-ui-help-toc-headline"><?php $theView->write('GLOBAL_TABLE_OF_CONTENT'); ?></h3>
        <ol id="fpcm-ui-help-toc"></ol>
        
        <?php print $content.PHP_EOL.PHP_EOL; ?>
    </div>
</div>