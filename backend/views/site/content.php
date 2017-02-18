<?php
use yii\widgets\Breadcrumbs;

?>

<div class="content-wrapper">
    <div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
        <div class="Hui-tabNav-wp">
            <ul id="min_title_list" class="acrossTab cl">
                <li class="active"><span data-href="<?= \yii\helpers\Url::to(['/site/dashboard']) ?>">控制面板</span><em></em></li>
            </ul>
        </div>
        <div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
    </div>
    <div id="iframe_box" class="content-iframe">
        <div class="show_iframe">
            <div style="display:none" class="loading"></div>
            <iframe scrolling="yes" frameborder="0" src="<?= \yii\helpers\Url::to(['/site/dashboard']) ?>"></iframe>
        </div>
    </div>
</div>
<footer class="main-footer">
    <?= Yii::powered()?>
</footer>