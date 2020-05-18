<?php

namespace Iziedev\Signer\Exceptions;

use Exception;

class NoOperationRequestedException extends Exception
{
    protected $message;

    public function __construct($consoleMessage)
    {
        $this->message = "No operation requested. See the command log.";
    }
}
