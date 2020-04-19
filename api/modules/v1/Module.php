<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/2/25
 * Time: 下午2:24
 */

namespace api\modules\v1;


class Module extends \yii\base\Module
{
    public $defaultRoute = 'site';

    public function init()
    {
        parent::init();
        \Yii::$app->set('response', [
            'class' => 'yii\web\Response',
            'format' => 'json',
            'on afterSend' => function ($event) {
            },
            'on beforeSend' => function($event) {
                $response = $event->sender;
                if ($response->data !== null) {
                    if (!$response->isSuccessful) {
                        $result = $response->data;
                        if ($response->statusCode == 422) {
                            $response->data = [
                                'code' => $response->statusCode,
                                'msg' => $result[0]['message'],
                                'data' => null,
                            ];
                        } else {
                            $response->data = [
                                'code' => isset($result['status']) ? $result['status'] : $response->statusCode,
                                'msg' => $result['message'],
                                'data' => null,
                            ];
                        }
                        $response->statusCode = 200;
                    } else {
                        $result = $response->data;
                        $response->data = [
                            'code' => 0,
                            'msg' => 'ok',
                            'data' => $result,
                        ];

                    }
                }
            }
        ]);
    }
}