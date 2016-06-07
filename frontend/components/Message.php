<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/7
 * Time: 上午10:10
 */

namespace frontend\components;



use yii\base\Object;
use yii\data\ActiveDataProvider;

class Message extends Object
{

    /**
     * @var \common\models\Message
     */
    public $messager;
    /**
     * @var
     */
    public $user;
    /**
     * @var array
     */
    private $_errors;

    public function init()
    {
        $this->messager = new \common\models\Message();
        $this->user = \Yii::$app->user;
    }

    public function setTo($uid)
    {
        $this->messager->to_uid = $uid;
        return $this;
    }

    public function setFrom($uid)
    {
        $this->messager->from_uid = $uid;
        return $this;
    }

    public function setTitle($title)
    {
        $this->messager->title = $title;
        return $this;
    }

    public function setContent($content)
    {
        $this->messager->content = $content;
        return $this;
    }

    public function setLink($link)
    {
        $this->messager->link = $link;
        return $this;
    }

    public function send()
    {
        if ($this->messager->save() === false) {
            $this->_errors = $this->messager->errors;
            return false;
        }
        return true;
    }

    public function getNoViewedNums()
    {
        return $this->messager->find()->where(['to_uid' => $this->user->id, 'is_viewed' => 0])->count();
    }

    public function getDataProvider()
    {
        return new ActiveDataProvider([
            'query' => $this->messager->find()->where(['to_uid' => $this->user->id]),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
    }

    public function setViewed()
    {
        return $this->messager->updateAll(['is_viewed' => 1], ['to_uid' => $this->user->id]);
    }

    public function getErrors()
    {
        return $this->_errors;
    }
}