<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/5/3
 * Time: 下午6:59
 */

namespace yidashi\webuploader;

use Qiniu\Auth;
use Yii;
use yii\web\Response;
use yii\web\UploadedFile;

class Action extends \yii\base\Action
{
    public $driver;
    /**
     * @var array
     */
    public $config = [];


    public function init()
    {
        //close csrf
        Yii::$app->request->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($this->driver)) {
            $this->driver = isset(Yii::$app->params['webuploader_driver']) ? Yii::$app->params['webuploader_driver'] : 'local';
        }
        parent::init();
    }

    public function run()
    {
        switch ($this->driver) {
            case 'local':
                return $this->local();
                break;
            case 'qiniu':
                return $this->qiniu();
                break;
        }
    }

    private function local()
    {
        $uploader = UploadedFile::getInstanceByName('file');
        $root = Yii::getAlias('@staticroot');
        $path = 'upload/image/' . date('Ymd') . '/';
        $dir = $root . '/' . $path;
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $name = time() . '.' . $uploader->extension;
        $uploader->saveAs($dir . $name);
        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     "state" => "",          //上传状态，上传成功时必须返回"success"
         *     "url" => "",            //返回的地址
         *     "title" => "",          //新文件名
         *     "original" => "",       //原始文件名
         *     "type" => ""            //文件类型
         *     "size" => "",           //文件大小
         * )
         */
        return [
            'state' => 'success',
            'type' => $uploader->type,
            'size' => $uploader->size,
            'original' => $uploader->name,
            'url' => $path . $name,
            'title' => $name
        ];
    }

    private function qiniu()
    {
        $this->config = array_merge($this->config, Yii::$app->params['qiniu']);
        $bucket = $this->config['bucket'];
        $accessKey = $this->config['accessKey'];
        $secretKey = $this->config['secretKey'];

        $auth = new Auth($accessKey, $secretKey);
        $upToken = $auth->uploadToken($bucket);

        $ret = ['uptoken' => $upToken];

        return $ret;
    }
}