<?php

namespace Iziedev\Signer\Exceptions;

use Exception;

class PropertyRequiredException extends Exception
{
    /**
     * Message exception
     * 
     */
    protected $message;

    /**
     * Class constructor
     * 
     */
    public function __construct($propertyRequired, $insteadProperty, $message = '', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = "Property '{$propertyRequired}' is needed instead of '{$insteadProperty}'.";
    }
}
