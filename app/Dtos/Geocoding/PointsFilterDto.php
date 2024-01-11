<?php

namespace App\Dtos\Geocoding;

use Carbon\Carbon;

class PointsFilterDto
{
public function __construct(
    public int $userId,
    public Carbon $from,
    public Carbon $to
)
{

}
}
