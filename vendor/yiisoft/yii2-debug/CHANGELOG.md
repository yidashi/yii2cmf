Yii Framework 2 debug extension Change Log
==========================================

2.0.5 August 06, 2015
---------------------

- Bug #33: Fixed `LogTarget::collect()` to call `export()` in a proper way (cornernote)
- Bug #7305: Logging of Exception objects resulted in failure of the logger and no debug data was present (cebe)
- Bug #9112: Fixed initial state of debug toolbar placeholder to prevent "blink" on loading (samdark)
- Bug #9169: Fixed incorrect toolbar image mime causing XML5605 errors in IE console (samdark)
- Enh #16: Added ability to EXPLAIN queries in Database panel for MySQL, SQLite, PostgreSQL and Cubrid (laszlovl, samdark)
- Enh #19: Mark selected log item in dropdown list with bold font and an arrow (idMolotov)
- Enh #25: Make use of full screen width in debug toolbar backend (dynasource, cebe)
- Enh #36: Added check for EXPLAIN support in DbPanel (webdevsega)
- Enh: More compact toolbar (samdark)
- Enh: Display colorful status at index page (samdark)
- Enh: More readable format for date and time at index page (samdark)
- Enh: Toolbar script and styles are now properly registered instead of just echoed (samdark)
- Enh: Toolbar data URL is now HTML-escaped producing valid HTML (samdark)


2.0.4 May 10, 2015
------------------

- Bug #7222: Improved debug toolbar display in rtl pages (mohammadhosain, cebe, samdark)
- Enh #7655: Added ability to filter access by hostname (thiagotalma)
- Enh #7746: Background color of request selector is now choosen based on the current requests status (githubjeka, cebe)


2.0.3 March 01, 2015
--------------------

- Bug #6903: Fixed display issue with phpinfo() table (kalayda, cebe)
- Bug #7222: Debug toolbar wasn't displayed properly in rtl pages (mohammadhosain, johonunu, samdark)
- Enh #6890: Added ability to filter by query type (pana1990)


2.0.2 January 11, 2015
----------------------

- Bug #4820: Fixed reading incomplete debug index data in case of high request concurrency (martingeorg, samdark)
- Chg #6572: Allow panels to stay even if they do not receive any debug data (qiangxue)


2.0.1 December 07, 2014
-----------------------

- Bug #5402: Debugger was not loading when there were closures in asset classes (samdark)
- Bug #5745: Gii and debug modules may cause 404 exception when the route contains dashes (qiangxue)
- Enh #5600: Allow configuring debug panels in `yii\debug\Module::panels` as panel class name strings (qiangxue)
- Enh #6113: Improved configuration and request UI (schmunk42)
- Enh: Made `DefaultController::getManifest()` more robust against corrupt files (cebe)


2.0.0 October 12, 2014
----------------------

- no changes in this release.


2.0.0-rc September 27, 2014
---------------------------

- Bug #1263: Fixed the issue that Gii and Debug modules might be affected by incompatible asset manager configuration (qiangxue)
- Bug #3956: Debug toolbar was affecting flash message removal (samdark)
- Bug #4812: Fixed search filter (samdark)
- Bug #5126: Fixed text body and charset not being set for multipart mail (nkovacs)
- Enh #2299: Date and time in request list is now never wrapped (samdark)
- Enh #3088: The debug module will manage their own URL rules now (qiangxue)
- Enh #3103: debugger panel is now not displayed when printing a page (githubjeka)
- Enh #3108: Added `yii\debug\Module::enableDebugLogs` to disable logging debug logs by default (qiangxue)
- Enh #3810: Added "Latest" button on panels page (thiagotalma)
- Enh #4031: Http status codes were hardcoded in filter (sdkiller)
- Enh #5089: Added asset debugger panel (arturf, qiangxue)

2.0.0-beta April 13, 2014
-------------------------

- Bug #1783: Using VarDumper::dumpAsString() instead var_export(), because var_export() does not handle circular references. (djagya)
- Bug #1504: Debug toolbar isn't loaded successfully in some environments when xdebug is enabled (qiangxue)
- Bug #1747: Fixed problems with displaying toolbar on small screens (cebe)
- Bug #1827: Debugger toolbar is loaded twice if an action is calling `run()` to execute another action (qiangxue)
- Enh #1667: Added mail panel (Ragazzo, 6pblcb)
- Enh #2006: Added total queries count monitoring (o-rey, Ragazzo)

2.0.0-alpha, December 1, 2013
-----------------------------

- Initial release.
