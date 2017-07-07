<?php
namespace common\widgets;

class Alert extends \yii\bootstrap\Widget
{
    /**
     * @var array the alert types configuration for the flash messages.
     *            This array is setup as $key => $value, where:
     *            - $key is the name of the session flash variable
     *            - $value is the bootstrap alert type (i.e. danger, success, info, warning)
     */
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
$.modal.{$type}('{$message}');
js
                    );
                }
                $session->removeFlash($type);
            }
        }


    }
}
