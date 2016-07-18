<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16-1-25
 * Time: 下午5:59
 */

namespace backend\controllers;


use yii\web\Controller;

class ConsoleController extends Controller
{
    private function cmd($cmd, $output = '')
    {
        $handler = popen($cmd, 'r');

        while(!feof($handler))
            $output .= fgets($handler);

        $output = trim($output);
        $status = pclose($handler);
        return $status;
    }
}