Change Log: `yii2-widget-datepicker`
====================================

## version 1.3.9

**Date:** 29-Mar-2016

- (bug #85): Correct locale files to use `kvDatepicker` modified plugin instance.

## version 1.3.8

**Date:** 25-Mar-2016

- (bug #75): Enhance clear button method to trigger input change correctly.
- Add branch alias for dev-master latest release.
- (enh #78): Add Slovak Translations.
- (enh #84): Update to latest version 1.6.x of `bootstrap-datepicker` plugin.

## version 1.3.7

**Date:** 10-Jan-2016

- (enh #68): Add Czech translations
- Update year.

## version 1.3.6

**Date:** 29-Dec-2015

- (bug #67): Correct init of locale dates for `$.fn.kvDatepicker`.

## version 1.3.5

**Date:** 28-Dec-2015

- (bug #63): Fix extra brace bug in plugin JS code.
- (enh #64): Enhance and improve language & locale validation.

## version 1.3.4

**Date:** 27-Dec-2015

- (enh #45): Add Greek translations.
- (enh #46): Add Polish translations.
- (enh #47): Enhancement for managing layout - **BC Breaking**.
    - New property `layout` to control rendering of picker and remove buttons and add your own input group addons if necessary.
    - The `addon` property will be removed as the `layout` property will allow better control for adding custom bootstrap input group addons.
    - Will be applicable for `TYPE_COMPONENT_PREPEND`, `TYPE_COMPONENT_APPEND`, and `TYPE_RANGE`.
- (enh #50): Add French Translations.
- (enh #52): Fixed class name in DatePicker.
- (enh #55): Enhance plugin to validate `enableOnReadonly` correctly for all layout types.
- (enh #56): Enhance widget to focus the input on opening datepicker via addon icon.
- (enh #59): Clean up Greek translations
- (enh #61): Add Swedish Translations.
- (enh #62): Add Turkish Translations.
- Update to latest stable release (v1.5.0) of bootstrap-datepicker plugin.
- Refactor code and code formatting improvements.

## version 1.3.3

**Date:** 19-Jul-2015

- (enh #27): Enhance plugin to use no conflict approach.
- (enh #28): Update to latest ## version of bootstrap-datepicker.
- (enh #29): Fix locale js files to use the new noconflict `kvDatepicker` function.
- (enh #30): Add Ukranian translations.
- (bug #35): Parse `title` correctly for calendar/remove button addon.
- (enh #36): Configure addon for prepend, append, and range.
- (enh #39): Add Spanish translations.
- (enh #40): Add Latvian translations.
- (enh #41): Add Chinese translations.
- (enh #43): Correct triggering of `changeDate` event for `DatePicker::TYPE_INLINE`.
- (enh #44): Fix markup for `DatePicker::TYPE_INLINE`.

## version 1.3.2

**Date:** 25-Feb-2015

- (enh #21): Add new remove button to clear dates. Applicable only for following `DatePicker` types:
    - `DatePicker::TYPE_COMPONENT_PREPEND` and 
    - `DatePicker::TYPE_COMPONENT_APPEND` 
- (enh #22): Ability to configure picker button options. Applicable only for following `DatePicker` types:
    - `DatePicker::TYPE_COMPONENT_PREPEND` and 
    - `DatePicker::TYPE_COMPONENT_APPEND` 
- (bug #24): Removes BOM charecters from the messages/ru/kvdate.php.
- (enh #25): Improve validation to retrieve the right translation messages folder.

## version 1.3.1

**Date:** 13-Feb-2015

- (enh #19): Store date picker widget type as data attribute
- Update datepicker plugin to the latest release.
- Use minified js files for locales.
- Set copyright year to current.

## version 1.3.0

**Date:** 25-Jan-2015

- Update to latest release of datepicker plugin.
- (enh #8): Create Tajikistan translations.
- (bug #16): Fix directory separator for assets path in setLanguage.

## version 1.2.0

**Date:** 04-Dec-2014

- (enh #1): Add a new markup TYPE_BUTTON with hidden input.
- (bug #3): Fix setLanguage asset locales registration.
- (enh #4): Auto validate disability using new `disabled` and `readonly` properties in InputWidget
- (enh #5): Include styling of markup rightly based on type for `disabled` and `readonly`

## version 1.1.0

**Date:** 29-Nov-2014

- (enh #2): Enhance language locale file parsing and registering
- Set release to stable

## version 1.0.0

**Date:** 08-Nov-2014

- Initial release 
- Sub repo split from [yii2-widgets](https://github.com/kartik-v/yii2-widgets)