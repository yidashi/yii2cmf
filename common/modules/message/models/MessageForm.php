<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/8/7
 * Time: 下午10:32
 */

namespace common\modules\message\models;


use common\modules\user\models\User;
use yii\base\Model;

class MessageForm extends Model
{
    public $toUid;
    public $toUsername;
    public $content;

    public function rules()
    {
        return [
            [['toUsername', 'content'], 'required'],
            [['toUsername', 'content'], 'string'],
            ['toUsername', 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'username', 'message' => '收信人不存在'],
            ['toUid', 'default', 'value' => function($model, $attribute){
                $user = User::findByUsernameOrEmail($model->toUsername);
                return is_null($user) ? null : $user->id;
            }],
            ['toUid', 'compare', 'operator' => '!=', 'compareValue' => \Yii::$app->user->id, 'message' => '自己不能给自己发私信']
        ];
    }

    public function attributeLabels()
    {
        return [
            'toUsername' => '收信人',
            'content' => '内容'
        ];
    }

    public function send()
    {
        if ($this->validate()) {
            $messageDataModel = new MessageData();
            $messageDataModel->content = $this->content;
            $messageDataModel->save();
            $messageModel = new Message();
            $messageModel->from_uid = \Yii::$app->user->id;
            $messageModel->to_uid = $this->toUid;
            $messageModel->message_id = $messageDataModel->id;
            $messageModel->save();
            return true;
        }
        return false;
    }
}