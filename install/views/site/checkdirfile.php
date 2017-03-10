<form class="install-form">
    <table class="table">
        <caption><h2>目录/文件权限</h2></caption>
        <thead>
        <tr>
            <th>目录/文件</th>
            <th>所需状态</th>
            <th>当前状态</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= $item[3] ?></td>
                <td><i class="ico-success">&nbsp;</i>可写</td>
                <td><i class="ico-<?= $item[2] ?>">&nbsp;</i><?= $item[1] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</form>