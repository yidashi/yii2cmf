<?php
/**
 * AssetBundleTest.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\fontawesome\tests\unit\fontawesome;

use rmrevin\yii\fontawesome\AssetBundle;

/**
 * Class AssetBundleTest
 * @package rmrevin\yii\fontawesome\tests\unit\fontawesome
 */
class AssetBundleTest extends \rmrevin\yii\fontawesome\tests\unit\TestCase
{

    public function testMain()
    {
        AssetBundle::register(\Yii::$app->getView());
    }
}