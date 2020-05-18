<?php

namespace App\Handlers;

class SignerLogHandler extends \Iziedev\Signer\Handlers\LogHandler
{
    public function __construct()
    {
        parent::logProvider();
    }
}
