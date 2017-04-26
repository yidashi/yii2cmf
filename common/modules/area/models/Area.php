<?php

namespace common\modules\area\models;

use Yii;

/**
 * This is the model class for table "{{%area}}".
 *
 * @property integer $area_id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $blocks
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%area}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'slug', 'description'], 'required'],
            [['title', 'slug', 'description'], 'string'],
            ["blocks", "safe"]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'area_id' => 'ID',
            'title' => '区域名',
            'slug' => '标识',
            'description' => '区域说明',
            'blocks' => '区块',
        ];
    }


    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert) == false) {
            return false;
        }
        $this->blocks = serialize($this->blocks);
        return true;

    }

    public function afterFind()
    {
        parent::afterFind();
        $this->blocks = unserialize($this->blocks);
    }

    public function getBlocks() {
        if(!empty($this->blocks)) {
            $query =   Block::find()->where(['block_id' => $this->blocks])->orderBy([new \yii\db\Expression('FIELD (block_id, ' . implode(', ', $this->blocks) . ')')]);
            return $query->all();
        }
        return [];
    }

    public static function findByIdOrSlug($id)
    {
        if (intval($id) == 0) {
            $condition = ["slug" => $id];
        } else {
            $condition = [
                $id
            ];
        }

        return static::findOne($condition);
    }

}
