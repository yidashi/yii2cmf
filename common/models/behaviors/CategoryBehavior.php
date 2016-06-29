<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/29
 * Time: 下午4:17
 */

namespace common\models\behaviors;


use common\models\Article;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class CategoryBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_UPDATE => [$this, 'afterUpdateInternal'],
        ];
    }

    public function afterUpdateInternal($event)
    {
        // 如果修改了分类名,更新文章表分类名冗余字段
        $changedAttributes = $event->changedAttributes;
        if (isset($changedAttributes['title'])) {
            Article::updateAll(['category' => $event->sender->title], ['category_id' => $event->sender->id]);
        }
    }
}