<?php

namespace Iziedev\Signer\Exceptions;

use Exception;
use Iziedev\Signer\Helpers\Log;

class HaveSigningFailureException extends Exception
{
    protected $message;

    public function __construct($consoleMessage)
    {
        $logger = new Log;
        $logger->log->error($consoleMessage);
        $this->message = "Signing of some file failure. See the command log.";
    }
}
