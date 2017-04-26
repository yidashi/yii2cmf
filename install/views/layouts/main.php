<?php
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\helpers\Url;
use install\assets\AppAsset;

/** @var \yii\web\AssetBundle $bundle */
$bundle = AppAsset::register($this);
$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags()?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head()?>
</head>
<body>
<?php $this->beginBody()?>
<div class="container" id="wrapper">

    <div class="panel loading" id="target">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left">Yii2CMF</h3>
            <div class="pull-right">
                Version <strong><?= Yii::getVersion() ?></strong>
            </div>
        </div>
        <div class="panel-body ">


            <div id="progress">
                <?php
                echo Menu::widget([
                    "options" => [
                        "class" => "list-group"
                    ],
                    "itemOptions" => [
                        "class" => "list-group-item"
                    ],
                    "linkTemplate" => '{label}',
                    "items" => [
                        [
                            'label' => '欢迎页面',
                            "url" => [
                                "site/index"
                            ],
                            "options" => [
                                "data-url" => Url::to([
                                    "site/index"
                                ])
                            ]
                        ],
                        // [
                        // 'label' => '选择安装语言',
                        // "url" => [
                        // "site/language"
                        // ],
                        // "options" => [
                        // "data-url" => Url::to([
                        // "site/language"
                        // ])
                        // ]
                        // ],
                        [
                            'label' => '许可协议',
                            "url" => [
                                "site/license-agreement"
                            ],
                            "options" => [
                                "data-url" => Url::to([
                                    "site/license-agreement"
                                ])
                            ]
                        ],
                        [
                            'label' => '检查安装条件',
                            "url" => [
                                "site/check-env"
                            ],
                            "options" => [
                                "data-url" => Url::to([
                                    "site/check-env"
                                ])
                            ]
                        ],
                        [
                            'label' => '检查文件目录权限',
                            "url" => [
                                "site/check-dir-file"
                            ],
                            "options" => [
                                "data-url" => Url::to([
                                    "site/check-dir-file"
                                ])
                            ]
                        ],
//                                         [
//                                             'label' => '选择DB',
//                                             "url" => [
//                                                 "site/select-db"
//                                             ],
//                                             "options" => [
//                                                 "data-url" => Url::to([
//                                                     "site/select-db"
//                                                 ])
//                                             ]
//                                         ],
                        [
                            'label' => '输入DB信息',
                            "url" => [
                                "site/set-db"
                            ],
                            "options" => [
                                "data-url" => Url::to([
                                    "site/set-db"
                                ])
                            ]
                        ],
                        [
                            'label' => '站点设置',
                            "url" => [
                                "site/set-site"
                            ],
                            "options" => [
                                "data-url" => Url::to([
                                    "site/set-site"
                                ])
                            ]
                        ],
                        [
                            'label' => '输入管理员信息',
                            "url" => [
                                "site/set-admin"
                            ],
                            "options" => [
                                "data-url" => Url::to([
                                    "site/set-admin"
                                ])
                            ]
                        ],
                        [
                            'label' => '选择安装模块',
                            "url" => [
                                "site/select-module"
                            ],
                            "options" => [
                                "data-url" => Url::to([
                                    "site/select-module"
                                ])
                            ]
                        ]
                    ]
                ]);
                ?>
            </div>
            <div id="content">
                <div class="infoArea">
                    <?php echo $content;?>
                </div>

                <?php if (isset($this->blocks['ibtnArea'])): ?>
                    <?= $this->blocks['ibtnArea']?>
                <?php else: ?>
                    <div class="ibtnArea clearfix">
            		<span class="pull-left"> <a href="javascript:void(0)"
                                                class="btn btn-small  btn-primary" id="prevButton"><i
                                    class="fa fa-arrow-circle-left"></i> 返回 </a>
            		</span> <span class="pull-right"> <a href="javascript:void(0)"
                                                         class="btn btn-small  btn-primary" id="nextButton">下一步 <i
                                        class="fa fa-arrow-circle-right"></i>
            		</a>
            		</span>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>
