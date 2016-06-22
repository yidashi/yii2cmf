<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/7
 * Time: 上午10:10
 */

namespace frontend\components\notify;



use yii\base\Object;
use yii\data\ActiveDataProvider;
use common\models\Notify;
use yii\db\Query;
use Yii;
use yii\helpers\Json;

class Handler extends Object
{
    /**
     * @var \common\models\Notify
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

    public function __construct(Notify $message, $config = [])
    {
        $this->messager = $message;
        $this->user = Yii::$app->user;
        parent::__construct($config);
    }

    public function category($name)
    {
        $category_id = (new Query())->from('{{%notify_category}}')->select('id')->where(['name' => $name])->scalar();
        $this->messager->category_id = $category_id;
        return $this;
    }

    public function from($uid)
    {
        $this->messager->from_uid = $uid;
        return $this;
    }

    public function to($uid)
    {
        $this->messager->to_uid = $uid;
        return $this;
    }

    public function link($link)
    {
        $this->messager->link = $link;
        return $this;
    }

    public function extra($extra)
    {
        $this->messager->extra = Json::encode($extra);
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

    public function getNoReadNums()
    {
        return $this->messager->find()->where(['to_uid' => $this->user->id, 'read' => 0])->count();
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

    public function readAll()
    {
        return $this->messager->updateAll(['read' => 1], ['to_uid' => $this->user->id]);
    }

    public function getErrors()
    {
        return $this->_errors;
    }
}