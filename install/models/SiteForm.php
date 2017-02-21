<?php
namespace install\models;

use yii\base\Model;
use Yii;


class SiteForm extends Model
{
    

    public $SITE_URL = 'http://';

    const CACHE_KEY = "install-site-form";
    
    public function rules()
    {
        return [
            [['SITE_URL',], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'SITE_URL' => '站点地址',
        ];
    }
    
    public function  loadDefaultValues()
    {
        $data = \Yii::$app->getCache()->get(SiteForm::CACHE_KEY);
        if($data) {
            $this->setAttributes($data);
        }
    }

    public function save()
    {
       \Yii::$app->getCache()->set(SiteForm::CACHE_KEY, $this->toArray());
        return true;
    }
}