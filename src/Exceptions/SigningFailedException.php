<?php

namespace Iziedev\Signer\Exceptions;

use Exception;

class SigningFailedException extends Exception
{
    protected $message;

    public function __construct($consoleMessage)
    {
        $this->message = "Failed to signing. See the command log.";
    }
}
