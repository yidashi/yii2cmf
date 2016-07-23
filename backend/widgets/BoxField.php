<?php
namespace backend\widgets;

use yii\widgets\ActiveField;
use yii\helpers\Html;

class BoxField extends ActiveField
{

    public $collapsed = false;

    public $options = [
        'class' => 'box box-solid'
    ];

    public $headerOptions = [
        'class' => 'box-header with-border'
    ];

    public $bodyOptions = [
        'class' => 'box-body'
    ];

    public $footerOptions = [
        'class' => 'box-footer small'
    ];

    public $template = "{header}\n{body}\n{footer}";

    public function render($content = null)
    {
        if ($content === null) {
            if (! isset($this->parts['{body}'])) {
                $this->body();
            }
            if (! isset($this->parts['{header}'])) {
                $this->header();
            }
            if (! isset($this->parts['{footer}'])) {
                $this->footer();
            }
            $content = strtr($this->template, $this->parts);
        } elseif (! is_string($content)) {
            $content = call_user_func($content, $this);
        }

        return $this->begin() . "\n" . $content . "\n" . $this->end();
    }

    public function begin()
    {

        if($this->collapsed == true)
        {
            $this->options["class"] .= " collapsed-box";
        }

        return parent::begin();
    }

    public function header($title = null, $options = [])
    {
        if ($title === false) { // 为false则不显示
            $this->parts['{header}'] = '';
            return $this;
        }

        $options = array_merge($this->headerOptions, $options);

        $attribute = Html::getAttributeName($this->attribute);

        if ($title !== null) {
            $options['title'] = $title;
        }

        $title = isset($options['title']) ? $options['title'] : Html::encode($this->model->getAttributeLabel($attribute));



        if($this->collapsed == true)
        {
            $faclass= "fa-plus";
        }
        else
        {
            $faclass= "fa-minus";
        }



        $content = '<h3 class="box-title">' . $title . '</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa '.$faclass.'"></i></button>
                  </div>';

        $this->parts['{header}'] = Html::tag("div", $content, $options);

        return $this;
    }

    public function body($options = [])
    {
        $options = array_merge($this->bodyOptions, $options);

        if (! isset($this->parts['{input}'])) {
            $this->textInput();
        }

        $content = $this->parts['{input}'];
        $this->parts['{body}'] = Html::tag("div", $content, $options);

        return $this;
    }

    public function footer($options = [])
    {
        if (isset($options["hidden"])) {
            $this->parts['{footer}'] = '';
            return $this;
        }

        $options = array_merge($this->footerOptions, $options);

        if (! isset($this->parts['{error}'])) {
            $this->error();
        }
        $error = $this->parts['{error}'];

        if (! isset($this->parts['{hint}'])) {
            $this->hint(null);
        }
        $hint = $this->parts['{hint}'];

        $this->parts['{footer}'] = Html::tag("div", $hint . "\n" . $error, $options);

        return $this;
    }
}

?>