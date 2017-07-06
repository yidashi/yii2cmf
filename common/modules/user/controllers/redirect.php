<?php
use yii\helpers\Json;

/* @var $this \yii\base\View */
/* @var $url string */
/* @var $enforceRedirect bool */
?>
<!DOCTYPE html>
<html>
<head>
<script>
    var url = <?= Json::htmlEncode($url) ?>;
    if (window.opener && !window.opener.closed) {
        if (window.opener.$("#modal-login:visible").size()>0) {
            window.opener.$.pjax.reload({
                'container':'#header-container'
            });
            window.opener.$("#modal-login").modal("hide");
        } else {
            window.opener.location = url;
        }
        window.opener.focus();
        window.close();
    } else {
        window.location = url;
    }
</script>
</head>
<body>

</body>
</html>
