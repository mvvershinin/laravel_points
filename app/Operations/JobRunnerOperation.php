<?php

namespace App\Operations;

use App\Jobs\GetAddressByPointJob;
use Throwable;

class JobRunnerOperation
{
    public function runGetAddressByPoint($point):void
    {
        try {
            GetAddressByPointJob::dispatch($point);
        } catch (Throwable $exception) {
            throw new \Exception('unable get address from geocoding');
        }

    }
}
