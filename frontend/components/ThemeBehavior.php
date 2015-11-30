<?php
/**
 * author: yidashi
 * Date: 2015/11/30
 * Time: 17:30
 */

namespace frontend\components;


use yii\base\Behavior;

class ThemeBehavior extends Behavior{
    public function init()
    {
        parent::init();
        $this->_setTheme();
    }
    private function _setTheme()
    {
        $config = [
            'class' => 'yii\base\Theme',
            'basePath' => '@app/themes/basic',
            'baseUrl' => '@web/themes/basic',
            'pathMap' => [
                '@app/views' => [
                    '@app/themes/special',
                    '@app/themes/basic',
                ]
            ],
        ];
        $theme =  \Yii::createObject($config);
        print_r($this->owner);die;
        print_r($theme);
    }
}