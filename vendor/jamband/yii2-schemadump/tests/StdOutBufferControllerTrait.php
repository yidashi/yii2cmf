<?php

namespace jamband\schemadump\tests;

/**
 * StdOutBufferTrait trait file.
 */
trait StdOutBufferControllerTrait
{
    private $stdOutBuffer = '';

    /**
     * @param string $string
     */
    public function stdout($string)
    {
        $this->stdOutBuffer .= $string;
    }

    /**
     * @return string
     */
    public function flushStdOutBuffer()
    {
        $result = $this->stdOutBuffer;
        $this->stdOutBuffer = '';

        return $result;
    }
}
