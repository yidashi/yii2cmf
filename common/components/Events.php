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
    public function listeners()
    {
        return [
            'common\models\Article.viewArticle' => 'common\listeners\ViewArticleListener'
        ];
    }

    public function bootstrap($app)
    {
        foreach ($this->listeners() as $event => $listener) {
            list($class, $name) = explode('.', $event);
            Event::on($class, $name, [$listener, 'handle']);
        }
    }
}