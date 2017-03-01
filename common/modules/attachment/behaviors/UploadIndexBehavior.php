<?php
namespace common\modules\attachment\behaviors;


use yii\db\ActiveRecord;
use yii\base\Behavior;

class UploadIndexBehavior extends Behavior
{
    use UploadBehaviorTrait;

    public $file;

    public $attribute;

    /**
     *
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];
    }


    public function afterInsert()
    {
        $file = $this->owner->{$this->file};
          if ($file["id"] == - 1) {
            $attachment = $this->attachFile($file);
            $this->saveIndex($attachment->primaryKey);
        } elseif ($file["id"] > 0) {
            $this->saveIndex($file["id"]);
        }
    }


}