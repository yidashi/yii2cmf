<?php
namespace backend\assets;

use yii\base\Exception;
use yii\web\AssetBundle;

class IframeAsset extends AssetBundle
{
    public $sourcePath = '@backend/static';

    public $css = [
        'css/AdminLTE.min.css',
        'css/iframe.css'
    ];
    public $js = [
        'js/app.js',
        'plugins/slimScroll/jquery.slimscroll.min.js',
        'js/iframe.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'common\assets\FontAwesomeAsset',
    ];

    /**
     * @var string|bool Choose skin color, eg. `'skin-blue'` or set `false` to disable skin loading
     * @see https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html#layout
     */
    public $skin = '_all-skins';

    /**
     * @inheritdoc
     */
    public function init()
    {
        // Append skin color file if specified
        if ($this->skin) {
            if (('_all-skins' !== $this->skin) && (strpos($this->skin, 'skin-') !== 0)) {
                throw new Exception('Invalid skin specified');
            }

            $this->css[] = sprintf('css/skins/%s.min.css', $this->skin);
        }

        parent::init();
    }
}
