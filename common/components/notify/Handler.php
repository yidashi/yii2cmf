<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/7
 * Time: 上午10:10
 */

namespace common\components\notify;



use common\models\Notify;
use common\models\NotifyCategory;
use Yii;
use yii\base\Object;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\helpers\Url;

class Handler extends Object
{

    public $notify;


    public $notifyCategory;
    /**
     * @var
     */
    public $user;
    /**
     * @var array
     */
    private $_errors;

    /**
     * 依赖notify,notifyCategory
     * @param Notify $notify
     * @param NotifyCategory $notifyCategory
     * @param array $config
     */
    public function __construct(Notify $notify, NotifyCategory $notifyCategory, $config = [])
    {
        $this->notify = $notify;
        $this->notifyCategory = $notifyCategory;
        $this->user = Yii::$app->user;
        parent::__construct($config);
    }

    public function category($name)
    {
        $category_id = $this->notifyCategory->find()->select('id')->where(['name' => $name])->scalar();
        $this->notify->category_id = $category_id;
        return $this;
    }

    public function from($uid)
    {
        $this->notify->from_uid = $uid;
        return $this;
    }

    public function to($uid)
    {
        $this->notify->to_uid = $uid;
        return $this;
    }

    public function link($link)
    {
        $this->notify->link = Url::to($link);
        return $this;
    }

    public function extra($extra)
    {
        $this->notify->extra = Json::encode($extra);
        return $this;
    }
    public function send()
    {
        if ($this->notify->save() === false) {
            $this->_errors = $this->notify->errors;
            return false;
        }
        return true;
    }

    public function getNoReadNums()
    {
        return $this->notify->find()->where(['to_uid' => $this->user->id, 'read' => 0])->count();
    }

    public function getDataProvider()
    {
        return new ActiveDataProvider([
            'query' => $this->notify->find()->where(['to_uid' => $this->user->id]),
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
    }

    public function readAll()
    {
        return $this->notify->updateAll(['read' => 1], ['to_uid' => $this->user->id]);
    }

    public function getErrors()
    {
        return $this->_errors;
    }
}