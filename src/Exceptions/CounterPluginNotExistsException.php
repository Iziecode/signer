<?php

namespace Iziedev\Signer\Exceptions;

use Exception;

class CounterPluginNotExistsException extends Exception
{
    /**
     * Exception message
     * 
     * @var string
     */
    protected $message = 'Counter plugin not exist on given path.';
}
