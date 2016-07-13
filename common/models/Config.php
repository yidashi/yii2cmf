<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\caching\DbDependency;

/**
 * This is the model class for table "{{%config}}".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string $desc
 */
class Config extends \yii\db\ActiveRecord
{
    const TYPE_ARRAY = 'array';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%config}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'desc', 'type'], 'required'],
            [['name', 'group'], 'string', 'max' => 50],
            ['type', 'in', 'range' => array_keys(self::getTypeList())],
            [['value', 'desc', 'extra'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '配置名',
            'value' => '配置值',
            'desc' => '配置描述',
            'type' => '配置类型',
            'extra' => '配置项',
            'group' => '分组',
        ];
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public static function getTypeList()
    {
        return \Yii::$app->config->get('CONFIG_TYPE_LIST');
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
            case 'array': // 数组
                $inputType = [
                    'name' => 'textarea',
                    'params' => [
                        ['rows' => 5],
                    ],
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
                        ['options' => ['boxId' => 'config' . $this['name']]]// 保证多个上传框ID不同
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
