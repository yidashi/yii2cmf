<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/1
 * Time: 上午11:13
 */

?>
<div class="col-lg-9">
    <div class="page-header">
        <h2>捐赠</h2>
    </div>
    <div class="donate-summary">
        <?= $config['DONATION_FEIHUA'] ?>
        <p>
            支付宝 <img src="<?= $config['DONATION_ALIPAY'] ?>" width="200" height="200" alt="支付宝">&nbsp;&nbsp;&nbsp;
            微信支付 <img src="<?= $config['DONATION_WEIXIN'] ?>" width="200" height="200" alt="微信支付">
        </p>
    </div>
    <div>
        <h5>捐赠名单:</h5>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n{pager}",
            'columns' => [
                'created_at:datetime',
                [
                    'attribute' => 'name',
                    'value' => function($model) {
                        return $model->name . '（' . $model->source . '）';
                    }
                ],
                'money',
                'remark'

            ]
        ]) ?>
    </div>
</div>
