<?php
namespace yii\debug\actions\db;

use yii\base\Action;
use yii\debug\panels\DbPanel;
use yii\web\HttpException;

/**
 * ExplainAction provides EXPLAIN information for SQL queries
 */
class ExplainAction extends Action
{
    /**
     * @var DbPanel
     */
    public $panel;

    public function run($seq, $tag)
    {
        $this->controller->loadData($tag);

        $timings = $this->panel->calculateTimings();

        if (!isset($timings[$seq])) {
            throw new HttpException(404, 'Log message not found.');
        }

        $query = $timings[$seq]['info'];

        $result = $this->panel->getDb()->createCommand('EXPLAIN ' . $query)->queryOne();

        if (isset($result['id'])) {
            unset($result['id']);
        }

        $output = [];
        foreach ($result as $key => $value) {
            if ($value) {
                $output[] = sprintf('<b>%s</b>: %s', $key, $value);
            }
        }

        return implode('<br/>', $output);
    }
}
