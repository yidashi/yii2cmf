<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\sphinx;

use yii\base\InvalidConfigException;
use yii\test\BaseActiveFixture;

/**
 * ActiveFixture represents a fixture backed up by a [[modelClass|ActiveRecord class]] or a [[indexName|Sphinx index]].
 *
 * Either [[modelClass]] or [[indexName]] must be set. You should also provide fixture data in the file
 * specified by [[dataFile]] or overriding [[getData()]] if you want to use code to generate the fixture data.
 *
 * When the fixture is being loaded, it will first call [[resetIndex()]] to remove any existing data in the index.
 * It will then populate the index with the data returned by [[getData()]].
 *
 * After the fixture is loaded, you can access the loaded data via the [[data]] property. If you set [[modelClass]],
 * you will also be able to retrieve an instance of [[modelClass]] with the populated data via [[getModel()]].
 *
 * Note: only runtime indexes are supported.
 *
 * @property IndexSchema $indexSchema The schema information of the Sphinx index associated with this
 * fixture. This property is read-only.
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 2.0.4
 */
class ActiveFixture extends BaseActiveFixture
{
    /**
     * @var Connection|array|string the Sphinx connection object or the application component ID of the Sphinx connection
     * or a configuration array for creating the object.
     */
    public $db = 'sphinx';
    /**
     * @var string the name of the Sphinx index that this fixture is about. If this property is not set,
     * the index name will be determined via [[modelClass]].
     * @see modelClass
     */
    public $indexName;
    /**
     * @var string|boolean the file path or path alias of the data file that contains the fixture data
     * to be returned by [[getData()]]. If this is not set, it will default to `FixturePath/data/IndexName.php`,
     * where `FixturePath` stands for the directory containing this fixture class, and `IndexName` stands for the
     * name of the index associated with this fixture. You can set this property to be false to prevent loading any data.
     */
    public $dataFile;

    /**
     * @var IndexSchema the schema for the index associated with this fixture
     */
    private $_index;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!isset($this->modelClass) && !isset($this->indexName)) {
            throw new InvalidConfigException('Either "modelClass" or "indexName" must be set.');
        }
    }

    /**
     * Loads the fixture.
     *
     * The default implementation will first clean up the table by calling [[resetIndex()]].
     * It will then populate the index with the data returned by [[getData()]].
     *
     * If you override this method, you should consider calling the parent implementation
     * so that the data returned by [[getData()]] can be populated into the index.
     */
    public function load()
    {
        $this->resetIndex();
        $this->data = [];
        $index = $this->getIndexSchema();
        foreach ($this->getData() as $alias => $row) {
            $this->db->createCommand()->insert($index->name, $row)->execute();
            $this->data[$alias] = $row;
        }
    }

    /**
     * Returns the fixture data.
     *
     * The default implementation will try to return the fixture data by including the external file specified by [[dataFile]].
     * The file should return an array of data rows (column name => column value), each corresponding to a row in the index.
     *
     * If the data file does not exist, an empty array will be returned.
     *
     * @return array the data rows to be inserted into the index.
     */
    protected function getData()
    {
        if ($this->dataFile === null) {
            $class = new \ReflectionClass($this);
            $dataFile = dirname($class->getFileName()) . '/data/' . $this->getIndexSchema()->name . '.php';
            return is_file($dataFile) ? require($dataFile) : [];
        } else {
            return parent::getData();
        }
    }

    /**
     * Truncates the specified index removing all existing data from it.
     * This method is called before populating fixture data into the index associated with this fixture.
     */
    protected function resetIndex()
    {
        $index = $this->getIndexSchema();
        $this->db->createCommand()->truncateIndex($index->name)->execute();
    }

    /**
     * @return IndexSchema the schema information of the database table associated with this fixture.
     * @throws \yii\base\InvalidConfigException if the index does not exist or not a runtime type
     */
    public function getIndexSchema()
    {
        if ($this->_index !== null) {
            return $this->_index;
        }

        $db = $this->db;
        $indexName = $this->indexName;
        if ($indexName === null) {
            /* @var $modelClass ActiveRecord */
            $modelClass = $this->modelClass;
            $indexName = $modelClass::indexName();
        }

        $this->_index = $db->getSchema()->getIndexSchema($indexName);
        if ($this->_index === null) {
            throw new InvalidConfigException("Index does not exist: {$indexName}");
        }
        if (!$this->_index->isRuntime) {
            throw new InvalidConfigException("'{$indexName}' is not a runtime index. Only runtime indexes are supported.'");
        }

        return $this->_index;
    }
}
