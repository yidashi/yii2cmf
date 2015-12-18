<?php
/**
 * author: yidashi
 * Date: 2015/12/18
 * Time: 16:53
 */

namespace yidashi\webuploader;
use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use yii\web\Response;

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
        $base64 = "upload";
        $action = 'uploadimage';
        switch ($action) {
            case 'uploadimage':
                $config = array(
                    "pathFormat" => $this->config['imagePathFormat'],
                    "maxSize" => $this->config['imageMaxSize'],
                    "allowFiles" => $this->config['imageAllowFiles']
                );
                $fieldName = $this->config['imageFieldName'];
                break;
            case 'uploadscrawl':
                $config = array(
                    "pathFormat" => $this->config['scrawlPathFormat'],
                    "maxSize" => $this->config['scrawlMaxSize'],
                    "allowFiles" => $this->config['scrawlAllowFiles'],
                    "oriName" => "scrawl.png"
                );
                $fieldName = $this->config['scrawlFieldName'];
                $base64 = "base64";
                break;
            case 'uploadvideo':
                $config = array(
                    "pathFormat" => $this->config['videoPathFormat'],
                    "maxSize" => $this->config['videoMaxSize'],
                    "allowFiles" => $this->config['videoAllowFiles']
                );
                $fieldName = $this->config['videoFieldName'];
                break;
            case 'uploadfile':
            default:
                $config = array(
                    "pathFormat" => $this->config['filePathFormat'],
                    "maxSize" => $this->config['fileMaxSize'],
                    "allowFiles" => $this->config['fileAllowFiles']
                );
                $fieldName = $this->config['fileFieldName'];
                break;
        }
        /* 生成上传实例对象并完成上传 */

        $up = new Uploader($fieldName, $config, $base64);
        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
         *     "url" => "",            //返回的地址
         *     "title" => "",          //新文件名
         *     "original" => "",       //原始文件名
         *     "type" => ""            //文件类型
         *     "size" => "",           //文件大小
         * )
         */

        /* 返回数据 */
        return $up->getFileInfo();
    }
} 