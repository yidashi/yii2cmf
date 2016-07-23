<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/22
 * Time: 下午12:08
 */

namespace backend\widgets;


class Editable extends \dosamigos\editable\Editable
{
    public function init()
    {
        parent::init();
        if ($this->type == 'boolean') {
            $this->type = 'select';
            $source = [
                [
                    'value' => 0,
                    'text' => '否'
                ],
                [
                    'value' => 1,
                    'text' => '是'
                ]
            ];
            $this->clientOptions['source'] = $source;
        }
    }
}