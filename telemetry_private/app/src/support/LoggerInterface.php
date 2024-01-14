<?php

namespace Sessions;

interface LoggerInterface
{
    /**
     * Log all relevant activity
     *
     * @param $logger
     * @return mixed
     */
    public function setLogger($logger);

}