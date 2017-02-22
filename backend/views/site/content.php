<div class="content-wrapper">
    <div id="tab-nav" class="tab-nav hidden-xs">
        <div class="tab-nav-wp">
            <ul id="min_title_list" class="acrossTab cl">
                <li class="active"><span data-href="<?= \yii\helpers\Url::to(['/site/dashboard']) ?>">控制面板</span><i></i><em></em></li>
            </ul>
        </div>
        <div class="tab-nav-more btn-group">
            <a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;">
                <i class="fa fa-arrow-left"></i>
            </a>
            <a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;">
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>
    <div id="iframe_box" class="content-iframe">
        <div class="show_iframe">
            <div style="display:none" class="loading"></div>
            <iframe scrolling="yes" frameborder="0" src="<?= \yii\helpers\Url::to(['/site/dashboard']) ?>"></iframe>
        </div>
    </div>
</div>