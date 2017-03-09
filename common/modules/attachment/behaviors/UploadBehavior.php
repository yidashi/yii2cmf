<?php
namespace common\modules\attachment\behaviors;

use common\behaviors\BaseAttachAttribute;
use yii\db\ActiveRecord;
use common\modules\attachment\models\Attachment;
use common\modules\attachment\models\AttachmentIndex;
use yii\helpers\ArrayHelper;

class UploadBehavior extends BaseAttachAttribute
{
    use UploadBehaviorTrait;


    public $multiple = false;


    /**
     * @return array
     */
    public function events()
    {
        return ArrayHelper::merge(parent::events(), [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ]);
    }

    // 根据特性返回这个值
    protected function getValue()
    {
        $value = [];

        if ($this->multiple == false) {
            $value = null;
        }

        if (!$this->owner->isNewRecord) {
            $value = $this->getAttachments();
            if ($this->multiple == false) {
                $value = array_shift($value);
            }
        }

        return $value;
    }

    protected function setValue($value)
    {
        if (!empty($value)) {
            $value = array_filter($value, function ($val) {
                if (empty($val)) {
                    return false;
                }
                return true;
            });
        }
        $this->value = $value;
    }

    public function getAttachments()
    {
        $attachmentIndex = AttachmentIndex::find()->where([
            'entity_id' =>  $this->getEntityId(),
            'entity' => $this->getEntity(),
            'attribute' => $this->attribute
        ])->all();
        $attachmentIds = ArrayHelper::getColumn($attachmentIndex, 'attachment_id');
        return Attachment::findAll(['id' => $attachmentIds]);
    }


    public function afterInsert()
    {
        if ($this->value == null) {
            return;
        }

        $files = $this->value;

        if ($this->multiple == false) {
            $files = [$files];
        }

        $indexIds = []; // 只建立关系

        foreach ($files as $file) {
            if ($file['id'] > 0) {
                $indexIds[] = $file['id'];
            }
        }

        $this->batchSaveIndex($indexIds);
    }

    /**
     * 和数据库中的ID进行比较
     *
     * 两组不同的则是删除的.
     *
     * 删除附件的方法
     * 1.删除该item和附件的关系.
     * 2.检查该附件是否有其他引用,如果没有引用则删除附件表中的文件.再删除文件
     */
    public function afterUpdate()
    {
        if ($this->value != null) {
            $files = $this->value;
            if ($this->multiple == false) {
                $files = [$files];
            }
        } else {
            $files = [];
        }

        $relatedIds = $this->getRelatedIds();
        $indexIds = []; // 只建立关系
        $existIds = []; // 存在Oldid中的id,不存在的代表已经被删除的
        foreach ($files as $file) {
            if ($file['id'] > 0 && !in_array($file['id'], $relatedIds)) {
                $indexIds[] = $file['id'];
            } else {
                $existIds[] = $file['id'];
            }
        }


        $this->batchSaveIndex($indexIds);
        $this->deleteNotExistFiles($relatedIds, $existIds);
    }

    public function batchSaveIndex( $indexIds)
    {
        // $indexIds 关系可以去重
        foreach (array_unique($indexIds) as $id) {
            $this->saveIndex($id);
        }
    }
}
