<?php

/*
 * This file is part of yii2-schemadump.
 *
 * (c) Tomoki Morita <tmsongbooks215@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace jamband\schemadump;

/**
 * Migration class file.
 */
class Migration extends \yii\db\Migration
{
    /**
     * @var string the table options
     */
    protected $tableOptions = '';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->db->driverName === 'mysql') {
            $this->tableOptions = 'ENGINE=InnoDB CHARACTER SET=utf8 COLLATE=utf8_unicode_ci';
        }
    }
}
