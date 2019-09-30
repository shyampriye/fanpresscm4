/**
 * FanPress CM Templates Namespace
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.templates_articles = {
    
    init: function() {
        fpcm.editor_codemirror.create({           
           editorId  : 'templatecode',
           elementId : 'templatecode'
        });

        fpcm.dom.fromTag('div.CodeMirror').addClass('fpcm-ui-full-view-min-height');
    }

};