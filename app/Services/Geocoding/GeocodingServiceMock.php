<?php

namespace App\Services\Geocoding;

use App\Dtos\Geocoding\AddressDto;
use App\Models\Geocoding\Address;

final class GeocodingServiceMock extends AbstractGeocodingService
{
    /**
     * @param float $lat
     * @param float $lon
     * @return AddressDto
     */
    public function getAddressByPoint(float $lat, float $lon): AddressDto {
        return new AddressDto("Fake address string for $lat,$lon", Address::TYPE_FAKE);
    }
}
