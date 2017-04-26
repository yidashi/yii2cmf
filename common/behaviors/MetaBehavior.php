<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/21
 * Time: 上午12:35
 */

namespace common\behaviors;


use common\models\Meta;
use common\traits\EntityTrait;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class MetaBehavior extends Behavior
{
    use EntityTrait;
    
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
        if (\Yii::$app->request->isConsoleRequest ) {
            return;
        }
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
                'entity' => $this->getEntity(),
                'entity_id' => $this->getEntityId()
            ]);
        }
        return $model;
    }
    public function getMeta()
    {
        return $this->owner->hasOne(Meta::className(), [
            'entity_id' => $this->owner->primaryKey()[0]
        ])->where([
            "entity" => $this->getEntity()
        ]);
    }

}