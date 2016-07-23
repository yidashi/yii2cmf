<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%area}}".
 *
 * @property integer $area_id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $blocks
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
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
            ["blocks","safe"]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'area_id' => Yii::t('backend', 'Area ID'),
            'title' => Yii::t('backend', 'Title'),
            'slug' => Yii::t('backend', 'Slug'),
            'description' => Yii::t('backend', 'Description'),
            'blocks' => Yii::t('backend', 'Blocks'),
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
        if(!empty($this->blocks))
        {
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
