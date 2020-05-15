<?php

namespace Iziedev\Signer\Exceptions;

use Exception;

class JavaNotInstalledException extends Exception
{
    /**
     * Exception description
     * 
     * @var string
     */
    protected $message = 'Java not installed on this machine.';
}
