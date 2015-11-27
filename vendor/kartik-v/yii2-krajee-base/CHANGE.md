version 1.7.7
=============
**Date:** 16-Jun-2015

- (enh #37): Set range input caption to change during slide.
- (enh #38): Update to use `Json::htmlEncode` as per yii release v2.0.4.

version 1.7.6
=============
**Date:** 09-May-2015

- (enh #36): Add kv-input-group-hide class.

version 1.7.5
=============
**Date:** 03-May-2015

- (enh #30): Improve translation trait for determining messages folder.
- (enh #33): Better styling of html5 inputs.
- (enh #34): New `addLanguage` method in `AssetBundle`.
- (enh #35): Allow extending translation messages.

version 1.7.4
=============
**Date:** 13-Feb-2015

- (enh #28): Create WidgetTrait for better code reuse.
- Code cleanup and reformatting.
- (enh #29): New `getModule` and `initModule` methods in `Config`.
- Set copyright year to current.

version 1.7.3
=============
**Date:** 25-Jan-2015

- (enh #26): Enhance `Widget` options to store multiple plugin config.
- (enh #27): Set directory and URL separator rightly for the setLanguage validation.

version 1.7.2
=============
**Date:** 20-Jan-2015

- (enh #24): Revert use of DIRECTORY_SEPARATOR and use forward slash instead.

version 1.7.1
=============
**Date:** 15-Jan-2015

- (enh #23): Enhance AssetBundle for over riding empty assets from AssetManager.

version 1.7.0
=============
**Date:** 12-Jan-2015

- Fix kartik-v/yii2-widget-datepicker#10 - Language definition in pluginOptions
- (enh #21): Implement TranslationTrait and i18N configuration.
- (enh #22): Implement base Module class.
- Code formatting updates as per Yii2 coding style.

version 1.6.0
=============
**Date:** 16-Dec-2014

- (bug #16): variable `$short` in `InputWidget` in method `setLanguage` set without `$prefix`.
- (bug #17): Enhance `parseDateFormat` to convert formats rightly to PHP DateTime format.
- (bug #18): Better `noSupport` message translation in `Html5Input`.
- (enh #19): Avoid inspect errors in IDE for `Html5Input`.
- (enh #20): Add new PluginAssetBundle for bootstrap JS dependent plugins.

version 1.5.0
=============
**Date:** 06-Dec-2014

- (enh #11): Added new properties `disabled` and `readonly` to `InputWidget` and `Html5Input`.
    - a new method `initDisability` is been created for disability validation across Input Widgets
    - this will automatically set the input's `disabled` or `readonly` option
    - it will also automatically be used to validate disability and style complex widgets like `DatePicker` or `DateTimePicker`
- (enh #12): Enhance `InputWidget` to include `getPluginScript` method.    
- (enh #13): Enhancements to Config helper and change `self` methods to `static`.
- (bug #14): Fix line terminators and new lines in `getPluginScript`.

version 1.4.0
=============
**Date:** 29-Nov-2014

- (enh #9): Enhanced language validation for combined ISO-639 and ISO-3166 codes
    - Auto detect and generate the plugin language and its related locale file using a new `setLanguage` method in `InputWidget`
    - Enhance `initLanguage` method to include a parameter `full` which defaults to `false` to use the ISO-639 language code.
- (enh #10): Enhanced language and directory methods in Config

    Two new methods is added to Config helper class:

    - `getCurrentDir` - gets the current directory of the extended class object
    - `fileExists` - modified file_exists method after replacing the slashes with right directory separator

version 1.3.0
=============
**Date:** 25-Nov-2014

- (enh #6): Enhance `InputWidget` for attaching multiple jQuery plugins.

### BC Breaking Changes

#### Removed:
The following HTML5 data attributes are removed and not registered anymore with the input:

- `data-plugin-name` the name of the plugin
- `data-plugin-options` the client options of the plugin

#### Added:

Following functionality included in `InputWidget` and `Widget` classes:

- New protected property `_pluginName` for easy configuration in individual widgets.
- The following HTML5 data attribute will be added for each input:
    - `data-krajee-{name}` the client options of the plugin. The tag `{name}` will be replaced with the 
       registered jQuery plugin name (e.g. `select2`, `typeahead` etc.).
- New protected property `_dataVar` included for generating the above data attribute.


version 1.2.0
=============
**Date:** 25-Nov-2014

- (bug #2): AssetBundle::EMPTY_PATH is not setting sourcePath to null.
- (enh #3): Modify and validate language setting according to yii i18n.
- (enh #4): Add validations for html inputs, dropdowns, and widgets in `Config`.
- (enh #5): Correctly validate checkbox and radio checked states for `InputWidget`.

version 1.1.0
=============
**Date:** 10-Nov-2014

- Validation for sub repositories containing input widgets.
- (bug #1): Include namespaced FormatConverter class in InputWidget.
- Include `Html5Input` class and  `Html5InputAsset` bundle.
- Include `AnimateAsset` bundle.
- Code formatting as per standards.

version 1.0.0
=============
**Date:** 06-Nov-2014

Initial release