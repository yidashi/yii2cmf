<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/19
 * Time: 上午12:12
 */

namespace backend\controllers;


use backend\models\ThemezipForm;
use Distill\Distill;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\UploadedFile;

class ThemeController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'open' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $packages = Yii::$app->get("themeManager")->findAll();
        $dataProvider = new ArrayDataProvider([
            "allModels" => $packages,
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
    public function actionView($id)
    {
        $theme = \Yii::$app->get("themeManager")->findOne($id);
        return $this->render("view", [
            "model" => $theme
        ]);
    }
    public function actionOpen($id)
    {
        /** @var $themeManager \common\components\ThemeManager  */
        $themeManager = \Yii::$app->get("themeManager");
        $theme = $themeManager->findOne($id);
        if ($theme != null) {
            if ($themeManager->setDefaultTheme($id) == true) {
                Yii::$app->session->setFlash("success", "设置主题成功,当前主题为" . $id);
            } else {
                Yii::$app->session->setFlash("error", "设置主题失败");
            }
        }

        return $this->redirect([
            "index"
        ]);
    }
    public function actionDemo($id)
    {
        $url = Yii::$app->config->get('FRONTEND_URL') . '?theme=' . $id;
        return $this->redirect($url);
    }
    public function actionCustom()
    {
        Yii::$app->session->setFlash("error", "暂未开放");
        return $this->redirect([
            "index"
        ]);
    }
    public function actionUpload()
    {
        $model = new ThemezipForm();

        if (\Yii::$app->getRequest()->getIsPost() == true && ($uploaded = UploadedFile::getInstance($model, "themezip")) != null) {

            $distill = new Distill();
            $themePath = Yii::getAlias(\Yii::$app->get("themeManager")->getThemePath());
            $extractFileName = $themePath . DIRECTORY_SEPARATOR . $uploaded->name;
            $pathinfo = pathinfo($extractFileName);
            $target = $pathinfo['dirname']. DIRECTORY_SEPARATOR . $pathinfo['filename'];
            if(is_dir($target)) {
                Yii::$app->session->setFlash("error", "主题路径已经存在该主题ID");
            } else {
                if (move_uploaded_file($uploaded->tempName, $extractFileName) == true) {
                    try {
                        if ($distill->extract($extractFileName, $themePath)) {
                            $newTheme = \Yii::$app->get("themeManager")->findByPath($target . DIRECTORY_SEPARATOR . $uploaded->getBaseName());
                            if (count($newTheme) === 1) {
                                Yii::$app->session->setFlash("success", "上传主题文件成功");
                            } else {
                                Yii::$app->session->setFlash("error", "上传主题配置文件不存在或者上传主题有错误");
                            }
                        } else {
                            throw new \Exception('解压文件失败');
                        }
                    }catch (\Exception $e) {
                        Yii::$app->session->setFlash("error", "解压文件失败");
                    }
                } else {
                    Yii::$app->session->setFlash("error", "移动文件失败,请确定你的临时目录是可写的");
                }
            }
            if (file_exists($uploaded->tempName)) {
                unlink($uploaded->tempName);
            }

            if (file_exists($extractFileName)) {
                unlink($extractFileName);
            }
            return $this->refresh();
        }

        return $this->render('upload', [
            "model" => $model
        ]);
    }
}