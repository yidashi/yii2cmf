<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/1
 * Time: 上午11:13
 */
$this->params['breadcrumbs'][] = '捐赠';
list(, $url) = Yii::$app->assetManager->publish('@plugins/donation/assets');
?>
<div class="col-lg-9">
    <div class="page-header">
        <h2>捐赠</h2>
    </div>
    <div class="donate-summary">
        <?= Yii::$app->config->get('DONATION_FEIHUA') ?>
        <p>
            支付宝 <img src="<?= $url . '/alipay.png' ?>" width="200" height="200" alt="支付宝">&nbsp;&nbsp;&nbsp;
            微信支付 <img src="<?= $url . '/weixin.png' ?>" width="200" height="200" alt="微信支付">
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
