<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/4/7
 * Time: 下午6:13
 */
$this->title = '';
?>
<div>头像:<?= \common\helpers\Html::img($profile->avatar, ['width' => 100, 'height' => 100])?></div>
<div>个性签名:<?= $profile->signature?></div>
<div>余额:<?= $profile->money?></div>