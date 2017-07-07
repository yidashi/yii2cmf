<?php
namespace backend\widgets\nestedsortable;

use backend\widgets\nestedsortable\assets\NestedSortableAsset;


class NestedSortable extends \yii\base\Widget
{

    public function init()
    {
        $view = $this->getView();
        NestedSortableAsset::register($view);
        $view->registerJs("$('#" . $this->getId() . "').nestedSortable({
		        forcePlaceholderSize: true,
				handle: 'div',
				helper:	'clone',
				items: 'li',
				opacity: .6,
				placeholder: 'placeholder',
				revert: 250,
				tabSize: 25,
				tolerance: 'pointer',
				toleranceElement: '> div',
				maxLevels: 4,
				isTree: true,
				expandOnHover: 700,
				startCollapsed: false
        });");
        echo '<ol class="sortable" id="' . $this->getId() . '">';
    }

    public function run()
    {
        echo '</ol>';
    }
}
