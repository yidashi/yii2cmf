<a href="<?=\yii\helpers\Url::to(['/document/view', 'id' => $model->document->id])?>"><?=$model->document->title?></a>
<?= \yii\helpers\Html::a('取消', ['/favourite'], [
    'data' => [
        'method' => 'post',
        'ajax' => 1,
        'params' => [
            'id' => $model->document->id
        ],
        'confirm' => '确定要取消收藏吗?',
        'refresh' => '1'
    ],
    'class' => 'text-danger pull-right'
])?>