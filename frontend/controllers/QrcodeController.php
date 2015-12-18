<?php
/**
 * author: yidashi
 * Date: 2015/12/18
 * Time: 10:31
 */

namespace frontend\controllers;


use yii\web\Controller;

class QrcodeController extends Controller{
    public function actionIndex($text)
    {
        $QR = \PHPQRCode\QRcode::png($text, false, 'L', 5, 2);
        echo $QR;DIE;
    }
} 