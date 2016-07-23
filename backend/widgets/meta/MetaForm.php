<?php
namespace backend\widgets\meta;

use yii\widgets\InputWidget;
use yii\helpers\Html;

class MetaForm extends InputWidget
{

    public function init()
    {
        parent::init();

        if ($this->hasModel()) {
            $this->value = $this->model->getMetaModel();
        }
    }

    public function run()
    {
        return $this->render('meta_form', [
            'model' => $this->value
        ]);
    }
}