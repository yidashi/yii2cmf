<?php
namespace common\modules\area\widgets;

use common\modules\area\models\Area;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;


class AreaWidget extends Widget
{

    public $slug;

    public $headerClass ="";

    public $bodyClass ="";

    public $blockClass = "";

    public function init()
    {
        parent::init();
        if (empty($this->slug)) {
            throw new InvalidConfigException("slug不能为空");
        }
        $this->blockClass = $this->blockClass ." block";
        $this->headerClass = $this->headerClass . " block-header";
        $this->bodyClass = $this->bodyClass ." block-body";
    }

    public function run()
    {
        $model = Area::findByIdOrSlug($this->slug);
        if ($model == null) {
            return '';
        }
        $blocks = $model->getBlocks();
        $result = "";
        foreach ($blocks as $block) {
            $widget = $block["widget"];

            $header = Html::tag("h3", $block->title);

            $content = Html::tag("div", $header, [
                "class" => $this->headerClass
            ]);

            $body = $widget::widget([
                "model" => $block
            ]);

            $content .= Html::tag("div", $body, [
                "class" => $this->bodyClass
            ]);

            $result .= Html::tag("div", $content, [
                "class" => $this->blockClass
            ]);
        }

        return $result;
    }
}