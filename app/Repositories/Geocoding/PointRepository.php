<?php

namespace App\Repositories\Geocoding;

use App\Dtos\Geocoding\PointDto;
use App\Dtos\Geocoding\PointsFilterDto;
use App\Models\Geocoding\Point;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PointRepository
{
    const DEFAULT_POINT_DISTANCE = 5;
    const DEFAULT_PAGE_SIZE = 15;

    /**
     * @param PointDto $pointDto
     * @param User $user
     * @return Point
     */
    public function make(PointDto $pointDto, User $user): Point
    {
        $point = new Point();
        $point->lat = $pointDto->lat;
        $point->lon = $pointDto->lon;
        $point->user_id = $user->id;

        return $point;
    }


    /**
     * @param float $lat
     * @param float $lon
     * @param int $distance
     * @return Point|null
     */
    public function getNearestPoint(float $lat, float $lon, int $distance = self::DEFAULT_POINT_DISTANCE): ?Point
    {
        $query = /** @lang text */
            "select * from get_nearest_points($lat, $lon, $distance) limit 1";
        $points = Point::hydrate(DB::select($query));

        return $points->first();
    }

    public function attachAddress(Point $point, int $addressId = null): void
    {
        $point->address_id = $addressId;
        $point->save();
    }

    public function getUsersPoints(PointsFilterDto $filter): LengthAwarePaginator
    {
        return Point::with('address')
            ->where('user_id', $filter->userId)
            ->whereBetween(
                'created_at', [$filter->from, $filter->to]
            )
            ->paginate(self::DEFAULT_PAGE_SIZE);
    }
}
