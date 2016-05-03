<?php
/**
 * author: yidashi
 * Date: 2015/12/18
 * Time: 16:53
 */

namespace common\widgets\qiniu;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use Qiniu\Auth;

class WebuploaderAction extends Action
{
    /**
     * @var array
     */
    public $config = [];


    public function init()
    {
        //close csrf
        Yii::$app->request->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;
        //默认设置
        $_config = require(__DIR__ . '/config.php');
        //load config file
        $this->config = ArrayHelper::merge($_config, $this->config);
        parent::init();
    }
    /**
     * 上传
     * @return string
     */
    public function run()
    {
        $bucket = $this->config['bucket'];
        $accessKey = $this->config['accessKey'];
        $secretKey = $this->config['secretKey'];

        $auth = new Auth($accessKey, $secretKey);
        $upToken = $auth->uploadToken($bucket);

        $ret = array('uptoken' => $upToken);

        return $ret;
    }
} 