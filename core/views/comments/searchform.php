<?php /* @var $theView \fpcm\view\viewVars */ ?>
<div class="fpcm-ui-dialog-layer fpcm-ui-hidden" id="fpcm-dialog-comments-search">

    <div class="row my-3">
        
        <div class="col-12 col-md-4 my-2 my-md-0">            
            <?php $theView->select('searchtype')
                    ->setOptions($searchTypes)
                    ->setClass('fpcm-comments-search-input fpcm-ui-input-select-commentsearch')
                    ->setSelected(0)
                    ->setFirstOption(fpcm\view\helper\select::FIRST_OPTION_DISABLED); ?>
        </div>

        <div class="col-12 col-md-8 my-2 my-md-0">
            <?php $theView->textInput('text')->setClass('fpcm-comments-search-input')->setMaxlenght(255)->setText('ARTICLE_SEARCH_TEXT')->setPlaceholder(true)->setWrapper(true); ?>
        </div>
    </div>

    <div class="row my-3">
        
        <div class="col-12 col-md-4 my-2 my-md-0">
            <?php $theView->select('combinationDatefrom')
                    ->setOptions($searchCombination)
                    ->setClass('fpcm-ui-input-select-commentsearch-combination')
                    ->setFirstOption(fpcm\view\helper\select::FIRST_OPTION_DISABLED)
                    ->setData(['']); ?>
        </div>

        <div class="col-12 col-md-3 my-2 my-md-0">
            <?php $theView->dateTimeInput('datefrom')
                    ->setClass('fpcm-comments-search-input fpcm-ui-full-width-date')
                    ->setMaxlenght(10)
                    ->setText('ARTICLE_SEARCH_DATE_FROM')
                    ->setWrapper(true)
                    ->setPlaceholder(true); ?>
        </div>
    </div>

    <div class="row my-3">
        
        <div class="col-12 col-md-4 my-2 my-md-0">
            <?php $theView->select('combinationDateto')
                    ->setOptions($searchCombination)
                    ->setClass('fpcm-ui-input-select-commentsearch-combination')
                    ->setFirstOption(fpcm\view\helper\select::FIRST_OPTION_DISABLED); ?>
        </div>

        <div class="col-12 col-md-3 my-2 my-md-0">
            <?php $theView->dateTimeInput('dateto')
                    ->setClass('fpcm-comments-search-input fpcm-ui-full-width-date')
                    ->setMaxlenght(10)
                    ->setText('ARTICLE_SEARCH_DATE_TO')
                    ->setWrapper(true)
                    ->setPlaceholder(true); ?>
        </div>
    </div>

    <div class="row my-3">
        
        <div class="col-12 col-md-4 my-2 my-md-0">
            <?php $theView->select('combinationSpam')
                    ->setOptions($searchCombination)
                    ->setClass('fpcm-ui-input-select-commentsearch-combination')
                    ->setFirstOption(fpcm\view\helper\select::FIRST_OPTION_DISABLED); ?>
        </div>

        <div class="col-12 col-md-8 my-2 my-md-0">
            <?php $theView->select('spam')
                    ->setOptions($searchSpam)
                    ->setClass('fpcm-comments-search-input fpcm-ui-input-select-commentsearch')
                    ->setFirstOption(fpcm\view\helper\select::FIRST_OPTION_DISABLED); ?>
        </div>
    </div>

    <div class="row my-3">
        
        <div class="col-12 col-md-4 my-2 my-md-0">
            <?php $theView->select('combinationApproved')
                    ->setOptions($searchCombination)
                    ->setClass('fpcm-ui-input-select-commentsearch-combination')
                    ->setFirstOption(fpcm\view\helper\select::FIRST_OPTION_DISABLED); ?>
        </div>

        <div class="col-12 col-md-8 my-2 my-md-0">
            <?php $theView->select('approved')
                    ->setOptions($searchApproval)
                    ->setClass('fpcm-comments-search-input fpcm-ui-input-select-commentsearch')
                    ->setFirstOption(fpcm\view\helper\select::FIRST_OPTION_DISABLED); ?>
        </div>
    </div>

    <div class="row my-3">
        
        <div class="col-12 col-md-4 my-2 my-md-0">
            <?php $theView->select('combinationPrivate')
                    ->setOptions($searchCombination)
                    ->setClass('fpcm-ui-input-select-commentsearch-combination')
                    ->setFirstOption(fpcm\view\helper\select::FIRST_OPTION_DISABLED); ?>
        </div>

        <div class="col-12 col-md-8 my-2 my-md-0">
            <?php $theView->select('private')
                    ->setOptions($searchPrivate)
                    ->setClass('fpcm-comments-search-input fpcm-ui-input-select-commentsearch')
                    ->setFirstOption(fpcm\view\helper\select::FIRST_OPTION_DISABLED); ?>
        </div>
    </div>

    <div class="row my-3">
        
        <div class="col-12 col-md-4 my-2 my-md-0">
            <?php $theView->select('combinationArticleid')
                    ->setOptions($searchCombination)
                    ->setClass('fpcm-ui-input-select-commentsearch-combination')
                    ->setFirstOption(fpcm\view\helper\select::FIRST_OPTION_DISABLED); ?>
        </div>

        <div class="col-12 col-md-8 my-2 my-md-0">
            <?php $theView->textInput('articleId')->setClass('fpcm-comments-search-input fpcm-ui-input-articleid')->setMaxlenght(20)->setText('COMMMENT_SEARCH_ARTICLE')->setPlaceholder(true)->setWrapper(true); ?>
        </div>
    </div>

</div>