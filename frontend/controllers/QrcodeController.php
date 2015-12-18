<?php
/**
 * author: yidashi
 * Date: 2015/12/18
 * Time: 10:31
 */

namespace frontend\controllers;


use yii\web\Controller;

class QrcodeController extends Controller{
    public function actionIndex($text,$size)
    {
        $QR = \PHPQRCode\QRcode::png($text, false, 'L', $size, 2);
        echo $QR;die;
    }
} 