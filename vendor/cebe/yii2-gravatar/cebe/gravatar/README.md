yii2-gravatar
=============

Gravatar Widget for Yii Framework 2

How to install?
---------------

Get it via [composer](http://getcomposer.org/) by adding the package to your `composer.json`:

```json
{
  "require": {
    "cebe/yii2-gravatar": "1.0"
  }
}
```

You may also check the package information on [packagist](https://packagist.org/packages/cebe/yii2-gravatar).

Usage
-----

```php
<?php echo \cebe\gravatar\Gravatar::widget([
    'email' => 'mail@cebe.cc',
    'options' => [
        'alt' => 'Carsten Brandt'
    ],
    'size' => 32
]); ?>
```
