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
     * 被删除的
     */
    public function onlyTrashed()
    {
        return $this->andWhere(['not', ['deleted_at' => null]]);
    }
    /**
     * 未被删除的
     */
    public function notTrashed()
    {
        return $this->andWhere(['deleted_at' => null]);
    }

    /**
     * 待审核的
     */
    public function pending()
    {
        return $this->andWhere(['status' => Article::STATUS_PENDING]);
    }
    /**
     * 审核通过的
     */
    public function active()
    {
        return $this->andWhere(['status' => Article::STATUS_ACTIVE]);
    }
    /**
     * 未删除且审核通过的
     */
    public function normal()
    {
        return $this->notTrashed()->active();
    }

    /**
     * 已经发布的
     */
    public function published()
    {
        return $this->normal()->andWhere(['<', 'published_at', time()]);
    }

    public function my()
    {
        return $this->andWhere(['user_id' => \Yii::$app->user->id]);
    }
}