<?php

namespace App\Repositories\Geocoding;

use App\Dtos\Geocoding\AddressDto;
use App\Models\Geocoding\Address;

class AddressRepository
{
    public function create(AddressDto $addressDto): Address
    {
        $address = new Address();
        $address->address_string = $addressDto->address;
        $address->kind = $addressDto->kind;
        $address->save();

        return $address;
    }
}
