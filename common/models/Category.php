<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $created_at
 * @property integer $updated_at
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title')
        ];
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function lists()
    {
        $list = Yii::$app->cache->get('categoryList');
        if($list === false){
            $list = static::find()->select('id,title')->asArray()->all();
            $list = ArrayHelper::map($list, 'id', 'title');
            Yii::$app->cache->set('categoryList', $list);
        }
        return $list;
    }

    public function getCategoryNameById($id)
    {
        $list= $this->lists();
        return isset($list[$id]) ? $list[$id] : null;
    }

    public function getCategoryIdByName($name)
    {
        $list= $this->lists();
        return array_search($name, $list);
    }
}
