<?php

namespace common\models;

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
    const TYPE_ARRAY = 2;
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
            [['name', 'value', 'desc', 'type'], 'required'],
            [['name'], 'string', 'max' => 20],
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
        ];
    }

    public static function getTypeList()
    {
        return self::get('CONFIG_TYPE_LIST');
    }
    public function getInputType()
    {
        $inputType = '';
        switch ($this->type) {
            case 1:
                $inputType = [
                    'name' => 'textInput',
                    'params' => [],
                ];
                break;
            case 2:
                $inputType = [
                    'name' => 'textarea',
                    'params' => [
                        ['rows' => 5],
                    ],
                ];
                break;
            case 3:
                $inputType = [
                    'name' => 'dropDownList',
                    'params' => [
                        'items' => $this->parseExtra($this->extra),
                    ],
                ];
                break;
            case 4:
                $inputType = [
                    'name' => 'widget',
                    'params' => [
                        '\yidashi\webuploader\Webuploader',
                    ],
                ];
                break;
            case 5:
                $inputType = [
                    'name' => 'textarea',
                    'params' => [
                        ['rows' => 5],
                    ],
                ];
                break;
        }

        return $inputType;
    }
    public static function get($name, $default = '')
    {
        $config = static::getDb()->cache(function ($db) use ($name) {
            return static::find()->where(['name' => $name])->one();
        }, 60);
        if (!empty($config)) {
            return self::_parse($config->type, $config->value);
        } else {
            return $default;
        }
    }

    private static function _parse($type, $value)
    {
        switch ($type) {
            case self::TYPE_ARRAY:
                $return = [];
                foreach (explode("\r\n", $value) as $val) {
                    if (strpos($val, ':') !== false) {
                        list($k, $v) = explode(':', $val);
                        $return[$k] = $v;
                    } else {
                        $return[] = $val;
                    }
                }
                $value = $return;
                break;
        }

        return $value;
    }

    /**
     * 分析枚举类型.
     *
     * @param $string
     */
    public function parseExtra($value)
    {
        $return = [];
        foreach (explode("\r\n", $value) as $val) {
            if (strpos($val, ':') !== false) {
                list($k, $v) = explode(':', $val);
                $return[$k] = $v;
            } else {
                $return[] = $val;
            }
        }

        return $return;
    }
}
