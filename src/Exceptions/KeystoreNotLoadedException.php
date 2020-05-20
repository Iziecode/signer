<?php

namespace Iziedev\Signer\Exceptions;

use Exception;

class KeystoreNotLoadedException extends Exception
{
    /**
     * Exception message
     * 
     * @var string
     */
    protected $message = 'Cannot load and open the give keystore.';
}
