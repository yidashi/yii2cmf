yii2-widget-datetimepicker
==========================

[![Latest Stable Version](https://poser.pugx.org/kartik-v/yii2-widget-datetimepicker/v/stable)](https://packagist.org/packages/kartik-v/yii2-widget-datetimepicker)
[![License](https://poser.pugx.org/kartik-v/yii2-widget-datetimepicker/license)](https://packagist.org/packages/kartik-v/yii2-widget-datetimepicker)
[![Total Downloads](https://poser.pugx.org/kartik-v/yii2-widget-datetimepicker/downloads)](https://packagist.org/packages/kartik-v/yii2-widget-datetimepicker)
[![Monthly Downloads](https://poser.pugx.org/kartik-v/yii2-widget-datetimepicker/d/monthly)](https://packagist.org/packages/kartik-v/yii2-widget-datetimepicker)
[![Daily Downloads](https://poser.pugx.org/kartik-v/yii2-widget-datetimepicker/d/daily)](https://packagist.org/packages/kartik-v/yii2-widget-datetimepicker)

The DateTimePicker widget is a Yii 2 wrapper for the [Bootstrap DateTimePicker plugin](http://www.malot.fr/bootstrap-datetimepicker) with various enhancements. The plugin is a fork of the DateTimePicker plugin by @eternicode and adds the time functionality. The widget is similar to the DateTimePicker widget in most aspects, except that it adds the time functionality and does not support ranges. The widget is specially styled for Yii framework 2.0 and Bootstrap 3 and allows graceful degradation to a normal HTML text input, if the browser does not support JQuery. The widget supports these markups:

* Simple Input Markup
* Component Markup - Addon Prepended
* Component Markup - Addon Appended
* Inline / Embedded Markup
* Solo Button Markup

> NOTE: This extension is a sub repo split of [yii2-widgets](https://github.com/kartik-v/yii2-widgets). The split has been done since 08-Nov-2014 to allow developers to install this specific widget in isolation if needed. One can also use the extension the previous way with the whole suite of [yii2-widgets](http://demos.krajee.com/widgets).

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/). Check the [composer.json](https://github.com/kartik-v/yii2-widget-datetimepicker/blob/master/composer.json) for this extension's requirements and dependencies. Read this [web tip /wiki](http://webtips.krajee.com/setting-composer-minimum-stability-application/) on setting the `minimum-stability` settings for your application's composer.json.

To install, either run

```
$ php composer.phar require kartik-v/yii2-widget-datetimepicker "*"
```

or add

```
"kartik-v/yii2-widget-datetimepicker": "*"
```

to the ```require``` section of your `composer.json` file.

## Latest Release

> NOTE: The latest version of the module is v1.4.1. Refer the [CHANGE LOG](https://github.com/kartik-v/yii2-widget-datetimepicker/blob/master/CHANGE.md) for details.

## Demo

You can refer detailed [documentation and demos](http://demos.krajee.com/widget-details/datetimepicker) on usage of the extension.

## Usage

```php
use kartik\datetime\DateTimePicker;

echo '<label>Start Date/Time</label>';
echo DateTimePicker::widget([
    'name' => 'datetime_10',
    'options' => ['placeholder' => 'Select operating time ...'],
    'convertFormat' => true,
    'pluginOptions' => [
        'format' => 'd-M-Y g:i A',
        'startDate' => '01-Mar-2014 12:00 AM',
        'todayHighlight' => true
    ]
]);
```

## License

**yii2-widget-datetimepicker** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.