<?php

namespace common\modules\config\controllers;

use common\modules\config\models\Config;
use common\modules\config\models\DatabaseConfigForm;
use common\modules\config\models\MailConfigForm;
use Yii;
use yii\web\Controller;
use yii\base\Model;
use yii\caching\TagDependency;

/**
 * ConfigController implements the CRUD actions for Config model.
 */
class DefaultController extends Controller
{
    public function actionIndex()
    {
        $groups = Yii::$app->config->get('CONFIG_GROUP');
        $group = Yii::$app->request->get('group', current(array_keys($groups)));
        $configModels = Config::find()->where(['group' => $group])->all();
        return $this->render('index', [
            'groups' => $groups,
            'group' => $group,
            'configModels' => $configModels
        ]);
    }
    public function actionStore()
    {
        $groups = Yii::$app->config->get('CONFIG_GROUP');
        $group = Yii::$app->request->get('group', current(array_keys($groups)));
        $configModels = Config::find()->where(['group' => $group])->all();
        if (Model::loadMultiple($configModels, \Yii::$app->request->post()) && Model::validateMultiple($configModels)) {
            foreach ($configModels as $configModel) {
                /* @var $config Config */
                $configModel->save(false);
            }
            TagDependency::invalidate(\Yii::$app->cache,  Yii::$app->config->cacheTag);
            Yii::$app->session->setFlash('success', '保存成功');
            return $this->redirect(['index', 'group' => $group]);
        } else {
            Yii::$app->session->setFlash('error', '保存失败');
            return $this->redirect(['index', 'group' => $group]);
        }
    }

    public function actionDatabase()
    {
        $model = new DatabaseConfigForm();
        $model->loadDefaultValues();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('database');
        }
        return $this->render('database', [
            'model' => $model
        ]);
    }

    public function actionMail()
    {
        $model = new MailConfigForm();
        $model->loadDefaultValues();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('mail');
        }
        return $this->render('mail', [
            'model' => $model
        ]);
    }
}
