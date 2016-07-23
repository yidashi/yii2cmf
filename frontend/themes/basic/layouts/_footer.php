<?php
use yii\helpers\Url;
?>
<footer class="footer">
    <div class="container">
        <div class="footer-link">
            <a href="<?= Url::to(['/page/slug', 'slug' => 'aboutus'])?>">关于我们</a>
            <a href="<?= Url::to(['/page/slug', 'slug' => 'mianze'])?>">免责声明</a>
            <a href="<?= Url::to(['/suggest'])?>" title="意见反馈">意见反馈</a>
        </div>
        <div class="friendly-link">
            <span>友情链接：</span>
            <?php if(\common\models\Nav::getItems('friend-link')): ?>
                <?php foreach(\common\models\Nav::getItems('friend-link') as $v): ?>
                    <a href="<?= Url::to($v['url']) ?>" target="_blank" title="<?= $v['label'] ?>"><?= $v['label'] ?></a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="footer-copyright">
            <p>&copy; <?= Yii::$app->config->get('SITE_NAME').' '.date('Y') ?></p>
            <p><?= Yii::$app->config->get('SITE_ICP')?></p>
        </div>
    </div>
</footer>