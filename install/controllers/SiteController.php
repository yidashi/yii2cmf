<?php
namespace install\controllers;


use common\components\ModuleManager;
use common\modules\user\models\User;
use yii\web\Controller;
use Yii;
use install\models\DatabaseForm;
use install\models\SiteForm;
use install\models\AdminForm;

class SiteController extends Controller
{
    protected function renderJson($status = true, $message = '')
    {
        Yii::$app->response->format = 'json';
        return [
            'status' => $status,
            'message' => $message
        ];
    }

    public $migrationPath = '@database/migrations';

    public $migrationTable = '{{%migration}}';

    public $envPath = '@root/.env';

    public function init()
    {
        parent::init();
        $this->migrationPath = Yii::getAlias($this->migrationPath);
    }

    /**
     * Lists all Menu models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLanguage()
    {
        return $this->render('index');
    }

    public function actionLicenseAgreement()
    {
        if (\Yii::$app->getRequest()->isPost) {
            if (\Yii::$app->getRequest()->post("license") == "on") {
                return $this->renderJson(true);
            } else {
                return $this->renderJson(false, "同意安装协议才能继续安装!");
            }
        }

        return $this->render('license');
    }

    public function actionCheckEnv()
    {
        $checkResult = include Yii::getAlias('@install/requirements.php');
        // Render template
        return $this->render('checkenv', [
            "data" => $checkResult
        ]);
    }

    public function actionCheckDirFile()
    {
        $items = [
            ['dir',  '可写', 'success', '@root/cache'],
            ['dir',  '可写', 'success', '@backend/runtime'],
            ['dir',  '可写', 'success', '@frontend/runtime'],
            ['dir',  '可写', 'success', '@api/runtime'],
            ['dir',  '可写', 'success', '@root/web/storage'],
            ['dir',  '可写', 'success', '@root/web/assets'],
            ['dir',  '可写', 'success', '@root/web/admin/assets'],
            ['dir',  '可写', 'success', '@root/web/api/assets'],
        ];
        $result = true;
        foreach ($items as &$val) {
            $val[3] =	Yii::getAlias($val[3]);
            if('dir' == $val[0]){
                if(!is_writable($val[3])) {
                    if(is_dir($val[3])) {
                        $val[1] = '可读';
                        $val[2] = 'error';
                    } else {
                        $val[1] = '不存在';
                        $val[2] = 'error';
                    }
                    $result = false;
                }
            } else {
                if(file_exists($val[3])) {
                    if(!is_writable($val[3])) {
                        $val[1] = '不可写';
                        $val[2] = 'error';
                        $result = false;
                    }
                } else {
                    if(!is_writable(dirname($val[3]))) {
                        $val[1] = '不存在';
                        $val[2] = 'error';
                        $result = false;
                    }
                }
            }
        }
        if (Yii::$app->request->isPost) {
            if ($result == true) {
                return $this->renderJson(true);
            }else {
                return $this->renderJson(false, '请确保目录和文件拥有指定权限');
            }
        }
        return $this->render('checkdirfile', [
            "items" => $items
        ]);
    }
    public function actionSelectDb()
    {
        return $this->render('index');
    }

    public function actionSetDb()
    {
        $model = new DatabaseForm();

        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate() && $model->save()) {
                return $this->renderJson(true);
            } else {
                return $this->renderJson(false, current($model->getFirstErrors()));
            }
        }

        return $this->render('setdb', [
            "model" => $model
        ]);
    }

    public function actionSetSite()
    {
        $model = new SiteForm();

        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate() && $model->save()) {
                return $this->renderJson(true);
            } else {
                return $this->renderJson(false, current($model->getFirstErrors()));
            }
        }

        return $this->render('setsite', [
            "model" => $model
        ]);
    }

    public function actionSetAdmin()
    {
        $model = new AdminForm();

        $model->loadDefaultValues();
        if ($model->load(Yii::$app->request->post())) {

            if (!$model->validate() || !$model->save()) {
                return $this->renderJson(false, current($model->getFirstErrors()));
            }

            $error = $this->installDb();
            if ($error != null) {
                return $this->renderJson(false, $error);
            }

            //安装核心模块
            $this->installConfig();
            // 创建用户
            $error = $this->createAdminUser();
            if ($error != null) {
                return $this->renderJson(false, $error);
            }
            return $this->renderJson(true);

        }

        return $this->render('setadmin', [
            "model" => $model
        ]);
    }

    public function actionSelectModule()
    {
        $moduleManager = new ModuleManager();
        $modules = $moduleManager->findAll();
        if (Yii::$app->request->isPost) {
            $installModules = Yii::$app->request->post('modules', []);
            foreach ($installModules as $installModule) {
                $installModuleInfo = $moduleManager->findOne($installModule);
                $moduleManager->install($installModuleInfo);
            }
            // 安装核心模块
            $cores = $moduleManager->findCore();
            foreach ($cores as $core) {
                $moduleManager->install($core);
            }
            //清缓存
            \Yii::$app->getCache()->flush();
            //安装完成
            Yii::$app->setInstalled();
            return $this->renderJson(true);
        }
        return $this->render('selectmodule', [
            "modules" => $modules
        ]);
    }
    /**
     * 安装数据库
     */
    public function installDb()
    {
        $handle = opendir($this->migrationPath);
        while (($file = readdir($handle)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $path = $this->migrationPath . DIRECTORY_SEPARATOR . $file;
            if (preg_match('/^(m(\d{6}_\d{6})_.*?)\.php$/', $file, $matches) && !isset($applied[$matches[2]]) && is_file($path)) {
                $migrations[] = $matches[1];
            }
        }
        closedir($handle);
        sort($migrations);

        $error = "";

        ob_start();
        if (Yii::$app->db->schema->getTableSchema($this->migrationTable, true) === null) {
            $this->createMigrationHistoryTable();
        }
        foreach ($migrations as $migration) {
            $migrationClass = $this->createMigration($migration);
            try {
                if ($migrationClass->up() === false) {
                    $error = "数据库迁移失败";
                }
                $this->addMigrationHistory($migration);
            } catch (\Exception $e) {
                $error = "数据表已经存在，或者其他错误！";
            }
        }
        ob_end_clean();

        if (! empty($error)) {
            return $error;
        }
        return null;
    }
    //写入配置文件
    public function installConfig()
    {
        \Yii::$app->setKeys($this->envPath);
        $data = \Yii::$app->getCache()->get(SiteForm::CACHE_KEY);
        foreach ($data as $name => $value) {
            Yii::$app->setEnv($name, $value);
        }
        return true;
    }

    public function createAdminUser()
    {
        $data = \Yii::$app->getCache()->get(AdminForm::CACHE_KEY);
        $user = new User();
        $user->setScenario("create");
        $user->email = $data["email"];
        $user->username = $data["username"];
        $user->password = $data["password"];

        if($user->create() == false) {
            return current($user->getFirstErrors());
        }
        return null;
    }

    protected function createMigrationHistoryTable()
    {
        Yii::$app->db->createCommand()->createTable($this->migrationTable, [
            'version' => 'varchar(180) NOT NULL PRIMARY KEY',
            'apply_time' => 'integer',
        ])->execute();
        Yii::$app->db->createCommand()->insert($this->migrationTable, [
            'version' => 'm000000_000000_base',
            'apply_time' => time(),
        ])->execute();
    }

    protected function createMigration($class)
    {
        $file = $this->migrationPath . DIRECTORY_SEPARATOR . $class . '.php';
        require_once($file);

        return new $class();
    }

    protected function addMigrationHistory($version)
    {
        $command = Yii::$app->db->createCommand();
        $command->insert($this->migrationTable, [
            'version' => $version,
            'apply_time' => time(),
        ])->execute();
    }
}
