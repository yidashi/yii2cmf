<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin\actions;

/**
 * View action displays an existing model.
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class View extends Action
{
    /**
     * @var string name of the view, which should be rendered
     */
    public $view = 'view';


    /**
     * Displays a model.
     * @param string $id the primary key of the model.
     * @return mixed response.
     */
    public function run($id)
    {
        $model = $this->findModel($id);

        $this->setReturnAction();

        return $this->controller->render($this->view, [
            'model' => $model,
        ]);
    }
}