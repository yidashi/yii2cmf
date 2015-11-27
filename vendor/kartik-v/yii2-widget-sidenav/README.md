yii2-widget-sidenav
===================

This widget is a collapsible side navigation menu built to seamlessly work with Bootstrap framework. It is built over Bootstrap [stacked nav](http://getbootstrap.com/components/#nav-pills) component. This widget class extends the [Yii Menu widget](https://github.com/yiisoft/yii2/blob/master/framework/widgets/Menu.php). Upto 3 levels of submenus are by default supported by the CSS styles to balance performance and useability. You can choose to extend it to more or less levels by customizing the [CSS](https://github.com/kartik-v/yii2-widgets/blob/master/assets/css/sidenav.css). 

> NOTE: This extension is a sub repo split of [yii2-widgets](https://github.com/kartik-v/yii2-widgets). The split has been done since 08-Nov-2014 to allow developers to install this specific widget in isolation if needed. One can also use the extension the previous way with the whole suite of [yii2-widgets](http://demos.krajee.com/widgets).

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/). Check the [composer.json](https://github.com/kartik-v/yii2-widget-sidenav/blob/master/composer.json) for this extension's requirements and dependencies. Read this [web tip /wiki](http://webtips.krajee.com/setting-composer-minimum-stability-application/) on setting the `minimum-stability` settings for your application's composer.json.

To install, either run

```
$ php composer.phar require kartik-v/yii2-widget-sidenav "*"
```

or add

```
"kartik-v/yii2-widget-sidenav": "*"
```

to the ```require``` section of your `composer.json` file.

## Latest Release

> NOTE: The latest version of the module is v1.0.0 released on 08-Nov-2014. Refer the [CHANGE LOG](https://github.com/kartik-v/yii2-widget-sidenav/blob/master/CHANGE.md) for details.

## Demo

You can refer detailed [documentation and demos](http://demos.krajee.com/widget-details/sidenav) on usage of the extension.

## Usage

```php
use kartik\sidenav\SideNav;
     
echo SideNav::widget([
	'type' => SideNav::TYPE_DEFAULT,
	'heading' => 'Options',
	'items' => [
		[
			'url' => '#',
			'label' => 'Home',
			'icon' => 'home'
		],
		[
			'label' => 'Help',
			'icon' => 'question-sign',
			'items' => [
				['label' => 'About', 'icon'=>'info-sign', 'url'=>'#'],
				['label' => 'Contact', 'icon'=>'phone', 'url'=>'#'],
			],
		],
	],
]);
```

## License

**yii2-widget-sidenav** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.