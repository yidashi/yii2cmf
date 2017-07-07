<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1>页面找不到了</h1>
    <div class="error-search">
        <form action="<?= url(['/search']) ?>" method="get">
            <div class="input-group">
                <input type="text" class="form-control" name="q" placeholder="全站搜索">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                </span>
            </div>
        </form>
    </div>


</div>
