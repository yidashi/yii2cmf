<?php
namespace common\modules\attachment\behaviors;

use common\modules\attachment\models\Attachment;
use common\modules\attachment\models\AttachmentIndex;
use common\traits\EntityTrait;
use yii\helpers\ArrayHelper;

trait UploadBehaviorTrait
{
    use EntityTrait;
    /**
     * 里面三段代码的顺序不能错..
     */
    public function afterDelete()
    {
        $relatedIds = $this->getRelatedIds();

        AttachmentIndex::deleteAll([
            'entity_id' => $this->getEntityId(),
            'entity' => $this->getEntity(),
        ]);

        foreach ($relatedIds as $id) {
            $this->deleteFile($id);
        }
    }

    public function deleteNotExistFiles($relatedIds, $existIds)
    {
        foreach (array_diff($relatedIds, $existIds) as $id) {
            // 删除索引关系
            AttachmentIndex::deleteAll([
                'attachment_id' => $id,
                'entity_id' => $this->getEntityId(),
                'attribute' => $this->attribute,
                'entity' => $this->getEntity(),
            ]);

            // 尝试删除文件
            $this->deleteFile($id);
        }
    }

    /**
     * 先检查文件是否被使用没有使用则删除,在beforedelete中
     * 尝试删除文件.
     *
     * @param integer $id
     * @return bool
     */
    public function deleteFile($id)
    {
        $isUse = AttachmentIndex::find()->where([
            'attachment_id' => $id,
        ])->count();

        if ($isUse > 0) {
            return false;
        }

        $file = Attachment::findOne([
            'id' => $id,
        ]);
        if ($file !== null) {
            //暂不删，不是所有附件都用到了这个
//            $file->delete();
        }

    }

    public function getRelatedIds()
    {
        $attachments = AttachmentIndex::find()->where([
            'entity' => $this->getEntity(),
            'entity_id' => $this->getEntityId(),
            'attribute' => $this->attribute,
        ])->all();

        return ArrayHelper::getColumn($attachments, 'attachment_id');
    }

    public function saveIndex($id)
    {
        $relation = new AttachmentIndex();
        $relation->entity = $this->getEntity();
        $relation->entity_id = $this->getEntityId();
        $relation->attribute = $this->attribute;
        $relation->attachment_id = $id;
        $relation->save();
    }
}
