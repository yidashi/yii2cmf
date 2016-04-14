<?php
/**
 * author: yidashi
 * Date: 2015/12/9
 * Time: 10:11
 */

namespace yidashi\webuploader;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\InputWidget;

class Webuploader extends InputWidget{
    //默认配置
    protected $_options;
    public $server;
    public function init()
    {
        parent::init();
        \Yii::setAlias('@webuploader', __DIR__);
        // 初始化@static别名,默认@web/static,最好根据自己的需求提前设置好@static别名
        $static = \Yii::getAlias('@static', false);
        if (!$static) {
            \Yii::setAlias('@static', '@web/static');
        }
        $this->options['boxId'] = isset($this->options['boxId']) ? $this->options['boxId'] : 'picker';
        $this->options['innerHTML'] = isset($this->options['innerHTML']) ? $this->options['innerHTML'] : '<button class="btn btn-primary">选择文件</button>';
        $this->options['previewWidth'] = isset($this->options['previewWidth']) ? $this->options['previewWidth'] : '250';
        $this->options['previewHeight'] = isset($this->options['previewHeight']) ? $this->options['previewHeight'] : '150';
    }
    public function run()
    {
        $this->registerClientJs();
        $value = Html::getAttributeValue($this->model, $this->attribute);
        $content = $value ?
            Html::img(
                strpos($value, 'http:') === false ? (\Yii::getAlias('@static') . '/' . $value) : $value,
                ['width'=>$this->options['previewWidth'],'height'=>$this->options['previewHeight']]
            ) :
            $this->options['innerHTML'];
        if($this->hasModel()){
            return Html::tag('div', $content, ['id'=>$this->options['boxId']]) . Html::activeHiddenInput($this->model, $this->attribute);
        }else{
            return Html::tag('div', $content, ['id'=>$this->options['boxId']]) . Html::hiddenInput($this->name, $this->value);
        }
    }

    /**
     * 注册js
     */
    private function registerClientJs()
    {
        WebuploaderAsset::register($this->view);
        $web = \Yii::getAlias('@static');
        $server = $this->server ?: Url::to(['/site/webupload']);
        $swfPath = \Yii::getAlias('@webuploader/assets');
        $this->view->registerJs(<<<JS
var uploader = WebUploader.create({
        auto: true,
        fileVal: 'webUploaderFile',
        // swf文件路径
        swf: '{$swfPath}/Uploader.swf',

        // 文件接收服务端。gy
        server: '{$server}',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#{$this->options['boxId']}',

        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        },

        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        resize: false
    });
uploader.on( 'uploadProgress', function( file, percentage ) {
    var li = $( '#'+file.id ),
        percent = li.find('.progress .progress-bar');

    // 避免重复创建
    if ( !percent.length ) {
        percent = $('<div class="progress progress-striped active">' +
          '<div class="progress-bar" role="progressbar" style="width: 0%">' +
          '</div>' +
        '</div>').appendTo( li ).find('.progress-bar');
    }

    li.find('p.state').text('上传中 '+ (percentage * 100).toFixed(1) + '%');

    percent.css( 'width', percentage * 100 + '%' );
});
// 完成上传完了，成功或者失败，先删除进度条。
uploader.on( 'uploadSuccess', function( file, data ) {
    $( '#'+file.id ).find('p.state').text('上传成功').fadeOut();
    $( '#{$this->options['boxId']} .webuploader-pick' ).html('<img src="{$web}'+data.url+'" width="{$this->options['previewWidth']}" height="{$this->options['previewHeight']}"/>');
    $( '#{$this->options['id']}' ).val("{$web}" + data.url);
    $( '#{$this->options['boxId']} .webuploader-pick' ).siblings('div').width("{$this->options['previewWidth']}").height("{$this->options['previewHeight']}");
});
JS
        );
    }
} 