<?php

namespace Iziedev\Signer\Exceptions;

use Exception;

class FailedOpenPKCS12KeystoreException extends Exception
{
    /**
     * Exception message
     * 
     * @var string
     */
    protected $message = 'Failed to open PKCS12 keystore using given passphrase.';
}
