<div class="fpcm-ui-dialog-layer fpcm-ui-hidden" id="fpcm-dialog-files-search">
    <table class="fpcm-ui-table fpcm-ui-files-search">
        <tr>
            <td colspan="2"><?php \fpcm\view\helper::textInput('filename', 'fpcm-files-search-input', '', false, 255, $theView->lang->translate('FILE_LIST_FILENAME'), 'fpcm-full-width'); ?></td>
        </tr>
        <tr>
            <td><?php \fpcm\view\helper::textInput('datefrom', 'fpcm-files-search-input fpcm-full-width-date', '', false, 10, $theView->lang->translate('ARTICLE_SEARCH_DATE_FROM'), 'fpcm-full-width'); ?></td>
            <td><?php \fpcm\view\helper::textInput('dateto', 'fpcm-files-search-input fpcm-full-width-date', '', false, 10, $theView->lang->translate('ARTICLE_SEARCH_DATE_TO'), 'fpcm-full-width'); ?></td>
        </tr>
        <tr>
            <td></td>
            <td><?php \fpcm\view\helper::select('combination', $searchCombination, null, false, false, false, 'fpcm-files-search-input fpcm-ui-input-select-filesearch'); ?></td>
        </tr>
    </table>
</div>