<?php

use common\services\NavService;
use yii\helpers\Url;

?>
<footer class="footer">
    <div class="container">
        <div class="footer-link">
            <?php foreach(NavService::getItems('footer') as $v): ?>
                <a href="<?= Url::to($v['url']) ?>" target="_blank" title="<?= $v['label'] ?>"><?= $v['label'] ?></a>
            <?php endforeach; ?>
        </div>
        <div class="friendly-link">
            <span>友情链接：</span>
            <?php foreach(NavService::getItems('friend-link') as $v): ?>
                <a href="<?= Url::to($v['url']) ?>" target="_blank" title="<?= $v['label'] ?>"><?= $v['label'] ?></a>
            <?php endforeach; ?>
        </div>
        <div class="footer-copyright">
            <p>&copy; <?= Yii::$app->config->get('site_name').' '.date('Y') ?></p>
            <p><?= Yii::$app->config->get('site_icp')?></p>
        </div>
    </div>
</footer>