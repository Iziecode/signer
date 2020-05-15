<?php

namespace Iziedev\Signer\Exceptions;

use Exception;

class SignerPluginNotExistsException extends Exception
{
    /**
     * Exception message
     * 
     * @var string
     */
    protected $message = 'Signer plugin not exist on given path.';
}
