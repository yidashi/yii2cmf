<?php
/**
 * author: yidashi
 * Date: 2015/11/30
 * Time: 17:30.
 */
namespace frontend\behaviors;

use Detection\MobileDetect;
use yii\base\ActionFilter;
use Yii;

class ThemeBehavior extends ActionFilter
{
    public $themeParam = 'theme';
    public function beforeAction($action)
    {
        if (!$themeName = Yii::$app->request->get($this->themeParam)) {
            $isMobile = (new MobileDetect())->isMobile();
            if ($isMobile) {
                $themeName = \Yii::$app->config->get('MOBILE_THEME_NAME', 'mobile');
            } else {
                $themeName = \Yii::$app->config->get('THEME_NAME', 'basic');
            }
        }
        $theme = [
            'class' => 'yii\base\Theme',
            'basePath' => '@frontend/themes/' . $themeName,
            'baseUrl' => '@web/themes/' . $themeName,
            'pathMap' => [
                '@frontend/views' => [
                    '@frontend/themes/' . $themeName,
                    '@frontend/themes/basic',
                ],
            ],
        ];
//        $themeInfo = Yii::createObject('frontend\themes\\' . $themeName . '\Theme');
        \Yii::$app->view->theme = \Yii::createObject($theme);
        return true;
    }
}
