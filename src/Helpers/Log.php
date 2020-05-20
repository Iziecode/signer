<?php

namespace Iziedev\Signer\Helpers;

class Log
{
    public $log;

    public function __construct()
    {
        $logClass = config('signer.log');
        $logHandler = new $logClass();
        $this->log = $logHandler->logProvider();
    }
}
