<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/22
 * Time: 下午9:07
 */

namespace common\models\behaviors;


use common\models\ArticleTag;
use common\models\Favourite;
use common\models\Tag;
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
            SoftDeleteBehavior::EVENT_AFTER_REDUCTION => [$this, 'afterReductionInternal'],
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
        if ($content) {
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
    public function afterReductionInternal($event)
    {
        Category::updateAllCounters(['article' => 1], ['id' => $event->sender->category_id]);
    }
    /**
     * 发布新文章后（更新分类文章数)
     */
    public function afterInsertInternal($event)
    {
        Category::updateAllCounters(['article' => 1], ['id' => $event->sender->category_id]);
        $this->setTagNames($event->sender);
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
        $this->setTagNames($event->sender);
    }
    public function setTagNames($model)
    {
        $data = \Yii::$app->request->post($model->formName());
        // 更新原标签文章数
        $oldTags = explode(' ', $model->getTagNames());
        Tag::updateAllCounters(['article' => -1], ['name' => $oldTags]);
        // 先清除文章所有标签
        ArticleTag::deleteAll(['article_id' => $model->id]);
        if (isset($data['tagNames']) && !empty($data['tagNames'])) {
            $tags = explode(' ', $data['tagNames']);
            foreach($tags as $tag) {
                $tagModel = Tag::findOne(['name' => $tag]);
                if (empty($tagModel)) {
                    $tagModel = new Tag();
                    $tagModel->name = $tag;
                    $tagModel->save();
                }
                $articleTag = new ArticleTag();
                $articleTag->article_id = $model->id;
                $articleTag->tag_id = $tagModel->id;
                $articleTag->save();
            }
            Tag::updateAllCounters(['article' => 1], ['name' => $tags]);
        }
    }
}