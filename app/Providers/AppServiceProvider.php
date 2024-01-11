<?php

namespace App\Providers;

use App\Services\Geocoding\GeocodingServiceInterface;
use App\Services\Geocoding\GeocodingServiceMock;
use App\Services\Geocoding\YandexGeocodingService;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->bindGeocodingService();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }

    protected function bindGeocodingService(): void
    {
        $this->app->bind(GeocodingServiceInterface::class, static function () {
            $geocodingSource = config('geocoding.service');

            return match ($geocodingSource) {
                'yandex' => new YandexGeocodingService(new Client()),
                'mock' => new GeocodingServiceMock(),
                default => throw new \Exception("Service provider not defined for $geocodingSource"),
            };
        });
    }
}
