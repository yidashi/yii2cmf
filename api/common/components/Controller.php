<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/3/2
 * Time: 下午2:07
 */

namespace api\common\components;

use api\common\behaviors\ValidateBehavior;
use yii\filters\auth\HttpHeaderAuth;
use yii\filters\Cors;

class Controller extends \yii\rest\Controller
{
    /**
     * 配置让dataProvider返回items
     * @var array
     */
    public $serializer = [
        'class' => 'api\common\components\Serializer',
    ];

    public function behaviors()
    {
        $behaviors = [];
        $behaviors['cors'] = [
            'class' => Cors::className(),
        ];
        $behaviors['validate'] = ValidateBehavior::className();
        $behaviors = array_merge($behaviors, parent::behaviors());
        unset($behaviors['contentNegotiator']);
        $behaviors['authenticator']['authMethods'] = [
            [
                'class' => HttpHeaderAuth::className(),
                'header' => 'access-token',
            ]
        ];
        $behaviors['authenticator']['optional'] = $this->authOptional();

        return $behaviors;
    }

    protected function authOptional()
    {
        return [];
    }
}