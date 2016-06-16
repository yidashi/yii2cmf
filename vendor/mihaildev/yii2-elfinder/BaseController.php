<?php
/**
 * Date: 09.12.2014
 * Time: 17:20
 *
 * This file is part of the MihailDev project.
 *
 * (c) MihailDev project <http://github.com/mihaildev/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

namespace mihaildev\elfinder;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\JsExpression;


/**
 * Class BaseController
 *
 * @package mihaildev\elfinder
 */
class BaseController extends Controller{
	public $access = ['@'];
	public $user = 'user';
	public $managerOptions = [];
	public $connectOptions = [];

	public function behaviors()
	{
		return [
			'access' => [
				'user' => $this->user,
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => $this->access,
					],
				],
			],
		];
	}

	public function getOptions(){
		return $this->connectOptions;
	}

	public function actionConnect(){
		return $this->renderFile(__DIR__."/views/connect.php", ['options'=>$this->getOptions()]);
	}

	public function getManagerOptions(){
		$options = [
			'url'=> Url::toRoute('connect'),
			'customData' => [
				Yii::$app->request->csrfParam => Yii::$app->request->csrfToken
			],
			'resizable' => false
		];

		if(isset($_GET['CKEditor'])){
			$options['getFileCallback'] = new JsExpression('function(file){ '.
				'window.opener.CKEDITOR.tools.callFunction('.Json::encode($_GET['CKEditorFuncNum']).', file.url); '.
				'window.close(); }');

			$options['lang'] = $_GET['langCode'];
		}

		if(isset($_GET['filter'])){
			if(is_array($_GET['filter']))
				$options['onlyMimes'] = $_GET['filter'];
			else
				$options['onlyMimes'] = [$_GET['filter']];
		}

		if(isset($_GET['lang']))
			$options['lang'] = $_GET['lang'];

		if(isset($_GET['callback'])){
			if(isset($_GET['multiple']))
				$options['commandsOptions']['getfile']['multiple'] = true;

			$options['getFileCallback'] = new JsExpression('function(file){ '.
				'if (window!=window.top) {var parent = window.parent;}else{var parent = window.opener;}'.
				'if(parent.mihaildev.elFinder.callFunction('.Json::encode($_GET['callback']).', file))'.
				'window.close(); }');
		}

		if(!isset($options['lang']))
			$options['lang'] = ElFinder::getSupportedLanguage(Yii::$app->language);

		if(!empty($this->disabledCommands))
			$options['commands'] = new JsExpression('ElFinderGetCommands('.Json::encode($this->disabledCommands).')');


		return ArrayHelper::merge($options, $this->managerOptions);
	}

	public function actionManager(){
		return $this->renderFile(__DIR__."/views/manager.php", ['options'=>$this->getManagerOptions()]);
	}
} 
