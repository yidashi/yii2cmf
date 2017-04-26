<?php

namespace common\helpers;

use yii\base\Object;

class Dsn extends Object {

    public $dsn;

    public $sheme;

    protected $defaultHostKey = 'host';
    protected $defaultDatabaseKey = 'dbname';

    protected $parseDsn = [
        'host' => null,
        'port' => null,
        'database' => null
    ];

    protected $path;

    protected $parse_url;

    protected $defaultPort;

    public function init()
    {
        parent::init();
        if(is_null($this->parse_url))
            $this->parse_url = parse_url($this->dsn);
        $this->path = $this->parse_url['path'];
        $this->parseDsn();
    }

    public static function parse($dsn)
    {
        $scheme = substr($dsn, 0, strpos($dsn, ':'));
        if (strpos($dsn, '+')) {
            $dsn = substr($dsn, 0, strpos($dsn, '+'));
        }

        if (!$dsn) {
            throw new \Exception(sprintf('The url \'%s\' could not be parsed', $dsn));
        }
        $className  = __NAMESPACE__ . '\\Dsn\\' . ucfirst($scheme) . 'Dsn';
        return new $className([
            'dsn' => $dsn,
            'sheme' => $scheme
        ]);
    }

    protected function parseDsn() {
        $data = $this->path;
        $array = array_map(
            function ($_) {
                return explode('=', $_);
            },
            explode(';', $data)
        );
        if (count($array) > 1) {
            $parseArray = [];
            foreach ($array as $index => $element) {
                $parseArray[$element[0]] = $element[1];
            }
            $this->parseDsn = [
                'host' => $parseArray[$this->defaultHostKey],
                'port' => $parseArray['port'] ? $parseArray['port'] : $this->defaultPort,
                'database' => $parseArray[$this->defaultDatabaseKey]
            ];
            return true;
        }
        $this->parseDsn = [
            'host' => $this->parse_url[$this->defaultHostKey],
            'port' => $this->parse_url['port'] ? $this->parse_url['port'] : $this->defaultPort,
            'database' => basename($this->dsn)
        ];
        return true;
    }

    public function getParseDsn() {
        return $this->parseDsn;
    }

    public function getDatabase() {
        return $this->parseDsn['database'];
    }

    public function getHost() {
        return $this->parseDsn['host'];
    }

    public function getPort() {
        return $this->parseDsn['port'];
    }

}