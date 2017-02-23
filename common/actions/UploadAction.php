<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/16
 * Time: 上午11:14
 */

namespace common\actions;

use Yii;
use yii\base\Action;
use yii\base\DynamicModel;
use yii\base\Exception;
use yii\base\InvalidCallException;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\UploadedFile;


class UploadAction extends Action
{
    /**
     * @var \yii\db\ActiveRecord
     */
    public $modelClass = 'common\models\attachment';
    /**
     * @var string Path to directory where files will be uploaded
     */
    public $path;

    /**
     * @var string Validator name
     */
    public $uploadOnlyImage = true;

    /**
     * @var string Variable's name that Imperavi Redactor sent upon image/file upload.
     */
    public $uploadParam = 'file';
    /**
     * @var string 参数指定文件名
     */
    public $uploadQueryParam = 'fileparam';

    /**
     * @var boolean If `true` unique filename will be generated automatically
     */
    public $unique = true;

    public $multiple = false;

    /**
     * @var array Model validator options
     */
    public $validatorOptions = [];

    /**
     * @var string Model validator name
     */
    private $_validator = 'image';

    public $deleteUrl = ['/upload/delete'];

    public $callback;

    public $itemCallback;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (Yii::$app->request->get($this->uploadQueryParam)) {
            $this->uploadParam = Yii::$app->request->get($this->uploadQueryParam);
        }
        if ($this->modelClass) {
            $this->modelClass = Yii::createObject($this->modelClass);
        }
        if ($this->uploadOnlyImage !== true) {
            $this->_validator = 'file';
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isPost) {
            $files = UploadedFile::getInstancesByName($this->uploadParam);
//            p($files);
            if (!$this->multiple) {
                $res = [$this->uploadOne($files[0])];
            } else {
                $res = $this->uploadMore($files);
            }
            $result = [
                'files' => $res
            ];
            if ($this->callback instanceof \Closure) {
                $result = call_user_func($this->callback, $result);
            }
            return $result;
        } else {
            throw new BadRequestHttpException('Only POST is allowed');
        }

    }
    private function uploadMore(array $files) {
        $res = [];
        foreach ($files as $file) {

            $result = $this->uploadOne($file);
            $res[] = $result;
        }
        return $res;
    }
    private function uploadOne(UploadedFile $file)
    {
        try {
            $model = new DynamicModel(compact('file'));
            $model->addRule('file', $this->_validator, $this->validatorOptions)->validate();

            if ($model->hasErrors()) {
                throw new Exception($model->getFirstError('file'));
            } else {
                $hash = md5_file($file->tempName);
                $attachment = $this->modelClass->find()->where(['hash' => $hash])->one();
                if (empty($attachment)) {
                    if ($this->unique === true && $file->extension) {
                        $file->name = uniqid() . '.' . $file->extension;
                    }
                    $filePath = $this->path . $file->name;
                    if (Yii::$app->storage->upload($filePath, $file->tempName)) {
                        /**
                         * @var \common\models\Attachment $attachment
                         */
                        $attachment = new $this->modelClass;
                        $attachment->path = $filePath;
                        $attachment->name = $file->name;
                        $attachment->extension = $file->extension;
                        $attachment->type = $file->type;
                        $attachment->size = $file->size;
                        $attachment->hash = $hash;
                        $attachment->save();
                    } else {
                        throw new Exception('上传失败');
                    }
                }
                $result = [
                    'id' => $attachment->id,
                    'url' => $attachment->getUrl(),
                    'extension' => $attachment->extension,
                    'type' => $attachment->type,
                    'size' => $attachment->size,
                    'deleteUrl' => Url::to(array_merge($this->deleteUrl, ['id' => $attachment->id]))
                ];
                if ($this->uploadOnlyImage !== true) {
                    $result['filename'] = $attachment->name;
                }
            }
        } catch (Exception $e) {
            $result = [
                'error' => $e->getMessage()
            ];
        }
        if ($this->itemCallback instanceof \Closure) {
            $result = call_user_func($this->itemCallback, $result);
        }
        return $result;
    }
}
