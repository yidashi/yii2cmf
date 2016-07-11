<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/11
 * Time: 下午3:11
 */

namespace backend\models;


use yii\base\Model;

class PluginsConfig extends Model
{
    public $name;
    public $value;
    public $extra;
    public $desc;
    public $type;

    public function rules()
    {
        return [
            [['name', 'extra', 'desc', 'type'], 'safe', 'on' => 'init'],
            ['value', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => '配置名',
            'value' => '配置值',
            'desc' => '配置描述',
            'extra' => '配置扩展'
        ];
    }

    /**
     * @return array|string
     */
    public function getInputType()
    {
        $inputType = '';
        switch ($this['type']) {
            case 'text': // 文本框
                $inputType = [
                    'name' => 'textInput',
                    'params' => [],
                ];
                break;
            case 'password': // 密码框
                $inputType = [
                    'name' => 'passwordInput',
                    'params' => [],
                ];
                break;
            case 'textarea': // 多行文本框
                $inputType = [
                    'name' => 'textarea',
                    'params' => [
                        ['rows' => 5],
                    ],
                ];
                break;
            case 'select': // 下拉
                $inputType = [
                    'name' => 'dropDownList',
                    'params' => [
                        'items' => $this->parseExtra($this['extra']),
                    ],
                ];
                break;
            case 'checkbox': // 多选
                $inputType = [
                    'name' => 'checkboxList',
                    'params' => [
                        'items' => $this->parseExtra($this['extra']),
                    ],
                ];
                break;
            case 'radio': // 单选
                $inputType = [
                    'name' => 'radioList',
                    'params' => [
                        'items' => $this->parseExtra($this['extra']),
                    ],
                ];
                break;
            case 'image': // 图片
                $inputType = [
                    'name' => 'widget',
                    'params' => [
                        '\yidashi\webuploader\Webuploader',
                        ['options' => ['boxId' => 'config' . $model['name']]]// 保证多个上传框ID不同
                    ],
                ];
                break;
            case 'editor': // 编辑器
                $inputType = [
                    'name' => 'widget',
                    'params' => [
                        '\kucha\ueditor\UEditor',
                    ],
                ];
                break;
        }
        return $inputType;
    }
    /**
     * 分析枚举类型.
     * @param $value string
     * @return array
     */
    public function parseExtra($value)
    {
        $return = [];
        if (is_array($value)) {
            return $value;
        }
        foreach (explode("\r\n", $value) as $val) {
            if (strpos($val, '=>') !== false) {
                list($k, $v) = explode('=>', $val);
                $return[$k] = $v;
            } else {
                $return[] = $val;
            }
        }
        return $return;
    }
}