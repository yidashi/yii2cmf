# yii2-schemadump

[![Latest Stable Version](https://poser.pugx.org/jamband/yii2-schemadump/v/stable.svg)](https://packagist.org/packages/jamband/yii2-schemadump) [![Total Downloads](https://poser.pugx.org/jamband/yii2-schemadump/downloads.svg)](https://packagist.org/packages/jamband/yii2-schemadump) [![Latest Unstable Version](https://poser.pugx.org/jamband/yii2-schemadump/v/unstable.svg)](https://packagist.org/packages/jamband/yii2-schemadump) [![License](https://poser.pugx.org/jamband/yii2-schemadump/license.svg)](https://packagist.org/packages/jamband/yii2-schemadump)

This command to generate the schema from an existing database.

## Demo

![gif](https://raw.githubusercontent.com/jamband/jamband.github.io/master/images/yii2-schemadump.gif)

## Installation

```
php composer.phar require --dev --prefer-dist jamband/yii2-schemadump "*"
```

or add in composer.json (require-dev section)
```
"jamband/yii2-schemadump": "*"
```

## Usage

Add the following in config/console.php:

```php
<?php
return [
    ...
    'components' => [
        ...
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'templateFile' => '@jamband/schemadump/template.php',
        ],
        'schemadump' => [
            'class' => 'jamband\schemadump\SchemaDumpController',
        ],
    ],
    ...
];
```

And run `schemadump` command.

```
cd /path/to/project
./yii schemadump <existing_database_name>
```

Example output:

```
// user
$this->createTable('{{%user}}', [
    'id' => Schema::TYPE_PK . " COMMENT '主キー'",
    'username' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT 'ユーザ名'",
    'email' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT 'メールアドレス'",
    'password' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT 'パスワード'",
], $this->tableOptions);
```

Copy the output code and paste it into a migration file.

## Commands

Generates the 'createTable' code. (default)

```
./yii schemadump <existing_database_name>
./yii schemadump/create <existing_database_name>
```

Generates the 'dropTable' code.

```
./yii schemadump/drop <existing_database_name>
```

Useful commands (for OS X user):

```
./yii schemadump <existing_database_name> | pbcopy
./yii schemadump/drop <existing_database_name> | pbcopy
```

Check help.

```
./yii help schemadump
```

## Supports

- Types
- Size
- Unsigned
- NOT NULL
- DEFAULT value
- COMMENT
- Foreign key
- Composite primary keys
- Primary key without AUTO_INCREMENT
- ENUM type (for MySQL)
