<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/4/14
 * Time: 下午10:49
 */

namespace api\modules\v1\controllers;


use api\common\controllers\Controller;
use api\modules\v1\models\Article;
use common\models\Carousel;
use common\models\CarouselItem;
use yii\data\ActiveDataProvider;

class SiteController extends Controller
{
    public function actionIndex()
    {
        $query = CarouselItem::find()
            ->joinWith('carousel')
            ->where([
                '{{%carousel_item}}.status' => 1,
                '{{%carousel}}.status' => Carousel::STATUS_ACTIVE,
                '{{%carousel}}.key' => 'index',
            ])
            ->orderBy(['order' => SORT_ASC]);
        $carousels = [];
        foreach ($query->all() as $k => $item) {
            $carousels[$k]['title'] = $item->caption;
            $carousels[$k]['image'] = $item->image->url;
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Article::find()->published(),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        return [
            'carousels' => $carousels,
            'articleList' => $this->serializeData($dataProvider)
        ];
    }
}