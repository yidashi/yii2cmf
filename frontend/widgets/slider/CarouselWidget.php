<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/21
 * Time: 下午11:58
 */

namespace frontend\widgets\slider;

use common\helpers\Util;
use common\services\CarouselService;
use yii\base\InvalidConfigException;
use yii\bootstrap\Carousel;
use yii\helpers\Html;

class CarouselWidget extends Carousel
{
    protected $carouselService;

    public function __construct(CarouselService $carouselService, $config = [])
    {
        $this->carouselService = $carouselService;
        parent::__construct($config);
    }

    /**
     * @var
     */
    public $key;

    public $cacheDuration = 3600;

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

        $items = [];
        foreach ($this->carouselService->findByKey($this->key, $this->cacheDuration) as $k => $item) {
            /** @var $item \common\models\CarouselItem */
            $items[$k]['content'] = Html::img($item['image']);
            if ($item['url']) {
                $items[$k]['content'] = Html::a($items[$k]['content'], Util::parseUrl($item['url']), ['target' => '_blank']);
            }

            if ($item['caption']) {
                $items[$k]['caption'] = $item['caption'];
            }
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
            $this->registerPlugin('carousel');
            $content = implode("\n", [
                $this->renderIndicators(),
                $this->renderItems(),
                $this->renderControls()
            ]);
            return Html::tag('div', $content, $this->options);
        }
        return '';
    }
}
