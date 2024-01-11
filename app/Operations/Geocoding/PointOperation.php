<?php

namespace App\Operations\Geocoding;

use App\Dtos\Geocoding\PointDto;
use App\Models\User;
use App\Operations\JobRunnerOperation;
use App\Repositories\Geocoding\PointRepository;
use App\Services\Geocoding\GeocodingServiceInterface;

class PointOperation
{
    public function __construct(
        protected PointRepository $pointRepository,
        protected GeocodingServiceInterface $geocodingService,
        protected JobRunnerOperation $jobRunnerOperation
    )
    {

    }

    /**
     * @param User $user
     * @param PointDto $pointDto
     * @return string
     * @throws \Exception
     */
    public function storePoint(User $user, PointDto $pointDto): string
    {
        $point = $this->pointRepository->make($pointDto, $user);
        $nearestPoint = $this->pointRepository->getNearestPoint($point->lat, $point->lon);

        if ($nearestPoint && isset($nearestPoint->address_id)) {
            $this->pointRepository->attachAddress($point, $nearestPoint->address_id);
            $message = __('attach.exists.address');
        } else {
            $this->pointRepository->attachAddress($point);
            $this->jobRunnerOperation->runGetAddressByPoint($point);

            $message = __('dispatch.get_address_job');
        }

        return $message;
    }
}
