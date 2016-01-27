<?php
/**
 * author: yidashi
 * Date: 2015/11/30
 * Time: 17:30.
 */
namespace frontend\components;

use Detection\MobileDetect;
use yii\base\ActionFilter;

class ThemeBehavior extends ActionFilter
{
    public function beforeAction($action)
    {
        $device = new MobileDetect();
        $theme = [
            'class' => 'yii\base\Theme',
            'basePath' => '@app/themes/basic',
            'baseUrl' => '@web/themes/basic',
            'pathMap' => [
                '@app/views' => [
                    '@app/themes/'.($device->isMobile() ? 'mobile' : 'special'),
                    '@app/themes/basic',
                ],
            ],
        ];
        \Yii::$app->getView()->theme = \Yii::createObject($theme);

        return true;
    }
}
