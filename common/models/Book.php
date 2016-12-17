<?php

namespace common\models;

use common\helpers\Tree;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%book}}".
 *
 * @property integer $id
 * @property string $book_name
 * @property string $book_cover
 * @property string $book_link
 * @property integer $book_author
 * @property string $book_description
 * @property integer $view
 * @property integer $created_at
 * @property integer $updated_at
 * @property BookChapter $firstChapters
 * @property BookChapter[] $chapters
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%book}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['book_author'], 'integer'],
            [['book_name'], 'string', 'max' => 50],
            [['book_cover', 'book_link'], 'string', 'max' => 255],
            [['book_description'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'book_name' => '书名',
            'book_cover' => '书封面',
            'book_author' => '作者',
            'book_description' => '书简介',
            'book_link' => '书外链',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function getFirstChapter()
    {
        return $this->hasOne(BookChapter::className(), ['book_id' => 'id'])->orderBy(['sort' => SORT_ASC]);
    }

    public function getChapters()
    {
        return $this->hasMany(BookChapter::className(), ['book_id' => 'id'])->orderBy(['sort' => SORT_ASC]);
    }

    public function getMenuItems()
    {
        $chapters = $this->chapters;
        $items = [];
        foreach ($chapters as $chapter) {
            $item = [];
            $item['label'] = $chapter->chapter_name;
            $item['url'] = empty($chapter->chapter_body) ? '#' : ['/book/chapter', 'id' => $chapter->id];
            $item['active'] = request('id') == $chapter->id && Yii::$app->controller->action->id == 'chapter';
            $item['id'] = $chapter->id;
            $item['pid'] = $chapter->pid;
            $items[] = $item;
        }
        $tree = Tree::build($items, 'id', 'pid', 'items');
        return $tree;
    }

    public function getUpdateMenuItems()
    {
        $chapters = $this->chapters;
        $items = [];
        foreach ($chapters as $chapter) {
            $item = [];
            $item['label'] = $chapter->chapter_name;
            $item['url'] = ['/book/update-chapter', 'id' => $chapter->id];
            $item['active'] = (request('id') == $chapter->id && Yii::$app->controller->action->id == 'update-chapter') || (request('chapter_id') == $chapter->id && Yii::$app->controller->action->id == 'create-chapter');
            $item['id'] = $chapter->id;
            $item['pid'] = $chapter->pid;
            $item['linkOptions'] = ['data-id' => $chapter->id, 'data-pid' => $chapter->pid];
            $items[] = $item;
        }
        $tree = Tree::build($items, 'id', 'pid', 'items');
        return $tree;
    }

    public function addView()
    {
        return $this->updateCounters(['view' => 1]);
    }

    /**
     * 获取所有评论数
     */
    public function getAllComment()
    {
        $chapters = $this->chapters;
        $chapterIds = [];
        foreach ($chapters as $chapter) {
            $chapterIds[] = $chapter->id;
        }
        return Comment::find()->where(['type' => 'book', 'type_id' => $this->id])->andWhere(['type' => 'book-chapter', 'type_id' => $chapterIds])->count();
    }

    public function getBookCover()
    {
        return $this->book_cover;
    }
}
