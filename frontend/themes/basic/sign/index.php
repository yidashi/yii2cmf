<?php
/**
 * @var $this \yii\web\View
 */

use yii\helpers\Url;

$this->title = '签到会员';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php \yii\widgets\Pjax::begin(['id' => 'container-sign', 'options' => ['class' => 'row']]) ?>
    <div class="col-md-9">
        <div class="page-header">
            <h2>今日签到会员</h2>
            <span class="pull-right">
<!--                昨日签到：<font style="font-weight: bold; color: red; margin-right: 20px;">174</font>-->
                <!--                上周同期：<font style="font-weight: bold; color: red; margin-right: 20px;">171</font>-->
                今日签到：<span style="font-weight: bold; color: red;"><?= $dataProvider->getTotalCount() ?></span>
            </span>
        </div>
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}",
            'itemView' => '_item',
            'itemOptions' => [
                'tag' => 'li',
                'class' => 'media col-lg-4 col-md-4',
                'style' => 'float: left; margin-bottom: 15px; font-size: 12px; margin-top: 0;'
            ],
            'options' => [
                'tag' => 'ul',
                'class' => 'media-list sign'
            ]
        ]) ?>
    </div>
    <div class="col-md-3">
        <div class="btn-group btn-group-justified">
            <?php if(Yii::$app->user->isGuest || (!Yii::$app->user->isGuest && !\common\models\Sign::isSign())): ?>
                <a class="btn btn-success btn-sign" href="<?= Url::to(['/sign/sign'])?>" data-ajax="1" data-refresh-pjax-container="container-sign" data-method="post"><i class="fa fa-calendar-plus-o"></i> 点此处签到<br>签到有好礼</a>
            <?php else: ?>
                <a class="btn btn-success disabled" href="<?= Url::to(['/sign/index'])?>"><i class="fa fa-calendar-check-o"></i> 今日已签到<br>已连续<?= \yii\helpers\ArrayHelper::getValue($signInfo, 'continue_times', 0) ?>天</a>
            <?php endif; ?>
        </div>
        <table class="table table-bordered table-sign">
            <thead>
            <tr><th style="color:red">日</th><th>一</th><th>二</th><th>三</th><th>四</th><th>五</th><th style="color:red">六</th></tr>
            </thead>
            <tbody>
            <?php foreach ($weeks as $week): ?>
                <tr>
                <?php for ($i=0; $i<7; $i++): ?>
                <td<?php if(isset($week[$i]) && $week[$i]['sign']): ?> class="success"<?php endif; ?>>
                    <?php if(isset($week[$i])): ?>
                        <?= $week[$i]['day'] ?>
                    <?php endif; ?>
                </td>
                <?php endfor; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php \yii\widgets\Pjax::end() ?>

