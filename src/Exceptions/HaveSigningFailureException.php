<?php

namespace Iziedev\Signer\Exceptions;

use Exception;

class HaveSigningFailureException extends Exception
{
    protected $message;

    public function __construct($consoleMessage)
    {
        $this->message = "Signing of some file failure. See the command log.";
    }
}
