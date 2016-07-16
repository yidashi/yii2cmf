<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/21
 * Time: 下午5:56
 */

namespace api\modules\v1\controllers;


use api\common\controllers\Controller;
use common\models\Category;

class NavController extends Controller
{
    public function actionIndex()
    {
        $cates = Category::find()->where(['is_nav' => 1])->all();
        return $cates;
    }
}