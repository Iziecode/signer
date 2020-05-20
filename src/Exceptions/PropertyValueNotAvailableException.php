<?php

namespace Iziedev\Signer\Exceptions;

use Exception;

class PropertyValueNotAvailableException extends Exception
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
    public function __construct($property, $value, array $available, $message = '', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = "Value '{$value}' of '{$property}' property not available. Avalaible value " . implode(', ', $available);
    }
}
