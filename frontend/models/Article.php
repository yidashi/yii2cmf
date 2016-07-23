<?php

namespace frontend\models;

use common\models\ArticleExhibition;
use common\models\Category;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 * @property string $cover
 */
class Article extends \common\models\Article
{
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['status', 'default', 'value' => \Yii::$app->config->get('FRONTEND_PUB_CHECK', self::STATUS_ACTIVE)];
        return $rules;
    }

    public static function hots($categoryId, $size = 10)
    {
        return self::find()
            ->where(['category_id' => $categoryId])
            ->normal()
            ->limit($size)
            ->orderBy('view desc')
            ->all();
    }
    public function getSameCityExhibition()
    {
//        $ip = Yii::$app->request->userIP;
//        $url = "http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
//        $data = json_decode(file_get_contents($url), true);
//        $city = isset($data['city']) ? $data['city'] : '北京';
        $city = '北京';
        return $this->hasOne(ArticleExhibition::className(), ['id' => 'id'])->where(['city' => $city]);
    }
}
