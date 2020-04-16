<h2>请选择要安装的模块：</h2>
<form method="post" class="install-form">
    <div>
    <h3 class="panel-title">核心模块</h3>
    <br>
    <?php foreach ($cores as $module): ?>
        <label><input type="checkbox" name="modules[]" value="<?= $module->package ?>" disabled checked/> <?= $module->name ?></label>
    <?php endforeach; ?>
    </div>
    <hr>
    <div>
    <h3 class="panel-title">非核心模块</h3>
    <br>
    <label><input type="checkbox" id="selectall"/> 全选</label>
    <br>
    <?php foreach ($uncores as $module): ?>
        <label><input type="checkbox" name="modules[]" value="<?= $module->package ?>"/> <?= $module->name ?></label>
    <?php endforeach; ?>
    </div>
</form>
