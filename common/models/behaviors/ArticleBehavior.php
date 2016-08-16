<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/22
 * Time: 下午9:07
 */

namespace common\models\behaviors;


use common\models\Favourite;
use common\models\Vote;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\behaviors\SoftDeleteBehavior;
use Yii;
use common\models\Category;

class ArticleBehavior extends Behavior
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
     * 删除文章后
     */
    public function afterDeleteInternal($event)
    {
        // 删除文章内容
        $content = $event->sender->data;
        if ($content != null) {
            $content->delete();
        }
        // 清除收藏和顶
        Vote::deleteAll(['type' => 'article', 'type_id' => $event->sender->id]);
        Favourite::deleteAll(['article_id' => $event->sender->id]);
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