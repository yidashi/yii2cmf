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
     * @var array 事件处理器 => 类名.事件名
     */
    private $_listeners = [
        'common\listeners\ViewArticleListener' => 'common\models\Article.viewArticle'
    ];
    /**
     * @return array
     */
    public function listeners()
    {
        return $this->_listeners;
    }

    public function addListener(array $listener)
    {
        $this->_listeners = array_merge($this->_listeners, $listener);
    }
    public function bootstrap($app)
    {
        foreach ($this->listeners() as $listener => $event) {
            list($class, $name) = explode('.', $event);
            // 同一个键可能监听多个事件,暂时想不到好的处理方法 @分隔下
            if (strpos($listener, '@') !== false) {
                list($listener,$many) = explode('@', $listener);
            }
            Event::on($class, $name, [$listener, 'handle']);
        }
    }
}