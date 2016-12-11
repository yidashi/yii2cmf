<?php
/**
 * author: yidashi
 * Date: 2015/11/30
 * Time: 17:30.
 */
namespace frontend\behaviors;

use Detection\MobileDetect;
use Yii;
use yii\base\ActionFilter;

class ThemeBehavior extends ActionFilter
{
    public $themeParam = 'theme';

    public $themeCookieName = 'localThemeName';
    public function beforeAction($action)
    {
        $themeName = $this->resolveTheme();
        $this->setTheme($themeName);
        return true;
    }

    public function resolveTheme()
    {
        //先看参数
        if (!$themeName = Yii::$app->request->get($this->themeParam)) {
            //再检查cookie
            if (Yii::$app->request->cookies->has($this->themeCookieName)) {
                $themeName = Yii::$app->request->cookies->get($this->themeCookieName);
            } else {
                //最后读系统默认
                $isMobile = (new MobileDetect())->isMobile();
                if ($isMobile) {
                    $themeName = \Yii::$app->config->get('MOBILE_THEME_NAME', 'basic');
                } else {
                    $themeName = \Yii::$app->config->get('THEME_NAME', 'basic');
                }
            }
        }
        return $themeName;
    }
    public function setTheme($themeName)
    {
        $theme = [
            'class' => 'yii\base\Theme',
            'basePath' => '@frontend/themes/' . $themeName,
            'baseUrl' => '@web/themes/' . $themeName,
            'pathMap' => [
                '@frontend/views' => [
                    '@frontend/themes/' . $themeName,
                    '@frontend/themes/basic',
                ],
                '@frontend/widgets' => [
                    '@frontend/themes/' . $themeName . '/widgets',
                    '@frontend/themes/basic/widgets'
                ],
            ],
        ];
        \Yii::$app->view->theme = \Yii::createObject($theme);
        if (class_exists('frontend\\themes\\' . $themeName . '\\Theme')) {
            $themeClass = Yii::createObject('frontend\\themes\\' . $themeName . '\\Theme');
            if (method_exists($themeClass, 'bootstrap')) {
                $themeClass->bootstrap();
            }
        }
    }
}
