<?php

namespace common\modules\i18n;

use common\modules\i18n\models\I18nMessage;
use common\modules\i18n\models\I18nSourceMessage;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = 'common\modules\i18n\controllers';

    public function bootstrap($app)
    {
        list(, $appName) = explode('-', $app->id);
        $app->set('i18n', [
            'class' => 'yii\i18n\I18N',
            'translations' => [
                '*'=> [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath'=>'@common/modules/i18n/messages',
                    'fileMap'=>[
                        'common'=>'common.php',
                        'backend'=>'backend.php',
                        'frontend'=>'frontend.php',
                    ],
                    'on missingTranslation' => [$this, 'missingTranslation']
                ],
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath'=>'@common/modules/i18n/messages',
                    'fileMap' => ['app' => $appName . '.php'],
                    'on missingTranslation' => [$this, 'missingTranslation']
                ],
                /*'*'=> [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceMessageTable'=>'{{%i18n_source_message}}',
                    'messageTable'=>'{{%i18n_message}}',
                    'enableCaching' => YII_ENV_DEV,
                    'cachingDuration' => 3600,
                    'on missingTranslation' => ['\common\modules\i18n\Module', 'missingTranslation']
                ],*/
            ],
        ]);
    }

    /**
     * @param \yii\i18n\MissingTranslationEvent $event
     */
    public function missingTranslation($event)
    {
        if (isset($this->params['is_auto_translate']) && $this->params['is_auto_translate']) {
            //http://fanyi.baidu.com/v2transapi?from=zh&query=世界&to=en
            // 当语言没命中的时候用百度翻译并保存到数据库
            $model = I18nSourceMessage::find()->where(['category' => $event->category, 'message' => $event->message])->one();
            if ($model == null) {
                $model = new I18nSourceMessage();
                $model->category = $event->category;
                $model->message = $event->message;
                $model->save();
            }
            $messageModel = I18nMessage::find()->where(['id' => $model->id, 'language' => $event->language])->one();
            if ($messageModel == null) {
                $messageModel = new I18nMessage();
                $messageModel->language = $event->language;
                $messageModel->id = $model->id;
                $messageModel->translation = self::translate($event->message, 'en', self::parseLanguage($event->language));
                $messageModel->save();
            }
            $event->translatedMessage = $messageModel->translation;
        }
    }

    public static function parseLanguage($language)
    {
        $languageMap = [
            'zh-CN' => 'zh'
        ];
        return $languageMap[$language];
    }

    public static function translate($text, $from , $to)
    {
        $url = "http://fanyi.baidu.com/v2transapi";
        $data = array (
            'from' => $from,
            'to' => $to,
            'query' => $text
        );
        $data = http_build_query($data);
        $ch = curl_init ();
        curl_setopt ($ch, CURLOPT_URL, $url );
        curl_setopt ($ch, CURLOPT_REFERER, "http://fanyi.baidu.com" );
        curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:37.0) Gecko/20100101 Firefox/37.0' );
        curl_setopt ($ch, CURLOPT_HEADER, 0 );
        curl_setopt ($ch, CURLOPT_POST, 1 );
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $data );
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ($ch, CURLOPT_TIMEOUT, 10 );
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result, true);

        if (!isset($result['trans_result']['data']['0']['dst'])){
            return false;
        }
        return $result['trans_result']['data']['0']['dst'];
    }
}
