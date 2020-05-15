<?php

namespace Iziedev\Signer;

use Illuminate\Support\ServiceProvider;

class SignerServiceProvider extends ServiceProvider
{
    public function register()
    {
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
