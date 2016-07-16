<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/16
 * Time: 上午11:14
 */

namespace common\actions;

use yii\base\Action;
use yii\base\DynamicModel;
use yii\base\InvalidCallException;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use Yii;


class UploadAction extends Action
{
    /**
     * @var string Path to directory where files will be uploaded
     */
    public $path;

    /**
     * @var string URL path to directory where files will be uploaded
     */
    public $url;

    /**
     * @var string Validator name
     */
    public $uploadOnlyImage = true;

    /**
     * @var string Variable's name that Imperavi Redactor sent upon image/file upload.
     */
    public $uploadParam = 'fileparam';

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

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->url === null) {
            throw new InvalidConfigException('The "url" attribute must be set.');
        } else {
            $this->url = rtrim($this->url, '/') . '/';
        }
        if ($this->path === null) {
            throw new InvalidConfigException('The "path" attribute must be set.');
        } else {
            $this->path = rtrim(Yii::getAlias($this->path), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

            if (!FileHelper::createDirectory($this->path)) {
                throw new InvalidCallException("Directory specified in 'path' attribute doesn't exist or cannot be created.");
            }
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
        if (Yii::$app->request->isPost) {
            $files = UploadedFile::getInstanceByName(Yii::$app->request->get($this->uploadParam));
            if (!$this->multiple) {
                $res = [$this->uploadOne($files)];
            } else {
                $res = $this->uploadMore($files);
            }
            Yii::$app->response->format = Response::FORMAT_JSON;

            return [
              'files' => $res
            ];
        } else {
            throw new BadRequestHttpException('Only POST is allowed');
        }

    }
    private function uploadMore($files) {
        $res = [];
        foreach ($files as $file) {
            $result = $this->uploadOne($file);
            $res[] = $result;
        }
        return $res;
    }
    private function uploadOne($file)
    {
        $model = new DynamicModel(compact('file'));
        $model->addRule('file', $this->_validator, $this->validatorOptions)->validate();

        if ($model->hasErrors()) {
            $result = [
                'error' => $model->getFirstError('file')
            ];
        } else {
            if ($this->unique === true && $model->file->extension) {
                $model->file->name = uniqid() . '.' . $model->file->extension;
            }
            if ($model->file->saveAs($this->path . $model->file->name)) {
                $result = [
                    'url' => $this->url . $model->file->name,
                    'thumbUrl' => $this->url . $model->file->name,
                    'extension' => $model->file->extension,
                    'type' => $model->file->type
                ];
                if ($this->uploadOnlyImage !== true) {
                    $result['filename'] = $model->file->name;
                }
            } else {
                $result = [
                    'error' => '上传失败'
                ];
            }
        }
        return $result;
    }
}
