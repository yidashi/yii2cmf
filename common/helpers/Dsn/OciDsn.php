<?php

namespace common\helpers\Dsn;

use common\helpers\Dsn;

/**
 * OciDsn
 *
 */
class OciDsn extends Dsn
{

    public function init()
    {
        $this->dsn = str_replace("dbname=", "", $this->dsn);
        parent::init();
    }

}