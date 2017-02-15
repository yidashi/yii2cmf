<?php

namespace common\helpers\Dsn;

use common\helpers\Dsn;

/**
 * SqlsrvDsn
 *
 */
class SqlsrvDsn extends Dsn
{

    protected $defaultHostKey = 'Server';
    protected $defaultDatabaseKey = 'Database';

}