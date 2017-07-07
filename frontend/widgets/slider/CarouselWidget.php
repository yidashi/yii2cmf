<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/21
 * Time: 下午11:58
 */

namespace frontend\widgets\slider;


use common\helpers\Util;
use common\models\Carousel as CarouselModel;
use common\models\CarouselItem;
use yii\base\InvalidConfigException;
use yii\bootstrap\Carousel;
use yii\helpers\Html;

class CarouselWidget extends Carousel
{
    /**
     * @var
     */
    public $key;

    /**
     * @var array
     */
    public $controls = [
        '<span class="glyphicon glyphicon-chevron-left"></span>',
        '<span class="glyphicon glyphicon-chevron-right"></span>',
    ];

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!$this->key) {
            throw new InvalidConfigException;
        }
        $cacheKey = [
            CarouselModel::className(),
            $this->key
        ];
        $items = \Yii::$app->cache->get($cacheKey);
        if ($items === false) {
            $items = [];
            $query = CarouselItem::find()
                ->joinWith('carousel')
                ->where([
                    '{{%carousel_item}}.status' => 1,
                    '{{%carousel}}.status' => CarouselModel::STATUS_ACTIVE,
                    '{{%carousel}}.key' => $this->key,
                ])
                ->orderBy(['order' => SORT_ASC]);
            foreach ($query->all() as $k => $item) {
                /** @var $item \common\models\CarouselItem */
                $items[$k]['content'] = Html::img($item->image);
                if ($item->url) {
                    $items[$k]['content'] = Html::a($items[$k]['content'], Util::parseUrl($item->url), ['target'=>'_blank']);
                }

                if ($item->caption) {
                    $items[$k]['caption'] = $item->caption;
                }
            }
            \Yii::$app->cache->set($cacheKey, $items, 60*60*24*365);
        }
        $this->items = $items;
        parent::init();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        if (!empty($this->items)) {
            $content = '';
            $this->registerPlugin('carousel');
            $content = implode("\n", [
                $this->renderIndicators(),
                $this->renderItems(),
                $this->renderControls()
            ]);
            return Html::tag('div', $content, $this->options);
        }
    }
}
