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

use Yii;
use yii\console\Controller;
use yii\db\Connection;
use yii\di\Instance;

/**
 * Generate the migration code from database schema.
 */
class SchemaDumpController extends Controller
{
    /**
     * @inheritdoc
     */
    public $defaultAction = 'create';

    /**
     * @var string a migration table name
     */
    public $migrationTable = 'migration';

    /**
     * @var Connection|string the DB connection object or the application component ID of the DB connection.
     */
    public $db = 'db';

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        return array_merge(parent::options($actionID), [
            'migrationTable',
            'db',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $this->db = Instance::ensure($this->db, Connection::className());
            return true;
        }
        return false;
    }

    /**
     * Generates the 'createTable' code.
     * @param string $schema the schema of the tables. Defaults to empty string, meaning the current or default schema name.
     * @return integer the status of the action execution
     */
    public function actionCreate($schema = '')
    {
        $offset = 0;
        $stdout = '';

        foreach ($this->db->schema->getTableSchemas($schema) as $table) {
            if ($table->name === $this->migrationTable) {
                continue;
            }
            $stdout .= "// $table->name\n";
            $stdout .= "\$this->createTable('{{%$table->name}}', [\n";
            $stdout .= $this->getColumnsDefinition($table->columns);
            $stdout .= $this->getPrimaryKeyDefinition($table->primaryKey, $stdout, $offset);
            $stdout .= "], \$this->tableOptions);\n\n";

            $offset = mb_strlen($stdout, Yii::$app->charset);
        }
        foreach ($this->db->schema->getTableSchemas($schema) as $table) {
            $stdout .= $this->getForeignKeyDefinition($table);
        }
        $this->stdout(strtr($stdout, [
            ' . ""' => '',
            '" . "' => '',
        ]));
    }

    /**
     * Generates the 'dropTable' code.
     * @param string $schema the schema of the tables. Defaults to empty string, meaning the current or default schema name.
     * @return integer the status of the action execution
     */
    public function actionDrop($schema = '')
    {
        $stdout = '';

        foreach ($this->db->schema->getTableSchemas($schema) as $table) {
            if ($table->name === $this->migrationTable) {
                continue;
            }
            $stdout .= "\$this->dropTable('{{%$table->name}}');";

            if (!empty($table->foreignKeys)) {
                $stdout .= " // fk: ";

                foreach ($table->foreignKeys as $fk) {
                    foreach ($fk as $k => $v) {
                        if ($k === 0) {
                            continue;
                        }
                        $stdout .= "$k, ";
                    }
                }
                $stdout = rtrim($stdout, ', ');
            }
            $stdout .= "\n";
        }
        $this->stdout($stdout);
    }

    /**
     * Returns the constant strings of yii\db\Schema class. e.g. Schema::TYPE_PK
     * @param string $type the column type
     * @return string
     */
    private function type($type)
    {
        $class = new \ReflectionClass('yii\db\Schema');
        return $class->getShortName() . '::' . implode(array_keys($class->getConstants(), $type));
    }

    /**
     * Returns the columns definition.
     * @param array $columns
     * @return string
     */
    private function getColumnsDefinition($columns)
    {
        $definition = '';
        $template = "    '<columnName>' => <schemaType> . \"<otherDefinition>\",\n";

        foreach ($columns as $column) {
            $definition .= strtr($template, [
                '<columnName>' => $column->name,
                '<schemaType>' => $this->getSchemaType($column),
                '<otherDefinition>' => $this->otherDefinition($column),
            ]);
        }
        return $definition;
    }

    /**
     * Returns the primary key definition.
     * @param array $pk
     * @param string $stdout
     * @param integer $offset
     * @return string|null the primary key definition or null
     */
    private function getPrimaryKeyDefinition($pk, $stdout, $offset)
    {
        if (!empty($pk)) {
            // Composite primary keys
            if (count($pk) >= 2) {
                $compositePk = implode(', ', $pk);
                return "    'PRIMARY KEY ($compositePk)',\n";
            }
            // Primary key not an auto-increment
            if (
                false === strpos($stdout, $this->type('pk'), $offset) &&
                false === strpos($stdout, $this->type('bigpk'), $offset)
            ) {
                return "    'PRIMARY KEY ({$pk[0]})',\n";
            }
        }
    }

    /**
     * Returns the schema type.
     * @param ColumnSchema[] $column
     * @return string the schema type
     */
    private function getSchemaType($column)
    {
        if ($column->autoIncrement && !$column->unsigned) {
            return ($column->type === 'bigint') ? $this->type('bigpk') : $this->type('pk');
        }
        if ($column->dbType === 'tinyint(1)') {
            return $this->type('boolean');
        }
        if ($column->enumValues !== null) {
            return "\"$column->dbType\"";
        }

        return $this->type($column->type);
    }

    /**
     * Returns the other definition.
     * @param ColumnSchema[] $column
     * @return string the other definition
     */
    private function otherDefinition($column)
    {
        $definition = '';

        // size
        if ($column->scale !== null && $column->scale > 0) {
            $definition .= "($column->precision,$column->scale)";

        } elseif (
            ($column->size !== null && !$column->autoIncrement && $column->dbType !== 'tinyint(1)') ||
            ($column->size !== null && $column->unsigned)
        ) {
            $definition .= "($column->size)";
        }

        // unsigned
        if ($column->unsigned) {
            $definition .= ' UNSIGNED';
        }

        // null, auto-increment
        if ($column->allowNull) {
            $definition .= ' NULL';

        } elseif (!$column->autoIncrement) {
            $definition .= ' NOT NULL';

        } elseif ($column->autoIncrement && $column->unsigned) {
            $definition .= ' NOT NULL AUTO_INCREMENT';
        }

        // default value
        if ($column->defaultValue instanceof \yii\db\Expression) {
            $definition .= " DEFAULT $column->defaultValue";

        } elseif ($column->defaultValue !== null) {
            $definition .= " DEFAULT '".addslashes($column->defaultValue)."'";
        }

        // comment
        if ($column->comment !== '') {
            $definition .= " COMMENT '".addslashes($column->comment)."'";
        }

        return $definition;
    }

    /**
     * Returns the foreign key definition.
     * @param TableSchema[] $table
     * @return string|null foreign key definition or null
     */
    private function getForeignKeyDefinition($table)
    {
        if (empty($table->foreignKeys)) {
            return;
        }
        $definition = "// fk: $table->name\n";

        foreach ($table->foreignKeys as $fk) {
            $refTable = '';
            $refColumns = '';
            $columns = '';

            foreach ($fk as $k => $v) {
                if ($k === 0) {
                    $refTable = $v;
                } else {
                    $columns = $k;
                    $refColumns = $v;
                }
            }
            $template = "\$this->addForeignKey('<name>', '{{%<table>}}', '<columns>', '{{%<refTable>}}', '<refColumns>');\n";
            $definition .= strtr($template, [
                '<name>' => "fk_{$table->name}_{$columns}",
                '<table>' => $table->name,
                '<columns>' => $columns,
                '<refTable>' => $refTable,
                '<refColumns>' => $refColumns,
            ]);
        }
        return "$definition\n";
    }
}
