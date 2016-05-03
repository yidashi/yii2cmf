<?php
/**
 * author: yidashi
 * Date: 2015/12/9
 * Time: 10:11
 */

namespace yidashi\webuploader;

use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\InputWidget;

class Webuploader extends InputWidget{
    //默认配置
    protected $_options;
    public $server;
    public $domain;
    public $driver;
    public function init()
    {
        parent::init();
        \Yii::setAlias('@webuploader', __DIR__);
        if (empty($this->driver)) {
            $this->driver = isset(\Yii::$app->params['webuploader_driver']) ? \Yii::$app->params['webuploader_driver'] : 'local';
        }
        if ($this->driver == 'local') {
            // 初始化@static别名,默认@web/static,最好根据自己的需求提前设置好@static别名
            $static = \Yii::getAlias('@static', false);
            if (!$static) {
                \Yii::setAlias('@static', '@web/static');
            }
        } else if ($this->driver == 'qiniu') {
            if (empty($this->domain)) {
                $this->domain = \Yii::$app->params['qiniu']['domain'];
            }
            if (empty($this->domain)) {
                throw new Exception('七牛上传方式必须设置根域名');
            }
        }
        $this->options['boxId'] = isset($this->options['boxId']) ? $this->options['boxId'] : 'picker';
        $this->options['innerHTML'] = isset($this->options['innerHTML']) ? $this->options['innerHTML'] : '<button class="btn btn-primary">选择文件</button>';
        $this->options['innerHTML'] .= '<div id="webuploaderList" class="uploader-list"></div>';
        $this->options['previewWidth'] = isset($this->options['previewWidth']) ? $this->options['previewWidth'] : '250';
        $this->options['previewHeight'] = isset($this->options['previewHeight']) ? $this->options['previewHeight'] : '150';
    }
    public function run()
    {
        call_user_func([$this, 'register' . ucfirst($this->driver) . 'ClientJs']);
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
    private function registerLocalClientJs()
    {
        WebuploaderAsset::register($this->view);
        $web = \Yii::getAlias('@static');
        $server = $this->server ?: Url::to(['/site/webupload']);
        $swfPath = \Yii::getAlias('@webuploader/assets');
        $this->view->registerJs(<<<JS
var uploader = WebUploader.create({
        auto: true,
        fileVal: 'file',
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
// 文件上传过程中创建进度条实时显示。
uploader.on( 'uploadProgress', function( file, percentage ) {
    var li = $( '#webuploaderList'),
        percent = li.find('.progress .progress-bar');

    // 避免重复创建
    if ( !percent.length ) {
        percent = $('<div class="progress"><div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"></div></div>')
                .appendTo( li )
                .find('.progress-bar');
    }

    percent.css( 'width', percentage * 100 + '%' );
});
// 完成上传完了，成功或者失败，先删除进度条。
uploader.on( 'uploadSuccess', function( file, data ) {
    $( '#'+file.id ).find('p.state').text('上传成功').fadeOut();
    $( '#{$this->options['boxId']} .webuploader-pick' ).html('<img src="{$web}/'+data.url+'" width="{$this->options['previewWidth']}" height="{$this->options['previewHeight']}"/>');
    $( '#{$this->options['id']}' ).val(data.url);
    $( '#{$this->options['boxId']} .webuploader-pick' ).siblings('div').width("{$this->options['previewWidth']}").height("{$this->options['previewHeight']}");
});
JS
        );
    }

    /**
     * 注册js
     */
    private function registerQiniuClientJs()
    {
        WebuploaderAsset::register($this->view);
        $tokenUrl = $this->server ?: Url::to(['/site/webupload']);
        $swfPath = \Yii::getAlias('@webuploader/assets');
        $this->view->registerJs(<<<JS
$.get("{$tokenUrl}",function(res) {
    var uploader = WebUploader.create({
        auto: true,
        fileVal: 'file',
        chunked :false,
        // swf文件路径
        swf: '{$swfPath}/Uploader.swf',

        // 文件接收服务端。gy
        server: 'http://upload.qiniu.com/',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#{$this->options['boxId']}',

        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        },

        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        resize: false,

        formData: {
            token: res.uptoken
        }
    });
// 文件上传过程中创建进度条实时显示。
uploader.on( 'uploadProgress', function( file, percentage ) {
    var li = $( '#webuploaderList'),
        percent = li.find('.progress .progress-bar');

    // 避免重复创建
    if ( !percent.length ) {
        percent = $('<div class="progress"><div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"></div></div>')
                .appendTo( li )
                .find('.progress-bar');
    }

    percent.css( 'width', percentage * 100 + '%' );
});
    // 完成上传完了，成功或者失败，先删除进度条。
    uploader.on( 'uploadSuccess', function( file, data ) {
        var url = data.key;
        $( '#'+file.id ).find('p.state').text('上传成功').fadeOut();
        $( '#{$this->options['boxId']} .webuploader-pick' ).html('<img src="{$this->domain}'+url+'" width="{$this->options['previewWidth']}" height="{$this->options['previewHeight']}"/>');
        $( '#{$this->options['id']}' ).val(url);
        $( '#{$this->options['boxId']} .webuploader-pick' ).siblings('div').width("{$this->options['previewWidth']}").height("{$this->options['previewHeight']}");
    });
}, 'json');

JS
        );
    }
} 