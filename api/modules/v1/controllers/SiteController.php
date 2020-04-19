<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2017/4/14
 * Time: 下午10:49
 */

namespace api\modules\v1\controllers;

use api\common\components\Controller;
use api\modules\v1\models\Document;
use common\models\Carousel;
use common\models\CarouselItem;
use common\services\CarouselService;
use yii\data\ActiveDataProvider;

class SiteController extends Controller
{
    protected function authOptional()
    {
        return ['*'];
    }

    protected $carouselService;

    public function __construct($id, $module, CarouselService $carouselService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->carouselService = $carouselService;
    }

    public function actionIndex()
    {
        $carouselItems = $this->carouselService->findByKey('index');
        $carousels = [];
        foreach ($carouselItems as $k => $item) {
            $carousels[$k]['title'] = $item['caption'];
            $carousels[$k]['image'] = $item['image'];
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Document::find()->published(),
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