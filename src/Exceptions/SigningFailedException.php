<?php

namespace Iziedev\Signer\Exceptions;

use Exception;
use Iziedev\Signer\Helpers\Log;

class SigningFailedException extends Exception
{
    protected $message;

    public function __construct($consoleMessage)
    {
        $logger = new Log;
        $logger->log->error($consoleMessage);
        $this->message = "Failed to signing. See the command log.";
    }
}
