<?php

namespace Iziedev\Signer\Exceptions;

use Exception;

class WrongCommandException extends Exception
{
    protected $message;

    public function __construct($consoleMessage)
    {
        $this->message = "Command line is in wrong format. See the command log.";
    }
}
