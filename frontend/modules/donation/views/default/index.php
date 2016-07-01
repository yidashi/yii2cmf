<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/1
 * Time: 上午11:13
 */
$this->params['breadcrumbs'][] = '捐赠';
list(, $url) = Yii::$app->assetManager->publish('@frontend/modules/donation//assets');
?>
<div class="col-lg-9">
    <div class="page-header">
        <h2>捐赠</h2>
    </div>
    <div class="donate-summary">
        <p>目前xxxx由xxx出资构建，服务器搭建于阿里云服务器，每月需提供一定主机和七牛云存储费用，此外，xxx坚持每天更新内容，需要耗费大量的时间与精力，保证网站的正常运作 ，blablabla,如果您对我们的成果表示认同或对您有所帮助， 我们乐意接受您的捐赠。我们的开源事业离不开您的支持，使用支付宝钱包或微信，扫描下面二维码可立即捐赠。</p>
        <p>注：捐赠时可留言，或联系xxx为您加上留言！</p>
        <p>
            <img src="<?= $url . '/alipay.jpg' ?>" width="200" height="250" alt="支付宝">
            <img src="<?= $url . '/weixin.png' ?>" width="200" height="250" alt="微信支付">
        </p>
    </div>
    <div>
        <h5>捐赠名单:</h5>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n{pager}",
            'columns' => [
                'created_at',
                'name',
                'money',
                'remark'

            ]
        ]) ?>
    </div>
</div>
