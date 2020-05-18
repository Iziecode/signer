<?php

namespace Iziedev\Signer\Handlers;

use Illuminate\Support\Facades\Log;

class LogHandler
{
    public function logProvider()
    {
        return Log::channel('daily');
    }
}
