<?php
namespace common\widgets;

class Alert extends \yii\bootstrap\Widget
{

    public $alertTypes = [
        'success' => 1,
        'error' => 0
    ];

    public function init()
    {
        parent::init();

        $session = \Yii::$app->session;
        $flashes = $session->getAllFlashes();

        foreach ($flashes as $type => $data) {
            if (isset($this->alertTypes[$type])) {
                $data = (array) $data;
                foreach ($data as $i => $message) {
                    $this->view->registerJs(<<<js
$.modal.msg('{$message}', {$this->alertTypes[$type]});
js
                    );
                }
                $session->removeFlash($type);
            }
        }


    }
}
