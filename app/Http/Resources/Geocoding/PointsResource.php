<?php

namespace App\Http\Resources\Geocoding;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PointsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'lat' =>$this->lat,
            'lon' => $this->lon,
            'address' => $this->address->address_string ?? 'null'
        ];
    }
}
