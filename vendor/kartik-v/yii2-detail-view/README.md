yii2-detail-view
================

[![Latest Stable Version](https://poser.pugx.org/kartik-v/yii2-detail-view/v/stable)](https://packagist.org/packages/kartik-v/yii2-detail-view)
[![License](https://poser.pugx.org/kartik-v/yii2-detail-view/license)](https://packagist.org/packages/kartik-v/yii2-detail-view)
[![Total Downloads](https://poser.pugx.org/kartik-v/yii2-detail-view/downloads)](https://packagist.org/packages/kartik-v/yii2-detail-view)
[![Monthly Downloads](https://poser.pugx.org/kartik-v/yii2-detail-view/d/monthly)](https://packagist.org/packages/kartik-v/yii2-detail-view)
[![Daily Downloads](https://poser.pugx.org/kartik-v/yii2-detail-view/d/daily)](https://packagist.org/packages/kartik-v/yii2-detail-view)

An extended Yii2 DetailView with many additional features. Extends the Yii DetailView to support multi columnar rows and work in both VIEW and 
EDIT modes. Accelerates your development by using a single configuration of attributes for both VIEW and EDIT. The extension also 
includes easier methods to style your detail view widget cells, data, form inputs, widgets, and columns (more specifically for Bootstrap 3). 
The widget by default can be styled within a Bootstrap 3 panel with a buttons toolbar to toggle modes and control your data.
Refer [detailed documentation](http://demos.krajee.com/detail-view) and/or a [complete demo](http://demos.krajee.com/detail-view-demo).

### Latest Release
The latest version of the extension is release v1.7.4. Refer the [CHANGE LOG](https://github.com/kartik-v/yii2-detail-view/blob/master/CHANGE.md) for details of various releases.

> NOTE: The extension includes a BC Breaking change with v1.7.0. With this release, the `template` property of the yii core DetailView is not anymore supported. One can use `rowOptions`, `labelColOptions`, `valueColOptions` at the widget level or widget `attributes` level to configure advanced layout functions.

### Demo
You can see detailed [documentation](http://demos.krajee.com/detail-view) and [demonstration](http://demos.krajee.com/detail-view-demo) on usage of the extension.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

> Note: Check the [composer.json](https://github.com/kartik-v/yii2-detail-view/blob/master/composer.json) for this extension's requirements and dependencies. 
Read this [web tip /wiki](http://webtips.krajee.com/setting-composer-minimum-stability-application/) on setting the `minimum-stability` settings for your application's composer.json.

Either run

```
$ php composer.phar require kartik-v/yii2-detail-view "@dev"
```

or add

```
"kartik-v/yii2-detail-view": "@dev"
```

to the ```require``` section of your `composer.json` file.

## Usage
```php
use kartik\detail\DetailView;
echo DetailView::widget([
    'model'=>$model,
    'condensed'=>true,
    'hover'=>true,
    'mode'=>DetailView::MODE_VIEW,
    'panel'=>[
        'heading'=>'Book # ' . $model->id,
        'type'=>DetailView::TYPE_INFO,
    ],
    'attributes'=>[
        'code',
        'name',
        ['attribute'=>'publish_date', 'type'=>DetailView::INPUT_DATE],
    ]
]);
```

## License

**yii2-detail-view** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.
