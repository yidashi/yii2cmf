<?php
/**
 * Created by PhpStorm.
 * Author: yidashi
 * DateTime: 2017/3/20 13:55
 * Description:
 */
use yii\helpers\Html;
use common\modules\user\widgets\AuthChoice;

$this->title = '授权管理';
?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('../_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <div class="alert alert-info">
                    <p><?= Yii::t('app', 'You can connect multiple accounts to be able to log in using them') ?>.</p>
                </div>
                <?php $auth = AuthChoice::begin([
                    'baseAuthUrl' => ['/user/security/auth'],
                    'autoRender' => false,
                    'popupMode' => false,
                ]) ?>
                <table class="table">
                    <?php foreach ($auth->getClients() as $client): ?>
                        <tr>
                            <td style="width: 32px; vertical-align: middle">
                                <?= Html::tag('span', '', ['class' => 'auth-icon ' . $client->getName()]) ?>
                            </td>
                            <td style="vertical-align: middle">
                                <strong><?= $client->getTitle() ?></strong>
                            </td>
                            <td style="width: 120px">
                                <?= $auth->isConnected($client) ?
                                    Html::a(Yii::t('app', 'Disconnect'), ['disconnect', 'id' => $client->getId()], [
                                        'class' => 'btn btn-danger btn-block',
                                        'data-method' => 'post',
                                    ]) :
                                    Html::a(Yii::t('app', 'Connect'), $auth->createClientUrl($client), [
                                        'class' => 'btn btn-success btn-block',
                                    ])
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <?php AuthChoice::end() ?>
            </div>
        </div>
    </div>
</div>
