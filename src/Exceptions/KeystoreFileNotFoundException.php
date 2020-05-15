<?php

namespace Iziedev\Signer\Exceptions;

use Exception;

class KeystoreFileNotFoundException extends Exception
{
    protected $message;

    public function __construct($path, $message = '', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = 'Couldn\'t find specified kestore file from path ' . $path . '.';
    }
}
