<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/4
 * Time: 下午12:43
 */

namespace plugins\locale;


use yii\base\BootstrapInterface;
use yii\web\View;
use yii\base\Event;
use plugins\locale\controllers\DefaultController;
use Yii;

class Plugins extends \plugins\Plugins implements BootstrapInterface
{

    public static $language = [
        'zh-CN' => '简体中文',
        'en' => 'English'
    ];

    public $info = [
        'author' => '易大师',
        'version' => 'v1.0',
        'id' => 'locale',
        'name' => '本地化',
        'description' => '本地化'
    ];

    public function frontend($app)
    {
        Event::on(View::className(), 'beforeRenderRightMenu', [$this, 'handle']);
        $app->attachBehavior('locale', [
            'class' => 'plugins\locale\LocaleBehavior',
            'enablePreferredLanguage' => true
        ]);
        $config = $this->getConfig();
        $app->controllerMap['locale'] = [
            'class' => DefaultController::className(),
            'locales' => $config['availableLocales']
        ];
    }


    public function handle($event)
    {
        $config = $this->getConfig();
        $event->sender->params['rightMenuItems'][] = [
            'label'=>Yii::t('frontend', 'Language'),
            'items'=>array_map(function ($code) use ($config) {
                return [
                    'label' => self::$language[$code],
                    'url' => ['/locale/set', 'locale'=>$code],
                    'active' => Yii::$app->language === $code
                ];
            }, $config['availableLocales'])
        ];
    }
}