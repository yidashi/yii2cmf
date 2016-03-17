<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/3/17
 * Time: 上午10:19
 */

namespace common\models;


use yii\db\ActiveQuery;

class ArticleQuery extends ActiveQuery
{
    /**
     * 已被删除的
     * @return $this
     */
    public function trashed()
    {
        return $this->andWhere(['>', 'deleted_at', 0]);
    }

    /**
     * 不包括删除的
     */
    public function normal()
    {
        return $this->andWhere(['deleted_at' => 0]);
    }

    /**
     * 未删除且审核通过的
     * @return $this
     */
    public function active()
    {
        return $this->normal()->andWhere(['status' => Article::STATUS_ACTIVE]);
    }
}