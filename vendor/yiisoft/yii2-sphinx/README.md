Sphinx Extension for Yii 2
==========================

This extension adds [Sphinx](http://sphinxsearch.com/docs) full text search engine extension for the [Yii framework 2.0](http://www.yiiframework.com).
It supports all Sphinx features including [Runtime Indexes](http://sphinxsearch.com/docs/current.html#rt-indexes).

For license information check the [LICENSE](LICENSE.md)-file.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://poser.pugx.org/yiisoft/yii2-sphinx/v/stable.png)](https://packagist.org/packages/yiisoft/yii2-sphinx)
[![Total Downloads](https://poser.pugx.org/yiisoft/yii2-sphinx/downloads.png)](https://packagist.org/packages/yiisoft/yii2-sphinx)
[![Build Status](https://travis-ci.org/yiisoft/yii2-sphinx.svg?branch=master)](https://travis-ci.org/yiisoft/yii2-sphinx)


Requirements
------------

At least Sphinx version 2.0 is required. However, in order to use all extension features, Sphinx version 2.2.3 or
higher is required.


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiisoft/yii2-sphinx
```

or add

```json
"yiisoft/yii2-sphinx": "~2.0.0"
```

to the require section of your composer.json.


Configuration
-------------

This extension interacts with Sphinx search daemon using MySQL protocol and [SphinxQL](http://sphinxsearch.com/docs/current.html#sphinxql) query language.
In order to setup Sphinx "searchd" to support MySQL protocol following configuration should be added:

```
searchd
{
    listen = localhost:9306:mysql41
    ...
}
```

To use this extension, simply add the following code in your application configuration:

```php
return [
    //....
    'components' => [
        'sphinx' => [
            'class' => 'yii\sphinx\Connection',
            'dsn' => 'mysql:host=127.0.0.1;port=9306;',
            'username' => '',
            'password' => '',
        ],
    ],
];
```
