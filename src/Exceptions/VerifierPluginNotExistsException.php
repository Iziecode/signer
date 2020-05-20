<?php

namespace Iziedev\Signer\Exceptions;

use Exception;

class VerifierPluginNotExistsException extends Exception
{
    /**
     * Exception message
     * 
     * @var string
     */
    protected $message = 'Verifier plugin not exist on given path.';
}
