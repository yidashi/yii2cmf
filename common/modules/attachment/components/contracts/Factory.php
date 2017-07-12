<?php

namespace common\modules\attachment\components\contracts;

interface Factory
{
    /**
     * Get a filesystem implementation.
     *
     * @param  string  $name
     * @return \common\modules\attachment\components\contracts\Filesystem
     */
    public function disk($name = null);
}
