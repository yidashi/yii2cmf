<div class="container">
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-8">
            <?= \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_item',
                'layout' => "{items}",
                'options' => [],
                'itemOptions' => ['class' => 'block']
            ]) ?>
        </div>
    </div>
</div>