<?php

namespace frontend\widgets\slider;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\models\CarouselItem;
use yii\base\InvalidConfigException;
use common\models\Carousel as CarouselModel;

class Revolutionslider extends \yii\base\Widget{

    public $key;

    public $options=[];

    public $items = [];

    public $itemOptions = [];
    
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
            $items = $query->asArray()->all();
            \Yii::$app->cache->set($cacheKey, $items, 60*60*24*365);
        }
        $this->items = $items;
        $this->itemOptions = [
            'data-transition'=>"papercut",
            'data-slotamount'=>"7"
        ];
        parent::init();

    }
        
    public function run()
    {
        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'ul');
        if ($tag !== false) {
            echo Html::tag($tag, $this->renderItems(), $options);
        } else {
            echo $this->renderItems();
        }
    }
    
    public function renderItems()
    {
        $options = $this->itemOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'li');
        
        $lines = [];
        
        $items = $this->items;
  
        if(!empty($items))
        {
            RevolutionsliderAsset::register($this->view);
        }
        
        foreach ($items as $item)
        {
            $menu = $this->renderItem($item);
            if ($tag === false) {
                $lines[] = $menu;
            } else {
                $lines[] = Html::tag($tag, $menu, $options);
            }
        }
        
        return implode("\n", $lines);
    }
    
    
    protected function renderItem($item)
    {
        $result = "";
        
        if (($url = $item['image'])) {
            $result .= Html::img($url);
        }
//        foreach ($item->captions as $caption) {
            $result .= Html::tag('div',$item['caption'],[
                'class'=>"tp-caption ".'align-center',
                'data-x'=>0,
                "data-y"=>145,
                "data-speed"=>400,
                "data-start"=>1900,
                'data-easing'=>'easeOutExpo'
            ]);
//        }
        return $result;
    }
}