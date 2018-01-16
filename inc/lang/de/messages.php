<?php
    /**
     * Messages language file
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2011-2018, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    $lang = array(
        'LOGIN_FAILED'                  => 'Der Benutzername oder das Passwort ist falsch. Bitte versuche es erneut.',
        'LOGIN_FAILED_DISABLED'         => 'Der angegebene Benutzername wurde deaktiviert.',
        'LOGIN_REQUIRED'                => 'Bitte melde dich an, um die angeforderte Seite aufrufen zu können!',
        'LOGIN_PASSWORD_RESET'          => 'Dein Passwort wurde erfolgreich zurückgesetzt! Prüfe deinen Posteingang auf die E-Mail mit dem neuen Passwort.',
        'LOGIN_PASSWORD_RESET_FAILED'   => 'Beim Anfordern eines neues Passworts ist ein Fehler aufgetreten!',
        'LOGIN_ATTEMPTS_MAX'            => 'Du hast deinen Benutzername oder Passwort {{logincount}}-mal falsch eingeben. Der Zugang wurde um {{lockeddate}} für {{lockedtime}} Minuten gesperrt.',
        'PERMISSIONS_REQUIRED'          => 'Du hast keine Berechtigungen um auf diese Seite zuzugreifen!',
        'VIEW_NOT_FOUND'                => 'Die View {{viewname}} wurde nicht gefunden!',
        'AJAX_REQUEST_ERROR'            => 'Beim Ausführen der Aktion ist ein Fehler aufgetreten! Weitere Informationen findest du im Javascript-Log deines Browsers.',
        'AJAX_RESPONSE_ERROR'            => 'Vom Server wurde eine ungültige Antwort geliefert! Weitere Informationen findest du im Javascript-Log deines Browsers und ggf. im PHP-Log.',
        'ERROR_IP_LOCKED'               => 'Deine IP-Adresse wurde für diese Aktion gesperrt! Um den Grund zu erfahren wende dich an die Betreiber der Seite.',
        'CACHE_CLEARED_OK'              => 'Der Cache wurde geleert!',
        'CONFIRM_MESSAGE'               => 'Willst du diese Aktion wirklich durchführen?',
        'SELECT_ITEMS_MSG'              => 'Bitte wähle Elemente oder eine Aktion aus!',
        'SEARCH_WAITMSG'                => 'Bitte warte 10 Sekunden, bevor du einen neuen Suchvorgang durchführst.',
        'RSSFEED_DISABLED'              => 'Der RSS-Feed ist deaktiviert. Wende dich an den Seitenbetreiber, um zu erfahren wieso.',
        'MAINTENANCE_MODE_ENABLED'      => 'Der Wartungsmodus von FanPress CM ist gerade aktiv, daher steht diese Funktion im Moment nicht zur Verfügung.',
        'CSRF_INVALID'                  => 'Das CSRF-Token ist ungültig. Die Aktion wurde nicht durchgeführt!',
        'SESSION_TIMEOUT'               => 'Es wurde festgestellt, dass deine aktuelle Session abgelaufen ist. Willst du zur Login-Seite gehen? (wähle "Nein" um auf der aktuellen Seite zu bleiben)',
        'FILE_NOT_WRITABLE'             => 'Die ausgewählte Datei ist nicht beschreibbar, bitte prüfe die Berechtigungen auf dem Server.',
        
        'SAVE_SUCCESS_ADDUSER'          => 'Der Benutzer wurde gespeichert!',
        'SAVE_SUCCESS_USER_DISABLE'     => 'Der Benutzer wurde deaktiviert!',
        'SAVE_SUCCESS_USER_ENABLE'      => 'Der Benutzer wurde aktiviert!',
        'SAVE_SUCCESS_ADDROLL'          => 'Die Benutzerrolle wurde gespeichert!!',
        'SAVE_SUCCESS_ADDCATEGORY'      => 'Die Kategorie wurde gespeichert!',
        'SAVE_SUCCESS_EDITUSER'         => 'Die Änderungen am Benutzer wurden gespeichert!',
        'SAVE_SUCCESS_EDITUSER_PROFILE' => 'Die Änderungen an deinem Profil wurden gespeichert!',
        'SAVE_SUCCESS_RESETPROFILE'     => 'Die Benutzereinstellungen wurden auf die Standardwerte zurückgesetzt!',
        'SAVE_SUCCESS_EDITROLL'         => 'Die Änderungen an der Benutzerrolle wurden gespeichert!',
        'SAVE_SUCCESS_EDITCATEGORY'     => 'Die Änderungen an der Kategorie wurden gespeichert!',
        'SAVE_SUCCESS_OPTIONS'          => 'Die Änderungen an der Konfiguration wurde gespeichert!',
        'SAVE_SUCCESS_PERMISSIONS'      => 'Die Änderungen an den Berechtigungen wurde gespeichert!',
        'SAVE_SUCCESS_SMILEY'           => 'Der Smiley wurde gespeichert!',
        'SAVE_SUCCESS_IPADDRESS'        => 'Die IP-Adresse wurde gesperrt!',
        'SAVE_SUCCESS_WORDBAN'          => 'Der Begriff wurde gespeichert!',
        'SAVE_SUCCESS_UPLOADPHP'        => 'Die Dateien wurden hochgeladen!<br>{{filenames}}',
        'SAVE_SUCCESS_TEMPLATE'         => 'Die Templates wurden gespeichert!<br>{{filenames}}',
        'SAVE_SUCCESS_ARTICLETEMPLATE'  => 'Die Artikel-Vorlage wurde gespeichert!',
        'SAVE_SUCCESS_ARTICLE'          => 'Der Artikel wurde gespeichert!',
        'SAVE_SUCCESS_ARTICLE_APPROVAL' => 'Der Artikel wurde gespeichert, muss aber freigeschalten werden!',
        'SAVE_SUCCESS_ARTICLEPINN'      => 'Die Artikel wurden (ab)gepinnt!',
        'SAVE_SUCCESS_ARTICLEAPPROVAL'  => 'Die Artikel-Freigabe wurde geändert!',
        'SAVE_SUCCESS_ARTICLEARCHIVE'   => 'Der/die Artikel wurde/n archiviert!',
        'SAVE_SUCCESS_ARTICLERESTORE'   => 'Der/Die Artikel wurde/n wiederhergestellt!',
        'SAVE_SUCCESS_ARTICLENEWTWEET'  => 'Für die Artikel wurden neue Tweets erzeugt!<br>{{titles}}',
        'SAVE_SUCCESS_ARTICLECOMMENTS'  => 'Die Kommentare wurden für den/die Artikel (de)aktiviert!',
        'SAVE_SUCCESS_ARTICLEREVRESTORE'=> 'Die Revision wurde wiederhergestellt!',
        'SAVE_SUCCESS_COMMENT'          => 'Der Kommentar wurde gespeichert!',
        'SAVE_SUCCESS_APPROVEMENT'      => 'Die Genehmigung des/r Kommentars/e wurde geändert!',
        'SAVE_SUCCESS_PRIVATE'          => 'Der Privat-Status des/r Kommentars/e wurde geändert!',
        'SAVE_SUCCESS_SPAMMER'          => 'Die Spam-Markierung der Kommentars/e wurde geändert!',
        'SAVE_SUCCESS_UPLOADMODULE'     => 'Die Modul-Paket-Datei wurde hochgeladen!',
        'SAVE_SUCCESS_UPLOADTPLFILE'    => 'Die Vorlage wurde hochgeladen!',
        'SAVE_SUCCESS_UPLOADAUTHORIMG'  => 'Der Avatar wurde hochgeladen!',
        'SAVE_SUCCESS_APPROVAL_SAVE'    => 'Um den Artikel freizugeben, speichere ihn einfach erneut ab!',
        
        'SAVE_FAILED_USER'              => 'Der Benutzer konnte nicht gespeichert werden!',
        'SAVE_FAILED_USER_PROFILE'      => 'Die Änderung am Profil konnten nicht gespeichert werden!',
        'SAVE_FAILED_USER_EXISTS'       => 'Ein Benutzer mit dem gewählten Benutzername existiert bereits!',
        'SAVE_FAILED_USER_EMAIL'        => 'Für den Benutzer wurde keine gültige E-Mail-Adresse angegeben!',
        'SAVE_FAILED_USER_PROFILEEMAIL' => 'Du musst eine gültige E-Mail-Adresse angegeben!',
        'SAVE_FAILED_USER_DISABLE'      => 'Der Benutzer konnte nicht deaktiviert werden!',
        'SAVE_FAILED_USER_DISABLE_OWN'  => 'Du kannst deinen eigenen Account nicht deaktivieren!',
        'SAVE_FAILED_USER_DISABLE_LAST' => 'Der letzte Benutzer kann nicht deaktiviert werden!',
        'SAVE_FAILED_USER_ENABLE'       => 'Der Benutzer konnte nicht aktiviert werden!',
        'SAVE_FAILED_ROLL'              => 'Die Benutzerrolle konnte nicht gespeichert werden!',        
        'SAVE_FAILED_CATEGORY'          => 'Die Kategorie konnte nicht gespeichert werden!',                
        'SAVE_FAILED_PASSWORD_SECURITY' => 'Ein Password muss Groß- und Kleinbuchstaben sowie Zahlen enthalten und min. 6 Zeichen lang sein.', 
        'SAVE_FAILED_PASSWORD_MATCH'    => 'Die eingegebenen Passwörter stimmen nicht überein.',
        'SAVE_FAILED_USER_SECURITY'     => 'Der eingegebene Benutzername ist potentiell gefährlich und kann daher nicht verwendet werden!',
        'SAVE_FAILED_OPTIONS'           => 'Die Änderungen an der Konfiguration konnten nicht gespeichert werden!',
        'SAVE_FAILED_PERMISSIONS'       => 'Die Änderungen an den Berechtigungen für die ausgewählte Rolle konnten nicht gespeichert werden!',
        'SAVE_FAILED_SMILEY'            => 'Der Smiley konnte nicht gespeichert werden!',
        'SAVE_FAILED_IPADDRESS'         => 'Die IP-Adresse konnte nicht gesperrt werden!',
        'SAVE_FAILED_WORDBAN'           => 'Der Begriff konnte nicht gespeichert werden!',
        'SAVE_FAILED_UPLOADPHP'         => 'Beim hochladen der Dateien ist ein Fehler aufgetreten!<br>{{filenames}}',
        'SAVE_FAILED_TEMPLATE'          => 'Beim Speichern der Templates ist ein Fehler aufgetreten!<br>{{filenames}}',
        'SAVE_FAILED_TEMPLATE_CF_URLMISSING' => 'Das Kommentar-Formular-Template konnte nicht gespeichert werden. Der Platzhalter {{submitUrl}} fehlt!',
        'SAVE_FAILED_ARTICLETEMPLATE'   => 'Die Artikel-Vorlage konnte nicht gespeichert werden!',
        'SAVE_FAILED_ARTICLE'           => 'Der Artikel konnte nicht gespeichert werden!',
        'SAVE_FAILED_ARTICLES'          => 'Die Änderungen an den Artikeln konnte nicht gespeichert werden!',
        'SAVE_FAILED_ARTICLE_EMPTY'     => 'Du musst einen Titel und einen Text eingeben, bevor du den Artikel speichern kannst!',
        'SAVE_FAILED_ARTICLEPINN'       => 'Die Artikel konnten nicht (ab)gepinnt werden!',
        'SAVE_FAILED_ARTICLEARCHIVE'    => 'Die Artikel konnten nicht archiviert werden!',
        'SAVE_FAILED_ARTICLERESTORE'    => 'Die Artikel konnten nicht wiederhergestellt werden!',
        'SAVE_FAILED_ARTICLENEWTWEET'   => 'Für die Artikel konnten keine Tweets erzeugt werden!<br>{{titles}}',
        'SAVE_FAILED_ARTICLECOMMENTS'   => 'Die Kommentare konnten nicht für die Artikel (de)aktiviert werden!',
        'SAVE_FAILED_ARTICLEREVRESTORE' => 'Die Revision konnte nicht wiederhergestellt werden!',
        'SAVE_FAILED_ARTICLEAPPROVAL'   => 'Die Artikel-Freigaben konnten nicht geändert werden!',
        'SAVE_FAILED_COMMENT'           => 'Der Kommentar konnte nicht gespeichert werden!',
        'SAVE_FAILED_APPROVEMENT'       => 'Die Genehmigung der Kommentare konnte nicht geändert werden!',
        'SAVE_FAILED_PRIVATE'           => 'Der Privat-Status der Kommentare konnte nicht geändert werden!',
        'SAVE_FAILED_SPAMMER'           => 'Die Spam-Markierung der Kommentare konnte nicht geändert werden!',
        'SAVE_FAILED_UPLOADMODULE'      => 'Beim Hochladen der Modul-Paket-Datei ist ein Fehler aufgetreten!',
        'SAVE_FAILED_UPLOADTPLFILE'     => 'Beim Hochladen der Vorlage ist ein Fehler aufgetreten!',
        'SAVE_FAILED_UPLOADAUTHORIMG'   => 'Beim Hochladen des Avatars ist ein Fehler aufgetreten!',
        
        'DELETE_SUCCESS_USERS'          => 'Der Benutzer wurden gelöscht!',
        'DELETE_SUCCESS_ROLL'           => 'Die Benutzerrolle wurden gelöscht!',
        'DELETE_SUCCESS_CATEGORIES'     => 'Die Kategorien wurden gelöscht!',
        'DELETE_SUCCESS_FILES'          => 'Die Dateien wurden gelöscht!<br>{{filenames}}',
        'DELETE_SUCCESS_FILEAUTHORIMG'  => 'Der Avatar wurde gelöscht!',
        'DELETE_SUCCESS_NEWTHUMBS'      => 'Neue Thumbnails wurden erzeugt!<br>{{filenames}}',
        'DELETE_SUCCESS_RENAME'         => 'Die Datei wurde {{filename1}} in {{filename2}} umbenannt!',
        'DELETE_SUCCESS_SMILEYS'        => 'Die Smileys wurden gelöscht!',
        'DELETE_SUCCESS_IPADDRESS'      => 'Die IP-Adressen wurde(n) gelöscht!',
        'DELETE_SUCCESS_WORDBAN'        => 'Die Begriffe wurden gelöscht!',
        'DELETE_SUCCESS_ARTICLE'        => 'Die Artikel wurden gelöscht!',
        'DELETE_SUCCESS_REVISIONS'      => 'Die Revisionen wurden gelöscht!',
        'DELETE_SUCCESS_TRASH'          => 'Der Papierkorb wurde geleert!',
        'DELETE_SUCCESS_COMMENTS'       => 'Die Kommentare wurden gelöscht!',
        
        'DELETE_FAILED_USERS'           => 'Der Benutzer konnte nicht gelöscht werden!',
        'DELETE_FAILED_USERS_OWN'       => 'Du kannst deinen eigenen Account nicht löschen!',
        'DELETE_FAILED_USERS_LAST'      => 'Der letzte Benutzer kann nicht gelöscht werden!',
        'DELETE_FAILED_USERSARTICLES'   => 'Artikel können nicht zum zu löschenden Benutzer verschoben werden!',
        'DELETE_FAILED_ROLL'            => 'Die Benutzerrolle konnte nicht gelöscht werden!',
        'DELETE_FAILED_CATEGORIES'      => 'Die Kategorien konnten nicht gelöscht werden!',
        'DELETE_FAILED_NEWTHUMBS'       => 'Thumbnails konnten nicht erzeugt werden!<br>{{filenames}}',
        'DELETE_FAILED_FILES'           => 'Die Dateien konnten nicht gelöscht werden!<br>{{filenames}}',
        'DELETE_FAILED_FILEAUTHORIMG'   => 'Der Avatar konnte nicht gelöscht werden!',
        'DELETE_FAILED_RENAME'          => 'Die Datei {{filename1}} konnte nicht  {{filename2}} umbenannt werden!',
        'DELETE_FAILED_SMILEYS'         => 'Die Smileys konnten nicht gelöscht werden!',
        'DELETE_FAILED_IPADDRESS'       => 'Die IP-Adresse konnten nicht gelöscht werden!',
        'DELETE_FAILED_WORDBAN'         => 'Die Begriffe konnten nicht gelöscht werden!',
        'DELETE_FAILED_ARTICLE'         => 'Die Artikel konnten nicht gelöscht werden!',
        'DELETE_FAILED_REVISIONS'       => 'Die Revisionen konnten nicht gelöscht werden!',
        'DELETE_FAILED_TRASH'           => 'Der Papierkorb konnte nicht geleert werden!',
        'DELETE_FAILED_COMMENTS'        => 'Die Kommentare konnten nicht gelöscht werden!',
        
        'LOAD_FAILED_ARTICLE'           => 'Der gesuchte Artikel wurde nicht gefunden.',
        'LOAD_FAILED_COMMENT'           => 'Der gesuchte Kommentar wurde nicht gefunden.',
        'LOAD_FAILED_USER'              => 'Der gesuchte Benutzer wurde nicht gefunden.',
        'LOAD_FAILED_ROLL'              => 'Die gesuchte Benutzerrolle wurde nicht gefunden.',
        'LOAD_FAILED_CATEGORY'          => 'Die gesuchte Kategorie wurde nicht gefunden.',
        'LOAD_FAILED_WORDBAN'           => 'Der Begriff wurde nicht gefunden.',
        
        'UPDATE_VERSIONCHECK_NEW'       => 'FanPress CM Version <i>{{version}}</i> ist verfügbar! Um das Update durchzuführen <a class="fpcm-ui-button fpcm-start-update fpcm-ui-actions-genreal fpcm-loader" href="{{versionlink}}">klicke hier</a>',
        'UPDATE_VERSIONCHECK_CURRENT'   => 'Deine Version von FanPress CM ist <strong>aktuell</strong>!',
        'UPDATE_VERSIONCHECK_NOTES'     => 'Release-Notes und weitere Infos zu System- und Modul-Updates findest du in den aktuellen FanPress CM News.',
        'UPDATE_VERSIONCECK_FILEDB_ERR' => 'Die Version im Dateisystem und der Datenbank stimmen nicht überein. <a class="fpcm-ui-button fpcm-ui-actions-genreal fpcm-loader" href="{{versionlink}}">Klicke hier</a> um den Updater zu starten.',
        'UPDATE_NOTAUTOCHECK'           => 'Es konnte keine automatische Update-Prüfung durchgeführt werden! <a class="fpcm-ui-button fpcm-updatecheck-manual" href="#">Manuell prüfen</a>',
        'UPDATE_WRITEERROR'             => 'Einige Dateien im Dateisystem sind nicht beschreibbar und können daher nicht ersetzt werden. Prüfe die Rechte der Dateien via FTP, eine Liste findest du im System-Log.',
        
        'UPDATE_MODULECHECK_NEW'         => 'Für einige Module sind Updates verfügbar. <a class="fpcm-ui-button fpcm-loader" href="?module=modules/list">Updates anzeigen</a>',
        'UPDATE_MODULECHECK_CURRENT'     => 'Alle installierten Module sind <strong>aktuell</strong>!',
        'UPDATE_MODULECHECK_FAILED'      => 'Es konnte keine Update-Prüfung für die installierten Module durchgeführt werden!',
        
        'PACKAGES_FAILED_REMOTEFILE'     => 'Es konnte keine Verbindung zum Paketserver hergestellt werden!',
        'PACKAGES_FAILED_LOCALFILE'      => 'Es konnte keine lokale Paket-Datei erzeugt werden!',
        'PACKAGES_FAILED_LOCALWRITE'     => 'Beim Schreiben der lokalen Paket-Datei ist ein Fehler aufgetreten!',
        'PACKAGES_FAILED_LOCALEXISTS'    => 'Die lokale Paket-Datei wurde nicht gefunden!',
        'PACKAGES_FAILED_HASHCHECK'      => 'Die Integritätsprüfung der Paket-Datei ist fehlgeschlagen. Die Hash-Werte stimmen nicht überein!',
        'PACKAGES_FAILED_ZIPOPEN'        => 'Die Paket-Datei konnte nicht geöffnet werden!',
        'PACKAGES_FAILED_ZIPEXTRACT'     => 'Die Paket-Datei konnte nicht entpackt werden!',
        'PACKAGES_FAILED_FILESCOPY'      => 'Der Inhalt der Paket-Datei konnte nicht an seinen Zielort kopiert werden!',
        'PACKAGES_FAILED_GENERAL'        => 'Beim Verarbeiten der Paket-Datei ist ein Fehler aufgetreten!',
        'PACKAGES_FAILED_ADDITIONAL'     => 'Beim Ausführen der abschließenden Paket-Aktionen ist ein Fehler aufgetreten!',

        'PACKAGES_SUCCESS_DOWNLOAD'     => '<span class="fa fa-cloud-download fpcm-ui-booltext-yes fa-fw fa-lg"></span> Das Herunterladen der Paket-Datei war erfolgreich.',
        'PACKAGES_SUCCESS_FILECHECK'    => '<span class="fa fa-pencil-square-o  fpcm-ui-booltext-yes fa-fw fa-lg"></span> Alle Dateien sind beschreibbar.',
        'PACKAGES_SUCCESS_EXTRACT'      => '<span class="fa fa-file-archive-o fpcm-ui-booltext-yes fa-fw fa-lg"></span> Das Entpacken der Paket-Datei war erfolgreich.',
        'PACKAGES_SUCCESS_COPY'         => '<span class="fa fa-random fpcm-ui-booltext-yes fa-fw fa-lg"></span> Der Inhalt der Paket-Datei konnte erfolgreich an sein Ziel kopiert werden.',
        'PACKAGES_SUCCESS_ADDITIONAL'   => '<span class="fa fa-refresh fpcm-ui-booltext-yes fa-fw fa-lg"></span> Das Ausführen der abschließenden Paket-Aktionen war erfolgreich!',
        'PACKAGES_SUCCESS_LOGDONE'      => '<span class="fa fa-file-text-o fpcm-ui-booltext-yes fa-fw fa-lg"></span> Aktualisierung des Paketmanager-Log war erfolgreich!',
        
        'PACKAGES_RUN_DOWNLOAD'         => 'Paket-Datei {{pkglink}} wird geladen...',
        'PACKAGES_RUN_FILECHECK'        => 'Überprüfe Rechte existierender Dateien...',
        'PACKAGES_RUN_EXTRACT'          => 'Paket wird entpackt...',
        'PACKAGES_RUN_COPY'             => 'Paket-Inhalt wird an Ziel kopiert...',
        'PACKAGES_RUN_ADDITIONAL'       => 'Führe abschließende Paket-Aktionen durch...',
        
        'UPDATES_SUCCESS'               => 'Das Update wurde erfolgreich durchgeführt!',
        'UPDATES_FAILED'                => '<span class="fa fa-minus-square fpcm-ui-booltext-noyes fa-fw fa-lg"></span> Das Update konnte nicht erfolgreich durchgeführt werden!',
                
        'LOGS_CLEARED_LOG_OK'           => 'Ausgewähltes Systemlog wurde geleert!',
        'LOGS_CLEARED_LOG_FAILED'       => 'Das ausgewählte Systemlog konnte nicht geleert werden!',
        
        'MODULES_SUCCESS_ENABLE'        => 'Die ausgewählten Module wurden aktiviert.',
        'MODULES_SUCCESS_DISABLE'       => 'Die ausgewählten Module wurden deaktiviert.',
        'MODULES_SUCCESS_INSTALL'       => '<span class="fa fa-check-square fpcm-ui-booltext-yes fa-fw fa-lg"></span> Das ausgewählte Module wurde installiert.',
        'MODULES_SUCCESS_UNINSTALL'     => 'Die ausgewählten Module wurden deinstalliert.',
        'MODULES_SUCCESS_UPDATE'        => '<span class="fa fa-check-square fpcm-ui-booltext-yes fa-fw fa-lg"></span> Das ausgewählte Modul wurde aktualisiert.',
        
        'MODULES_FAILED_ENABLE'         => 'Die ausgewählten Module konnten nicht aktiviert werden.',
        'MODULES_FAILED_DISABLE'        => 'Die ausgewählten Module konnten nicht deaktiviert werden.',
        'MODULES_FAILED_INSTALL'        => '<span class="fa fa-minus-square fpcm-ui-booltext-noyes fa-fw fa-lg"></span> Das ausgewählte Modul konnte nicht installiert werden.',
        'MODULES_FAILED_UNINSTALL'      => 'Die ausgewählten Module konnten nicht deinstalliert werden.',
        'MODULES_FAILED_UPDATE'         => '<span class="fa fa-minus-square fpcm-ui-booltext-noyes fa-fw fa-lg"></span> Das ausgewählte Modul konnte nicht aktualisiert werden.',
        'MODULES_FAILED_TEMPKEYS'       => 'Es wurden keine Module zur Installation vorgemerkt!',
        'MODULES_FAILED_DEPENCIES'      => 'Es wurden nicht-erfüllte Abhängigkeiten erkannt!',
        'MODULES_FAILED_LANGUAGE'       => 'Für die aktuelle Sprache wurde kein Sprachpaket gefunden!',
        
        'PUBLIC_FAILED_CAPTCHA'         => 'Du hast die Captcha-Frage nicht korrekt beantwortet!',
        'PUBLIC_FAILED_NAME'            => 'Bitte gibt deinen Namen ein!',
        'PUBLIC_FAILED_EMAIL'           => 'Bitte gibt deine E-Mail-Adresse ein!',
        'PUBLIC_FAILED_FLOOD'           => 'Bitte warte mindestens {{seconds}} Sekunden, bevor du einen weiteren Kommentar schreibst!',
        'PUBLIC_ARTICLE_PINNED'         => 'Dieser Artikel ist gepinnt und wird über allen anderen angezeigt.'
    );

?>