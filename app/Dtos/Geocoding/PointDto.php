<?php

namespace App\Dtos\Geocoding;

class PointDto
{
    public function __construct(
        public float $lat,
        public float $lon
    ){ }
}
