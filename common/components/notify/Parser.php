<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/6/22
 * Time: 下午4:53
 */

namespace common\components\notify;


use yii\base\Object;
use yii\helpers\StringHelper;

class Parser extends Object
{
    /**
     * Regex to get values between curly bracket {$value}.
     */
    const RULE = '/\{(.+?)(?:\{(.+)\})?\}/';

    public function parse($item)
    {
        $body = $item['text'];
        $specialValues = $this->getValues($body);

        if (count($specialValues) > 0) {
            $specialValues = array_filter($specialValues, function ($value) {
                return StringHelper::startsWith($value, 'extra.') || StringHelper::startsWith($value, 'to.') || StringHelper::startsWith($value, 'from.');
            });
            foreach ($specialValues as $replacer) {
                $replace = array_get($item, $replacer);
                $body = $this->replaceBody($body, $replace, $replacer);
            }
        }

        return $body;
    }


    /**
     * Get the values between {}
     * and return an array of it.
     *
     * @param $body
     * @return mixed
     */
    protected function getValues($body)
    {
        $values = [];
        preg_match_all(self::RULE, $body, $values);

        return $values[1];
    }

    /**
     * Replace body of the category.
     *
     * @param $body
     * @param $replacer
     * @param $valueMatch
     * @return mixed
     */
    protected function replaceBody($body, $valueMatch, $replacer)
    {
        $body = str_replace('{'.$replacer.'}', $valueMatch, $body);

        return $body;
    }
}