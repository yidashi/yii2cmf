<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>圣诞主题</title>
    <link rel='stylesheet' href='<?=Yii::getAlias('@web')?>/css/christmas.css' />
    <script type="text/javascript" src="http://img.mukewang.com/down/566a38f000016f0900000000.js"></script>
</head>

<body>
<section class="container">
    <!-- 第一幅画面 -->
    <section class="page-a bg-adaptive">
        <!-- 男孩 -->
        <div class="chs-boy chs-boy-deer"></div>
        <!-- 月亮 -->
        <div class="moon"></div>
        <!-- 云 -->
        <div class="cloudy"></div>
        <!-- 圣诞树 -->
        <figure class="tree"></figure>
        <!-- 星星 -->
        <svg viewBox="0 0 512 486">
            <defs>
                <linearGradient id="star" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#FCF0BC"></stop>
                    <stop offset="0%" stop-color="#FCF0BC"></stop>
                </linearGradient>
            </defs>
            <polygon style="fill: url(#star);" points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon>
        </svg>
        <!-- 窗户 -->
        <div class="window wood">
            <div class="window-bg"></div>
            <div class="window-content">
                <div class="window-left"></div>
                <div class="window-right"></div>
            </div>
        </div>
    </section>
    <!-- 第二幅画面 -->
    <section class="page-b bg-adaptive">
        <!-- 猫 -->
        <figure class="cat"></figure>
        <!-- 小女孩 -->
        <figure class="girl"></figure>
        <!-- 圣诞男孩 -->
        <figure class="christmas-boy-head"></figure>
        <figure class="christmas-boy boy-walk"> </figure>
        <!-- 旋转木马 -->
        <div id="carousel">
            <figure id="spinner"></figure>
        </div>
    </section>
    <!-- 第三幅画面 -->
    <section class="page-c bg-adaptive">
        <!-- 月亮 -->
        <div class="moon"></div>
        <!-- 云 -->
        <div class="cloudy"></div>

        <!-- 星星 -->
        <svg viewBox="0 0 512 486">
            <defs>
                <linearGradient id="star" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#FCF0BC"></stop>
                    <stop offset="0%" stop-color="#FCF0BC"></stop>
                </linearGradient>
            </defs>
            <polygon style="fill: url(#star);" points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon>
        </svg>

        <!-- 圣诞树 -->
        <figure class="tree treefix"></figure>
        <!-- 鹿 -->
        <figure class="deer"></figure>
        <!-- 窗户关闭 -->
        <div class="window wood">
            <!-- <div class="window-bg"></div> -->
            <div class="window-content" data-attr="red">
                <div class="window-scene-bg"></div>
                <div class="window-close-bg"></div>
                <div class="window-left hover"></div>
                <div class="window-right hover"></div>
            </div>
        </div>
        <!-- 雪花 -->
        <canvas id="snowflake" style="position:absolute;z-index:999;"></canvas>
    </section>
</section>
</body>

</html>
