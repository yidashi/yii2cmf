<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/3/17
 * Time: 上午10:19
 */

namespace common\models\query;


use common\models\Article;
use yii\db\ActiveQuery;

class ArticleQuery extends ActiveQuery
{
    /**
     * 已被删除的
     */
    public function trashed()
    {
        return $this->andWhere(['>', 'deleted_at', 0]);
    }

    /**
     * 不包括删除的
     * @return $this the query object itself
     */
    public function normal()
    {
        return $this->andWhere(['deleted_at' => 0]);
    }

    /**
     * 未删除且审核通过的
     */
    public function active()
    {
        return $this->normal()->andWhere(['status' => Article::STATUS_ACTIVE]);
    }

    public function published()
    {
        return $this->active()->andWhere(['<', 'published_at', time()]);
    }
}