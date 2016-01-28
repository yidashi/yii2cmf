<?php
/**
 * author: yidashi
 * Date: 2015/11/27
 * Time: 13:37.
 */
namespace console\models;

use yii\web\NotFoundHttpException;

class SpiderFactory
{
    public static function create($name)
    {
        $className = '\console\models\spider\\'.ucfirst(strtolower($name));
        if (!class_exists($className)) {
            throw new NotFoundHttpException($className.' Class not found');
        }
        $spider = new $className();

        return $spider;
    }
}
