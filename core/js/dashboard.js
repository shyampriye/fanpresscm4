/**
 * FanPress CM Dashboard Namespace
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015-2017, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 * @since FPCM 3.5
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.dashboard = {

    init: function () {

        fpcm.ui.showLoader(true, '<strong>' + fpcm.ui.translate('DASHBOARD_LOADING') + '</strong>');
        fpcm.ajax.exec('dashboard', {
            execDone: function() {
                fpcm.ui.assignHtml('#fpcm-dashboard-containers', fpcm.ajax.getResult('dashboard'));
                fpcm.ui.assignButtons();

                jQuery('.fpcm-updatecheck-manual').click(function () {                    
                    fpcm.system.openManualCheckFrame();
                    return false;
                });

                fpcm.ui.showLoader(false);

                var fpcmRFDinterval = setInterval(function(){
                    if (jQuery('#fpcm-dashboard-finished').length == 1) {
                        clearInterval(fpcmRFDinterval);
                        fpcm.ui.resize();
                        return false;
                    }
                }, 250);
            }
        });
        
        if (fpcm.vars.jsvars.autoDialog) {
            fpcm.system.openManualCheckFrame();
        }

    }

};