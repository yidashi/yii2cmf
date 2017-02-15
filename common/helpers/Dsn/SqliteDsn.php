<?php

namespace common\helpers\Dsn;

use common\helpers\Dsn;

/**
 * SqliteDsn
 *
 */
class SqliteDsn extends Dsn
{

    protected function parseDsn()
    {
        $this->parseDsn['database'] = $this->parse_url['path'];
        return true;
    }

}