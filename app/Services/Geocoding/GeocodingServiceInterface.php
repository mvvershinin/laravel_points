<?php

namespace App\Services\Geocoding;

use App\Dtos\Geocoding\AddressDto;

interface GeocodingServiceInterface
{
    public function getAddressByPoint(float $lat, float $lon): AddressDto;
}
