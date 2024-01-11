<?php

namespace App\Dtos\Geocoding;

class AddressDto
{
    public function __construct(
        public string $address,
        public string $kind
    ) {
    }
}
