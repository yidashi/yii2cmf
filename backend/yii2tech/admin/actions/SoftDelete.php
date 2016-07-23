<?php
/**
 * @link https://github.com/yii2tech
 * @copyright Copyright (c) 2015 Yii2tech
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yii2tech\admin\actions;

use Yii;

/**
 * SoftDelete action performs the "soft" deleting of the existing record.
 * This action supports [yii2tech/ar-softdelete](https://github.com/yii2tech/ar-softdelete) extension.
 *
 * @see https://github.com/yii2tech/ar-softdelete
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 1.0
 */
class SoftDelete extends Delete
{
    /**
     * Deletes a model.
     * @param mixed $id id of the model to be deleted.
     * @return mixed response.
     */
    public function run($id)
    {
        $model = $this->findModel($id);

        $model->softDelete();

        $this->setFlash($this->flash, ['id' => $id, 'model' => $model]);

        return $this->controller->redirect($this->createReturnUrl('index', $model));
    }
}