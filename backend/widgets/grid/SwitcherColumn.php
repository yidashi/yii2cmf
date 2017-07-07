<?php
namespace backend\widgets\grid;

use backend\assets\SwitcherAsset;
use yii\grid\DataColumn;
use yii\helpers\Html;
use common\enums\StatusEnum;
use yii\helpers\Url;

class SwitcherColumn extends  DataColumn
{

    public $reload = 0;

    public $route = ['switcher'];

    public function registerClientScript()
    {
        SwitcherAsset::register($this->grid->view);
        $js = <<<'EOT'
		    $('.js-switch').on('change', function(){
		        var switchery =  $(this).data("switchery");
		        switchery.disable();
		        var url =  $(this).data("url");
		        var reload =  $(this).data("reload");
		        var checked =  $(this).is(':checked') ? '1' : '0';
		        var data = $(this).data("params");
		        data.value = checked;
		        $.post( url, data, function(response){
		            if(response.status == false){
		                $.modal.error(response.msg);
		                return;
		            }

		            if(reload){
		                location.reload();
		            }else{
		            	$.modal.success(response.msg);
		            	switchery.enable();
		            }
		        });
		    });
EOT;
        $this->grid->view->registerJs($js,\yii\web\View::POS_READY); //因为可能会被pjax加载所以放在这里
    }
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $params = is_array($key) ? $key : ['id' => (string) $key];
        $params["attribute"] = $this->attribute;

        $value = $this->getDataCellValue($model, $key, $index) ;


        if(is_string($value)) {
            $result =  $value;
        } else {
            $this->registerClientScript();
            $result =  Html::checkbox('', $value == StatusEnum::STATUS_ON, [
                'class' => 'js-switch',
                'data-url' => Url::to($this->route),
                'data-params' => $params,
                'data-reload' => $this->reload,
                'data-toggle' => 'switcher'
            ]);
        }


        return $result;
    }
}
