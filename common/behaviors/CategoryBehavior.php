<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/3/12
 * Time: 下午4:36
 */

namespace common\behaviors;


use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\models\Category;

class CategoryBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_DELETE => [$this, 'afterDeleteInternal'],
            SoftDeleteBehavior::EVENT_AFTER_SOFT_DELETE => [$this, 'afterSoftDeleteInternal'],
            SoftDeleteBehavior::EVENT_AFTER_RESTORE => [$this, 'afterRestoreInternal'],
            ActiveRecord::EVENT_AFTER_INSERT => [$this, 'afterInsertInternal'],
            ActiveRecord::EVENT_AFTER_UPDATE => [$this, 'afterUpdateInternal'],
        ];
    }

    /**
     * 软删除文章后（更新分类文章数)
     */
    public function afterSoftDeleteInternal($event)
    {
        Category::updateAllCounters(['article' => -1], ['id' => $event->sender->category_id]);
    }
    /**
     * 软删除文章还原后（更新分类文章数)
     */
    public function afterRestoreInternal($event)
    {
        Category::updateAllCounters(['article' => 1], ['id' => $event->sender->category_id]);
    }
    /**
     * 发布新文章后（更新分类文章数)
     */
    public function afterInsertInternal($event)
    {
        Category::updateAllCounters(['article' => 1], ['id' => $event->sender->category_id]);
    }
    /**
     * 修改文章后（如果修改了分类,更新分类文章数)
     */
    public function afterUpdateInternal($event) {
        $changedAttributes = $event->changedAttributes;
        if (isset($changedAttributes['category_id'])) {
            Category::updateAllCounters(['article' => 1], ['id' => $event->sender->category_id]);
            Category::updateAllCounters(['article' => -1], ['id' => $changedAttributes['category_id']]);
        }
    }
}