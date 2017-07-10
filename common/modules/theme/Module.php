<?php
/**
 * Created by PhpStorm.
 * Author: yidashi
 * DateTime: 2017/7/10 13:46
 * Description:
 */
namespace common\modules\theme;

use Detection\MobileDetect;
use Yii;
use yii\base\BootstrapInterface;

class Module extends \common\modules\Module implements BootstrapInterface
{
    public function bootstrap($app)
    {
        if ($app->id == 'frontend') {
            $themeName = $this->resolveTheme();
            $this->setTheme($themeName);
        }
    }
    public $themeParam = 'theme';

    public $themeCookieName = 'localThemeName';

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
                    $themeName = \Yii::$app->config->get('mobile_theme_name', 'basic');
                } else {
                    $themeName = \Yii::$app->config->get('theme_name', 'basic');
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
                '@common/modules' => [
                    '@frontend/themes/' . $themeName . '/modules',
                    '@frontend/themes/basic/modules',
                ],
            ],
        ];
        \Yii::$app->view->theme = \Yii::createObject($theme);
//        p(\Yii::$app->view->theme);
        if (class_exists('frontend\\themes\\' . $themeName . '\\Theme')) {
            $themeClass = Yii::createObject('frontend\\themes\\' . $themeName . '\\Theme');
            if (method_exists($themeClass, 'bootstrap')) {
                $themeClass->bootstrap();
            }
        }
    }
}