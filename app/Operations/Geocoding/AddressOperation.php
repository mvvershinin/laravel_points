<?php

namespace App\Operations\Geocoding;

use App\Models\Geocoding\Point;
use App\Repositories\Geocoding\AddressRepository;
use App\Repositories\Geocoding\PointRepository;
use App\Services\Geocoding\GeocodingServiceInterface;

class AddressOperation
{
    public function __construct(
        protected GeocodingServiceInterface $geocodingService,
        protected AddressRepository $addressRepository,
        protected PointRepository $pointRepository
    )
    {

    }

    /**
     * @param Point $point
     * @return void
     */
    public function getAddressByService(Point $point): void
    {
        $geocodingAddress = $this->geocodingService->getAddressByPoint($point->lat, $point->lon);
        $address = $this->addressRepository->create($geocodingAddress);
        $this->pointRepository->attachAddress($point, $address->id);
    }
}
