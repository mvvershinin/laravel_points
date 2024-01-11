<?php

namespace App\Services\Geocoding;

use App\Dtos\Geocoding\AddressDto;

abstract class AbstractGeocodingService implements GeocodingServiceInterface
{
    abstract public function getAddressByPoint(float $lat, float $lon): AddressDto;
}
