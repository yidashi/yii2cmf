<?php
/**
 * @var yii\web\View
 */
$markdown = <<< TEXT
RBAC Manager
------------

See [Yii RBAC](http://www.yiiframework.com/doc-2.0/guide-authorization.html) for more detail.
TEXT;

echo yii\helpers\Markdown::process($markdown);
