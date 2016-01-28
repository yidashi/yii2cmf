<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%gather}}".
 *
 * @property int $id
 * @property string $name
 * @property string $category
 * @property string $url
 * @property string $url_org
 * @property string $res
 * @property string $result
 */
class Gather extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%gather}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'category', 'url', 'url_org', 'res', 'result'], 'required'],
            [['name', 'category', 'url', 'url_org', 'res', 'result'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'category' => Yii::t('app', 'Category'),
            'url' => Yii::t('app', 'Url'),
            'url_org' => Yii::t('app', 'Url Org'),
            'res' => Yii::t('app', 'Res'),
            'result' => Yii::t('app', 'Result'),
        ];
    }
}
