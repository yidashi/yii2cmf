yii2-helpers
============

[![Latest Stable Version](https://img.shields.io/packagist/v/kartik-v/yii2-helpers.svg)](https://packagist.org/packages/kartik-v/yii2-helpers)
[![License](https://poser.pugx.org/kartik-v/yii2-helpers/license)](https://packagist.org/packages/kartik-v/yii2-helpers)
[![Total Downloads](https://poser.pugx.org/kartik-v/yii2-helpers/downloads)](https://packagist.org/packages/kartik-v/yii2-helpers)
[![Monthly Downloads](https://poser.pugx.org/kartik-v/yii2-helpers/d/monthly)](https://packagist.org/packages/kartik-v/yii2-helpers)
[![Daily Downloads](https://poser.pugx.org/kartik-v/yii2-helpers/d/daily)](https://packagist.org/packages/kartik-v/yii2-helpers)

This extension is a collection of useful helper functions for Yii Framework 2.0.

### Html Class
[```VIEW DEMO```](http://demos.krajee.com/helper-functions/html)  

This class extends the [Yii Html Helper](https://github.com/yiisoft/yii2/blob/master/framework/helpers/Html.php) to incorporate additional HTML markup functionality and features available in [Bootstrap 3.0](http://getbootstrap.com/). The helper functions available in this class are:
- Icon
- Label
- Badge
- Page Header
- Well
- Close Button
- Caret
- Jumbotron
- Abbreviation
- Blockquote
- Address
- List Group
- Panel
- Media
- Media List
- Checkbox Button Group
- Radio Button Group

### Enum Class
[```VIEW DEMO```](http://demos.krajee.com/helper-functions/enum)  

This class extends the [Yii Inflector Helper](https://github.com/yiisoft/yii2/blob/master/framework/helpers/Inflector.php) with more utility functions for Yii developers. The helper functions available in this class are:
- Is Empty
- In Array
- Properize
- Time Elapsed
- Time To String
- Time Remaining
- Format Bytes
- Number to Words
- Year List
- Month List
- Day List
- Date List
- Time List
- Boolean List
- Get PHP Data Type
- Array to HTML Table
- IP Address

### Demo
You can see a [demonstration here](http://demos.krajee.com/helpers) on usage of these functions with documentation and examples.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).


> Note: Check the [composer.json](https://github.com/kartik-v/yii2-helpers/blob/master/composer.json) for this extension's requirements and dependencies. 
Read this [web tip /wiki](http://webtips.krajee.com/setting-composer-minimum-stability-application/) on setting the `minimum-stability` settings for your application's composer.json.

Either run

```
$ php composer.phar require kartik-v/yii2-helpers "dev-master"
```

or add

```
"kartik-v/yii2-helpers": "dev-master"
```

to the ```require``` section of your `composer.json` file.

## Usage

```php
// add this to your code to use these classes
use kartik\helpers\Html;
use kartik\helpers\Enum;

// examples of usage
echo Html::icon('cloud');
echo Enum::properize('Chris');
```

## License

**yii2-helpers** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.
