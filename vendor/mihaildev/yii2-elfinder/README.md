ElFinder Расширение для Yii 2
===========================

ElFinder — файловый менеджер для сайта.


## Установка

Удобнее всего установить это расширение через [composer](http://getcomposer.org/download/).

Либо запустить

```
php composer.phar require --prefer-dist mihaildev/yii2-elfinder "*"
```

или добавить

```json
"mihaildev/yii2-elfinder": "*"
```

в разделе `require` вашего composer.json файла.

## Настройка

```php
'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
            'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
            'roots' => [
                [
                    'baseUrl'=>'@web',
                    'basePath'=>'@webroot',
                    'path' => 'files/global',
                    'name' => 'Global'
                ],
                [
                    'class' => 'mihaildev\elfinder\UserPath',
                    'path'  => 'files/user_{id}',
                    'name'  => 'My Documents'
                ],
                [
                    'path' => 'files/some',
                    'name' => ['category' => 'my','message' => 'Some Name'] //перевод Yii::t($category, $message)
                ],
                [
                    'path'   => 'files/some',
                    'name'   => ['category' => 'my','message' => 'Some Name'], // Yii::t($category, $message)
                    'access' => ['read' => '*', 'write' => 'UserFilesAccess'] // * - для всех, иначе проверка доступа в даааном примере все могут видет а редактировать могут пользователи только с правами UserFilesAccess
                ]
            ],
            'watermark' => [
            		'source'         => __DIR__.'/logo.png', // Path to Water mark image
                     'marginRight'    => 5,          // Margin right pixel
                     'marginBottom'   => 5,          // Margin bottom pixel
                     'quality'        => 95,         // JPEG image save quality
                     'transparency'   => 70,         // Water mark image transparency ( other than PNG )
                     'targetType'     => IMG_GIF|IMG_JPG|IMG_PNG|IMG_WBMP, // Target image formats ( bit-field )
                     'targetMinPixel' => 200         // Target image minimum pixel size
            ]
        ]
    ],
```

```php
'controllerMap' => [
        'elfinder' => [
			'class' => 'mihaildev\elfinder\PathController',
			'access' => ['@'],
			'root' => [
				'path' => 'files',
				'name' => 'Files'
			],
			'watermark' => [
						'source'         => __DIR__.'/logo.png', // Path to Water mark image
						 'marginRight'    => 5,          // Margin right pixel
						 'marginBottom'   => 5,          // Margin bottom pixel
						 'quality'        => 95,         // JPEG image save quality
						 'transparency'   => 70,         // Water mark image transparency ( other than PNG )
						 'targetType'     => IMG_GIF|IMG_JPG|IMG_PNG|IMG_WBMP, // Target image formats ( bit-field )
						 'targetMinPixel' => 200         // Target image minimum pixel size
			]
		]
    ],
```

## Использование

```php
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;

echo InputFile::widget([
    'language'   => 'ru',
    'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
    'filter'     => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
    'name'       => 'myinput',
    'value'      => '',
]);

echo $form->field($model, 'attribute')->widget(InputFile::className(), [
    'language'      => 'ru',
    'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
    'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
    'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
    'options'       => ['class' => 'form-control'],
    'buttonOptions' => ['class' => 'btn btn-default'],
    'multiple'      => false       // возможность выбора нескольких файлов
]);

echo ElFinder::widget([
    'language'         => 'ru',
    'controller'       => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
    'filter'           => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
    'callbackFunction' => new JsExpression('function(file, id){}') // id - id виджета
]);

```

## Использование при работе с PathController
```php
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;

echo InputFile::widget([
    'language'   => 'ru',
    'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
    'path' => 'image', // будет открыта папка из настроек контроллера с добавлением указанной под деритории  
    'filter'     => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
    'name'       => 'myinput',
    'value'      => '',
]);

echo $form->field($model, 'attribute')->widget(InputFile::className(), [
    'language'      => 'ru',
    'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
    'path' => 'image', // будет открыта папка из настроек контроллера с добавлением указанной под деритории 
    'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
    'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
    'options'       => ['class' => 'form-control'],
    'buttonOptions' => ['class' => 'btn btn-default'],
    'multiple'      => false       // возможность выбора нескольких файлов
]);

echo ElFinder::widget([
    'language'         => 'ru',
    'controller'       => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
    'path' => 'image', // будет открыта папка из настроек контроллера с добавлением указанной под деритории 
    'filter'           => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
    'callbackFunction' => new JsExpression('function(file, id){}') // id - id виджета
]);

```

## CKEditor
```php
use mihaildev\elfinder\ElFinder;

$ckeditorOptions = ElFinder::ckeditorOptions($controller,[/* Some CKEditor Options */]);

```

Для указания подкаталога (при использовании PathController)
```php
use mihaildev\elfinder\ElFinder;

$ckeditorOptions = ElFinder::ckeditorOptions([$controller, 'path' => 'some/sub/path'],[/* Some CKEditor Options */]);

```

Использование совместно с приложением "mihaildev/yii2-ckeditor" (https://github.com/MihailDev/yii2-ckeditor)

```php
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

$form->field($model, 'attribute')->widget(CKEditor::className(), [
  ...
  'editorOptions' => ElFinder::ckeditorOptions('elfinder',[/* Some CKEditor Options */]),
  ...
]);
```

Для указания подкаталога (при использовании PathController)

```php
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

$form->field($model, 'attribute')->widget(CKEditor::className(), [
  ...
  'editorOptions' => ElFinder::ckeditorOptions(['elfinder', 'path' => 'some/sub/path'],[/* Some CKEditor Options */]),
  ...
]);
```

## Проблемы
При встраивание без iframe возможен конфликт с bootstrap.js. Studio-42/elFinder#740
Решение - добавляем в шаблон запись
```php

mihaildev\elfinder\Assets::noConflict($this);

```

## Полезные ссылки

ElFinder Wiki - https://github.com/Studio-42/elFinder/wiki
