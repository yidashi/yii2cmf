<?php

namespace mihaildev\elfinder;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class Assets extends AssetBundle
{
	public $css = array(
		'css/elfinder.min.css',
		'css/theme.css',
	);
	public $js = array(
		'js/elfinder.min.js'
	);
	public $depends = array(
		'yii\jui\JuiAsset',
	);

	public function init()
	{
		$this->sourcePath = __DIR__."/assets";
		parent::init();
	}

	/**
	 * @param string $lang
	 * @param \yii\web\View $view
	 */
	public static function addLangFile($lang, $view){
		$lang = ElFinder::getSupportedLanguage($lang);

		if ($lang !== false && $lang !== 'en'){
			list(,$path) = \Yii::$app->assetManager->publish(__DIR__."/assets");
			$view->registerJsFile($path.'/js/i18n/elfinder.' . $lang . '.js', ['depends' => [Assets::className()]]);
		}
	}

	/**
	 * @param \yii\web\View $view
	 */
	public static function noConflict($view){
		list(,$path) = \Yii::$app->assetManager->publish(__DIR__."/assets");
		$view->registerJsFile($path.'/js/no.conflict.js', ['depends' => [JqueryAsset::className()]]);
	}
}
