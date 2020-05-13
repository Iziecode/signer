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

        $this->mergeConfigFrom(
            __DIR__ . '/config/signer.php',
            'signer'
        );
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/signer.php' => config('signer.php')
        ], 'signer-config');
    }
}
