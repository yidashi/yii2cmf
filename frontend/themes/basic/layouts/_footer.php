<?php
use yii\helpers\Url;

?>
<footer class="footer">
    <div class="container">
        <div class="footer-link">
            <?php foreach(\common\models\Nav::getItems('footer') as $v): ?>
                <a href="<?= Url::to($v['url']) ?>" target="_blank" title="<?= $v['label'] ?>"><?= $v['label'] ?></a>
            <?php endforeach; ?>
        </div>
        <div class="friendly-link">
            <span>友情链接：</span>
            <?php foreach(\common\models\Nav::getItems('friend-link') as $v): ?>
                <a href="<?= Url::to($v['url']) ?>" target="_blank" title="<?= $v['label'] ?>"><?= $v['label'] ?></a>
            <?php endforeach; ?>
        </div>
        <div class="footer-copyright">
            <p>&copy; <?= Yii::$app->config->get('SITE_NAME').' '.date('Y') ?></p>
            <p><?= Yii::$app->config->get('SITE_ICP')?></p>
        </div>
    </div>
</footer>