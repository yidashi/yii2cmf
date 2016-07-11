<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/11
 * Time: 上午11:47
 */

namespace backend\helpers;


class Config
{
    public static function getInputType($model)
    {
        $inputType = '';
        switch ($model['type']) {
            case 'text':
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
            case 'select':
                $inputType = [
                    'name' => 'dropDownList',
                    'params' => [
                        'items' => self::parseExtra($model['extra']),
                    ],
                ];
                break;
            case 'checkbox':
                $inputType = [
                    'name' => 'checkboxList',
                    'params' => [
                        'items' => self::parseExtra($model['extra']),
                    ],
                ];
                break;
            case 'image':
                $inputType = [
                    'name' => 'widget',
                    'params' => [
                        '\yidashi\webuploader\Webuploader',
                        ['options' => ['boxId' => 'config' . $model['name']]]// 保证多个上传框ID不同
                    ],
                ];
                break;
            case 'editor':
                $inputType = [
                    'name' => 'widget',
                    'params' => [
                        '\kucha\ueditor\UEditor',
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
    /**
     * 分析枚举类型.
     * @param $value string
     * @return array
     */
    public static function parseExtra($value)
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