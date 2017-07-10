<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/4
 * Time: 下午1:46
 */

namespace plugins\statistics;


use yii\base\BootstrapInterface;
use yii\web\View;
use yii\base\Event;

class Plugin extends \plugins\Plugin implements BootstrapInterface
{
    public $info = [
        'author' => '易大师',
        'version' => 'v1.0',
        'id' => 'statistics',
        'name' => '第三方统计',
        'description' => '第三方统计'
    ];

    public function bootstrap($app)
    {
        Event::on(View::className(), 'endBody', [$this, 'run']);
    }

    public function run()
    {
        $config = $this->getConfig();
        echo $config['statistics_content'];
    }
}