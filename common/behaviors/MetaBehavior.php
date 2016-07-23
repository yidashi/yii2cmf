<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/21
 * Time: 上午12:35
 */

namespace common\behaviors;


use common\models\Meta;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use Yii;

class MetaBehavior extends Behavior
{
    public $type;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];
    }

    public function afterSave()
    {
        $model = $this->getMetaModel();
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
        }
    }

    public function afterDelete()
    {
        $this->getMetaModel()->delete();
    }

    public function getMetaModel()
    {
        $model = $this->owner->meta;
        if ($model == null) {
            $model = new Meta([
                'type' => $this->getType(),
                'type_id' => $this->owner->getPrimaryKey()
            ]);
        }
        return $model;
    }
    public function getMeta()
    {
        return $this->owner->hasOne(Meta::className(), [
            'type_id' => $this->owner->primaryKey()[0]
        ])->where([
            "type" => $this->getType()
        ]);
    }

    public function getType()
    {
        if ($this->type == null) {
            $this->type = $this->owner->className();
        }

        return ltrim($this->type,"\\");
    }

}