<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin\actions;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;

/**
 * Index action displays the models listing with search support.
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class Index extends Action
{
    /**
     * @var callable a PHP callable that will be called to create the new search model.
     * If not set, [[newSearchModel()]] will be used instead.
     * The signature of the callable should be:
     *
     * ```php
     * function ($action) {
     *     // $action is the action object currently running
     * }
     * ```
     *
     * The callable should return the new model instance.
     */
    public $newSearchModel;
    /**
     * @var callable a PHP callable that will be called to prepare a data provider that
     * should return a collection of the models. If not set, [[prepareDataProvider()]] will be used instead.
     * The signature of the callable should be:
     *
     * ```php
     * function ($searchModel, $action) {
     *     // $searchModel the search model instance
     *     // $action is the action object currently running
     * }
     * ```
     *
     * The callable should return an instance of [[\yii\data\DataProviderInterface]].
     */
    public $prepareDataProvider;
    /**
     * @var string name of the view, which should be rendered
     */
    public $view = 'index';


    /**
     * Creates new search model instance.
     * @return Model new model instance.
     * @throws InvalidConfigException on invalid configuration.
     */
    public function newSearchModel()
    {
        if ($this->newSearchModel !== null) {
            return call_user_func($this->newSearchModel, $this);
        } elseif ($this->controller->hasMethod('newSearchModel')) {
            return call_user_func([$this->controller, 'newSearchModel'], $this);
        } else {
            throw new InvalidConfigException('Either "' . get_class($this) . '::findModel" must be set or controller must declare method "findModel()".');
        }
    }

    /**
     * Displays models list.
     * @return mixed response.
     */
    public function run()
    {
        $searchModel = $this->newSearchModel();
        $dataProvider = $this->prepareDataProvider($searchModel);

        $this->setReturnAction();

        return $this->controller->render($this->view, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Prepares the data provider that should return the requested collection of the models.
     * @param Model $searchModel search model instance.
     * @return \yii\data\DataProviderInterface data provider instance.
     */
    protected function prepareDataProvider($searchModel)
    {
        if ($this->prepareDataProvider !== null) {
            return call_user_func($this->prepareDataProvider, $searchModel, $this);
        }

        return $searchModel->search(Yii::$app->request->queryParams);
    }
}