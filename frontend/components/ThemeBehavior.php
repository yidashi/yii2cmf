<?php
/**
 * author: yidashi
 * Date: 2015/11/30
 * Time: 17:30.
 */
namespace frontend\components;

use common\models\Config;
use Detection\MobileDetect;
use yii\base\ActionFilter;
use yii\web\View;

class ThemeBehavior extends ActionFilter
{
    public function beforeAction($action)
    {
        $isMobile = (new MobileDetect())->isMobile();
        $themeName = \Yii::$app->config->get('THEME_NAME', 'basic');
        $theme = [
            'class' => 'yii\base\Theme',
            'basePath' => '@frontend/themes/basic',
            'baseUrl' => '@web/themes/basic',
            'pathMap' => [
                '@frontend/views' => [
                    '@frontend/themes/'.($isMobile ? 'mobile' : $themeName),
                    '@frontend/themes/basic',
                ],
            ],
        ];
        \Yii::$app->view->theme = \Yii::createObject($theme);
        return true;
    }
}
