<?php
use yii\helpers\Url;

/* @var $theme \frontend\themes\Theme */
$this->title = '主题';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content-header'); ?>
    <h1>
        <?= $this->title?>
        <a class="btn btn-primary btn-flat btn-xs " href="<?= Url::to(['upload']) ?>">上传新主题</a>
    </h1>
<?php $this->endBlock(); ?>
<?php foreach ($dataProvider->getModels() as $theme):?>
    <div class="col-md-3">
        <div class="theme <?= $theme->isActive()?"active":"";?>">


            <?php if(!empty($screenshot = $theme->getScreenshot())):?>
                <div class="theme-screenshot">
                    <a href="<?= Url::to(["view","id"=>$theme->getPackage()])?>"> <img
                            src="<?= $screenshot ?>" alt="" /> <span
                            class="more-details">主题详情</span>
                    </a>
                </div>
            <?php else :?>
                <div class="theme-screenshot blank">
                    <a href="<?= Url::to(["view","id"=>$theme->getPackage()])?>"> <span
                            class="more-details">主题详情</span>
                    </a>
                </div>
            <?php endif;?>



            <h3 class="theme-name">
                <span><?= $theme->isActive()?"默认:":"";?></span><?= $theme->getName()?>
            </h3>

            <div class="theme-actions">
                <?php if( $theme->isActive() == true):?>
                    <a class="btn bg-maroon btn-flat btn-sm"
                       href="<?= Url::to(["custom","id"=>$theme->getPackage()])?>"> 自定义 </a>
                <?php else:?>
                    <a class="btn bg-purple btn-flat btn-sm"
                       href="<?= Url::to(["open","id" => $theme->getPackage(), ['data-method' => 'post']])?>">启用</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a class="btn bg-maroon btn-flat btn-sm"
                       href="<?= Url::to(["demo","id"=>$theme->getPackage()])?>"
                       target="_blank"> 预览 </a>

                <?php endif;?>
            </div>
        </div>
    </div>
<?php endforeach;?>