<?php
/**
 * CDNAssetBundle.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\fontawesome;

/**
 * Class CDNAssetBundle
 * @package rmrevin\yii\fontawesome
 * @deprecated
 */
class CDNAssetBundle extends \rmrevin\yii\fontawesome\cdn\AssetBundle
{

    public function init()
    {
        parent::init();

        \Yii::warning(sprintf('You are using an deprecated class `%s`.', __CLASS__));
    }
}