<?php

namespace App\Jobs;

use App\Models\Geocoding\Point;
use App\Operations\Geocoding\AddressOperation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GetAddressByPointJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Point $point,
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(AddressOperation $addressOperation): void
    {
        Log::debug('start GetAddressByPointJob::job');
        $addressOperation->getAddressByService($this->point);
    }
}
