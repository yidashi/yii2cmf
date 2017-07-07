<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/24
 * Time: 下午1:26
 */

namespace common\behaviors;


use common\models\ArticleTag;
use common\models\Tag;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class TagBehavior extends Behavior
{
    private $_tags;

    public static $formName = "tagItems";

    public static $formLable = '标签';

    public function events()
    {
        return [
            ActiveRecord::EVENT_INIT => 'initInternal',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    public function initInternal($event)
    {

    }
    public function getTags()
    {
        return $this->owner->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('{{%article_tag}}', ['article_id' => 'id']);
    }

    public function getTagItems()
    {
        if($this->_tags === null){
            $this->_tags = [];
            foreach($this->owner->tags as $tag) {
                $this->_tags[] = $tag->name;
            }
        }
        return $this->_tags;
    }

    public function getTagNames()
    {
        return join(' ', $this->getTagItems());
    }

    public function afterSave()
    {
        if (\Yii::$app->request->isConsoleRequest ) {
            return;
        }
        $data = \Yii::$app->request->post($this->owner->formName());
        if(isset($data[static::$formName])) {
            if(!$this->owner->isNewRecord) {
                $this->beforeDelete();
            }
            if (!empty($data[static::$formName])) {
                $tags = $data[static::$formName];
                foreach ($tags as $tag) {
                    $tagModel = Tag::findOne(['name' => $tag]);
                    if (empty($tagModel)) {
                        $tagModel = new Tag();
                        $tagModel->name = $tag;
                        $tagModel->save();
                    }
                    $articleTag = new ArticleTag();
                    $articleTag->article_id = $this->owner->id;
                    $articleTag->tag_id = $tagModel->id;
                    $articleTag->save();
                }
                Tag::updateAllCounters(['article' => 1], ['name' => $tags]);
            }
        }
    }

    public function beforeDelete()
    {
        $pks = [];

        foreach($this->owner->tags as $tag){
            $pks[] = $tag->primaryKey;
        }

        if (count($pks)) {
            Tag::updateAllCounters(['article' => -1], ['in', 'id', $pks]);
        }
        Tag::deleteAll(['article' => 0]);
        ArticleTag::deleteAll(['article_id' => $this->owner->id]);
    }
}