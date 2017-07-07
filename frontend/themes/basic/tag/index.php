<div class="row tablist-warp">
    <main class="col-md-12">
        <h3>热门标签</h3>
        <br>
        <div class="entry-content clearfix">
            <?php foreach ($hotModels as  $model) : ?>
                <a class="btn btn-default" style="margin: 0 20px 20px 0;" href="<?= \yii\helpers\Url::to(['/article/tag', 'name' => $model->name]) ?>"><?= $model->name ?></a>
            <?php endforeach; ?>
        </div>
        <br>
        <h3>所有标签</h3>
        <br>
        <div class="entry-content clearfix">
            <?php foreach ($models as  $model) : ?>
            <a class="btn btn-default" style="margin: 0 20px 20px 0;" href="<?= \yii\helpers\Url::to(['/article/tag', 'name' => $model->name]) ?>"><?= $model->name ?></a>
            <?php endforeach; ?>
        </div>
    </main>
</div>