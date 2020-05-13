<?php

namespace Iziedev\Signer\Facades;

use Illuminate\Support\Facades\Facade;

class Signer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'iziedev.signer';
    }
}
