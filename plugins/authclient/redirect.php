<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 2016/12/16
 * Time: 下午7:10
 */
/**
 * @var \yii\web\View $this
 */
?>
<script>
    window.opener.$.pjax.reload({
        'container':'#header-container'
    });
    window.opener.$("#modal-login").modal("hide")
    window.close();
</script>
