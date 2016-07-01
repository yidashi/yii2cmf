<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/29
 * Time: 上午11:16
 */

namespace common\components;


use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\Event;

class Events extends Component implements BootstrapInterface
{
    /**
     * @return array   事件处理器 => 类名.事件名
     */
    public function listeners()
    {
        return [
            'common\listeners\ViewArticleListener' => 'common\models\Article.viewArticle'
        ];
    }

    public function bootstrap($app)
    {
        foreach ($this->listeners() as $listener => $event) {
            list($class, $name) = explode('.', $event);
            Event::on($class, $name, [$listener, 'handle']);
        }
    }
}