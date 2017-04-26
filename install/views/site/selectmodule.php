<h2>请选择要安装的模块：</h2>
<form method="post" class="install-form">
    <?php foreach ($modules as $module): ?>
        <label><input type="checkbox" name="modules[]" value="<?= $module->package ?>" <?php if ($module->isCore): ?>disabled<?php endif; ?> checked/> <?= $module->name ?></label>
    <?php endforeach; ?>
</form>
