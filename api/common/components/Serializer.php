<?php
namespace api\common\components;

use yii\base\Model;
use yii\data\Pagination;
use yii\web\BadRequestHttpException;

class Serializer extends \yii\rest\Serializer
{
    public $collectionEnvelope = 'list';

    /**
     * Serializes a pagination into an array.
     * @param Pagination $pagination
     * @return array the array representation of the pagination
     * @see addPaginationHeaders()
     */
    protected function serializePagination($pagination)
    {
        return [
            'total_count' => $pagination->totalCount,
            'page_count' => $pagination->getPageCount(),
            'page' => $pagination->getPage() + 1,
            'page_size' => $pagination->getPageSize(),
        ];
    }

    /**
     * Serializes the validation errors in a model.
     * @param Model $model
     * @return array the array representation of the errors
     */
    protected function serializeModelErrors($model)
    {
        throw new BadRequestHttpException(current($model->getFirstErrors()));
    }
}
