<?php

namespace Izidev\Signer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Iziedev\Signer\Signer;

class SignerServiceProvider extends ServiceProvider
{
    public function register()
    {
        App::bind('iziedev.signer', function () {
            return new Signer;
        });
    }

    public function boot()
    {
    }
}
