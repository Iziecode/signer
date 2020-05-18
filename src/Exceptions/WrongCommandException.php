<?php

namespace Iziedev\Signer\Exceptions;

use Exception;
use Iziedev\Signer\Helpers\Log;

class WrongCommandException extends Exception
{
    protected $message;

    public function __construct($consoleMessage)
    {
        $logger = new Log;
        $logger->log->error($consoleMessage);
        $this->message = "Command line is in wrong format. See the command log.";
    }
}
