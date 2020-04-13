<h2>请选择要安装的模块：</h2>
<form method="post" class="install-form">
    <?php foreach ($modules as $module): ?>
        <?php if ($module->isCore): ?>
            <label><input type="checkbox" name="modules[]" value="<?= $module->package ?>" disabled checked/> <?= $module->name ?></label>
        <?php else: ?>
            <label><input type="checkbox" name="modules[]" value="<?= $module->package ?>"/> <?= $module->name ?></label>
        <?php endif; ?>
    <?php endforeach; ?>
</form>
