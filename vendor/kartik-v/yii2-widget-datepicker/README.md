yii2-widget-datepicker
======================

[![Stable Version](https://poser.pugx.org/kartik-v/yii2-widget-datepicker/v/stable)](https://packagist.org/packages/kartik-v/yii2-widget-datepicker)
[![Untable Version](https://poser.pugx.org/kartik-v/yii2-widget-datepicker/v/unstable)](https://packagist.org/packages/kartik-v/yii2-widget-datepicker)
[![License](https://poser.pugx.org/kartik-v/yii2-widget-datepicker/license)](https://packagist.org/packages/kartik-v/yii2-widget-datepicker)
[![Total Downloads](https://poser.pugx.org/kartik-v/yii2-widget-datepicker/downloads)](https://packagist.org/packages/kartik-v/yii2-widget-datepicker)
[![Monthly Downloads](https://poser.pugx.org/kartik-v/yii2-widget-datepicker/d/monthly)](https://packagist.org/packages/kartik-v/yii2-widget-datepicker)
[![Daily Downloads](https://poser.pugx.org/kartik-v/yii2-widget-datepicker/d/daily)](https://packagist.org/packages/kartik-v/yii2-widget-datepicker)

The DatePicker widget is a Yii 2 wrapper for the [Bootstrap DatePicker plugin](http://eternicode.github.io/bootstrap-datepicker) with various enhancements. The plugin is a fork of Stefan Petre's DatePicker (of eyecon.ro), with improvements by @eternicode. The widget is specially styled for Yii framework 2.0 and Bootstrap 3 and allows graceful degradation to a normal HTML text input, if the browser does not support JQuery. The widget supports these markups:

* Simple Input Markup
* Component Markup - Addon Prepended
* Component Markup - Addon Appended
* Inline / Embedded Markup
* Date Range Markup (from and to dates)
* Solo Button Markup

> NOTE: This extension is a sub repo split of [yii2-widgets](https://github.com/kartik-v/yii2-widgets). The split has been done since 08-Nov-2014 to allow developers to install this specific widget in isolation if needed. One can also use the extension the previous way with the whole suite of [yii2-widgets](http://demos.krajee.com/widgets).

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/). Check the [composer.json](https://github.com/kartik-v/yii2-widget-datepicker/blob/master/composer.json) for this extension's requirements and dependencies. Read this [web tip /wiki](http://webtips.krajee.com/setting-composer-minimum-stability-application/) on setting the `minimum-stability` settings for your application's composer.json.

To install, either run

```
$ php composer.phar require kartik-v/yii2-widget-datepicker "@dev"
```

or add

```
"kartik-v/yii2-widget-datepicker": "@dev"
```

to the `require` section of your `composer.json` file.

## Latest Release

> NOTE: The latest version of the module is v1.3.9. Refer the [CHANGE LOG](https://github.com/kartik-v/yii2-widget-datepicker/blob/master/CHANGE.md) for details.

## Demo

You can refer detailed [documentation and demos](http://demos.krajee.com/widget-details/datepicker) on usage of the extension.

## Usage

```php
use kartik\date\DatePicker;

// usage without model
echo '<label>Check Issue Date</label>';
echo DatePicker::widget([
	'name' => 'check_issue_date', 
	'value' => date('d-M-Y', strtotime('+2 days')),
	'options' => ['placeholder' => 'Select issue date ...'],
	'pluginOptions' => [
		'format' => 'dd-M-yyyy',
		'todayHighlight' => true
	]
]);
```

## License

**yii2-widget-datepicker** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.