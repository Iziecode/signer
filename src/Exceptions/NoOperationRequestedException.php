<?php

namespace Iziedev\Signer\Exceptions;

use Exception;
use Iziedev\Signer\Helpers\Log;

class NoOperationRequestedException extends Exception
{
    protected $message;

    public function __construct($consoleMessage)
    {
        $logger = new Log;
        $logger->log->error($consoleMessage);
        $this->message = "No operation requested. See the command log.";
    }
}
