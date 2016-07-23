<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin\actions;

use Yii;

/**
 * Restore actions performs restoration of the "soft" deleted record.
 *
 * @see https://github.com/yii2tech/ar-softdelete
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class Restore extends Action
{
    /**
     * @var string|array|null flash message to be set on success.
     * @see Action::setFlash() for details on how setup flash.
     */
    public $flash;


    /**
     * Deletes a model.
     * @param mixed $id id of the model to be deleted.
     * @return mixed response.
     */
    public function run($id)
    {
        $model = $this->findModel($id);

        $model->restore();

        $this->setFlash($this->flash, ['id' => $id, 'model' => $model]);

        return $this->controller->redirect($this->createReturnUrl('view', $model));
    }
}