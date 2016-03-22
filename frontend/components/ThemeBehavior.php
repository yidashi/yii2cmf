<?php
/**
 * author: yidashi
 * Date: 2015/11/30
 * Time: 17:30.
 */
namespace frontend\components;

use Detection\MobileDetect;
use yii\base\ActionFilter;
use yii\web\View;

class ThemeBehavior extends ActionFilter
{
    public function beforeAction($action)
    {
        $device = new MobileDetect();
        $theme = [
            'basePath' => '@app/themes/basic',
            'baseUrl' => '@web/themes/basic',
            'pathMap' => [
                '@app/views' => [
                    '@app/themes/'.($device->isMobile() ? 'mobile' : 'special'),
                    '@app/themes/basic',
                ],
            ],
        ];
        \Yii::$container->set(View::className(),['theme' => $theme]);
        return true;
    }
}
