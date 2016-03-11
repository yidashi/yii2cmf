<?php
/**
 * @link http://www.yiiframework.com/
 *
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace common\widgets;
use yii\helpers\Html;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:.
 *
 * ```php
 * \Yii::$app->session->setFlash('error', 'This is the message');
 * \Yii::$app->session->setFlash('success', 'This is the message');
 * \Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * \Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class AlertPlus extends \yii\bootstrap\Widget
{
    /**
     * @var array the alert types configuration for the flash messages.
     *            This array is setup as $key => $value, where:
     *            - $key is the name of the session flash variable
     *            - $value is the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public $alertTypes = [
        'error' => 'alert-danger',
        'danger' => 'alert-danger',
        'success' => 'alert-success',
        'info' => 'alert-info',
        'warning' => 'alert-warning',
    ];

    /**
     * @var array the options for rendering the close button tag.
     */
    public $closeButton = [];

    public function init()
    {
        parent::init();

        $session = \Yii::$app->session;
        $flashes = $session->getAllFlashes();
        $appendCss = isset($this->options['class']) ? ' '.$this->options['class'] : '';
        $data = '';
        $this->options['id'] = 'top-alert';
        if (!empty($flashes)) {
            $data = current($flashes);
            $type = array_search($data, $flashes);
            if (isset($this->alertTypes[$type])) {
                /* initialize css class for each alert box */
                $this->options['class'] = $this->alertTypes[$type].$appendCss;
                $session->removeFlash($type);
            }
        } else {
            $this->options['style'] = 'display:none';
        }
        echo \yii\bootstrap\Alert::widget([
            'body' => Html::tag('div',$data ?: '', ['class' => 'alert-content']),
            'closeButton' => $this->closeButton,
            'options' => $this->options,
        ]);
    }
}

/*
<?= \yii\bootstrap\Alert::widget([
            'id' => 'top-alert',
            'body' => \yii\helpers\Html::tag('div', Yii::$app->session->getAllFlashes() ? current(Yii::$app->session->getAllFlashes()) : '', ['class' => 'alert-content']),
            'options' => Yii::$app->session->getAllFlashes() ? ['class' => 'alert-' . array_search(current(Yii::$app->session->getAllFlashes()), Yii::$app->session->getAllFlashes())] : ['style' => 'display:none']
        ])?>
 */