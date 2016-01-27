<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/1/20
 * Time: 下午8:51.
 */
namespace common\logic;

use yii\behaviors\BlameableBehavior;

class Article extends \common\models\Article
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                [
                    'class' => BlameableBehavior::className(),
                    'createdByAttribute' => 'user_id',
                    'updatedByAttribute' => false,
                ],
            ]
        );
    }
}
