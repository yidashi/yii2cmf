<?php
namespace common\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\models\Tag;
use common\models\TagIndex;

class TagBehavior extends Behavior
{
    private $_tags;

    public static $formName = "tagItems";

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    public function getTagIndex()
    {
        return $this->owner->hasMany(TagIndex::className(), ['entity_id' => $this->owner->primaryKey()[0]])->where(['entity' => $this->getEntityClass()]);
    }

    public function getTags()
    {
        return $this->owner->hasMany(Tag::className(), ['tag_id' => 'tag_id'])->via('tagIndex');
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

    public function afterSave()
    {
        if(!$this->owner->isNewRecord) {
            $this->beforeDelete();
        }

        $data = \Yii::$app->request->post($this->owner->formName());
        
        if(isset($data[static::$formName]) && !empty($data[static::$formName])) {
            $tags = $data[static::$formName];
            $tagIndexs = [];
            
            foreach ($tags as $name) {
                if (!($tag = Tag::findOne(['name' => $name]))) {
                    $tag = new Tag(['name' => $name]);
                }
                $tag->frequency++;
                if ($tag->save()) {
                    $updatedTags[] = $tag;
                    $tagIndexs[] = [$this->getEntityClass(), $this->getEntityId(), $tag->tag_id];
                }
            }

            if(count($tagIndexs)) {
                \Yii::$app->db->createCommand()->batchInsert(TagIndex::tableName(), ['entity', 'entity_id', 'tag_id'], $tagIndexs)->execute();
                $this->owner->populateRelation('tags', $updatedTags);
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
            Tag::updateAllCounters(['frequency' => -1], ['in', 'tag_id', $pks]);
        }
        Tag::deleteAll(['frequency' => 0]);
        TagIndex::deleteAll(['entity' => $this->getEntityClass(), 'entity_id' => $this->getEntityId()]);
    }


}

?>