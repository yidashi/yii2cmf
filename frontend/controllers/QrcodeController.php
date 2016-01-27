<?php
/**
 * author: yidashi
 * Date: 2015/12/18
 * Time: 10:31.
 */
namespace frontend\controllers;

use yii\web\Controller;

class QrcodeController extends Controller
{
    public function actionIndex($text, $size = 5, $logo = false)
    {
        $tmpFileName = '/tmp/qrcode.png';
        \PHPQRCode\QRcode::png($text, $tmpFileName, 'L', $size, 2);
        $QR = imagecreatefromstring(file_get_contents($tmpFileName));
        if ($logo !== false) {
            $logo = imagecreatefromstring(file_get_contents($logo));
            $QR_width = imagesx($QR);//二维码图片宽度
            $QR_height = imagesy($QR);//二维码图片高度
            $logo_width = imagesx($logo);//logo图片宽度
            $logo_height = imagesy($logo);//logo图片高度
            $logo_qr_width = $QR_width / 5;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;
            $from_width = ($QR_width - $logo_qr_width) / 2;
            //重新组合图片并调整大小
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
                $logo_qr_height, $logo_width, $logo_height);
        }
        header('Content-type:image/png');
        echo imagepng($QR);
        die;
    }
}
