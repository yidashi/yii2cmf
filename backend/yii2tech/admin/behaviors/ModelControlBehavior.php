<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\ActiveRecordInterface;
use yii\web\NotFoundHttpException;

/**
 * ModelControlBehavior
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class ModelControlBehavior extends Behavior
{
    /**
     * @var string the model class name. This property must be set.
     * The model class must implement [[ActiveRecordInterface]].
     */
    public $modelClass;
    /**
     * @var string class name of the model which should be used as search model.
     * If not set it will be composed using [[modelClass]].
     */
    public $searchModelClass;


    /**
     * Returns the data model based on the primary key given.
     * If the data model is not found, a 404 HTTP exception will be raised.
     * @param string $id the ID of the model to be loaded. If the model has a composite primary key,
     * the ID must be a string of the primary key values separated by commas.
     * The order of the primary key values should follow that returned by the `primaryKey()` method
     * of the model.
     * @return ActiveRecordInterface|Model the model found
     * @throws NotFoundHttpException if the model cannot be found
     * @throws InvalidConfigException on invalid configuration
     */
    public function findModel($id)
    {
        if ($this->modelClass === null) {
            throw new InvalidConfigException('"' . get_class($this) . '::modelClass" must be set.');
        }

        /* @var $modelClass ActiveRecordInterface */
        $modelClass = $this->modelClass;
        $keys = $modelClass::primaryKey();
        if (count($keys) > 1) {
            $values = explode(',', $id);
            if (count($keys) === count($values)) {
                $model = $modelClass::findOne(array_combine($keys, $values));
            }
        } elseif ($id !== null) {
            $model = $modelClass::findOne($id);
        }

        if (isset($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii2tech-admin', "Object not found: {id}", ['id' => $id]));
        }
    }

    /**
     * Creates new model instance.
     * @return ActiveRecordInterface|Model new model instance.
     * @throws InvalidConfigException on invalid configuration.
     */
    public function newModel()
    {
        if ($this->modelClass === null) {
            throw new InvalidConfigException('"' . get_class($this) . '::modelClass" must be set.');
        }
        $modelClass = $this->modelClass;
        return new $modelClass();
    }

    /**
     * Creates new model instance.
     * @return Model new model instance.
     * @throws InvalidConfigException on invalid configuration.
     */
    public function newSearchModel()
    {
        $modelClass = $this->searchModelClass;
        if ($modelClass === null) {
            if ($this->modelClass === null) {
                throw new InvalidConfigException('Either "' . get_class($this) . '::searchModelClass" or "' . get_class($this) . '::modelClass" must be set.');
            }
            $modelClass = $this->modelClass . 'Search';
        }

        return new $modelClass();
    }
}