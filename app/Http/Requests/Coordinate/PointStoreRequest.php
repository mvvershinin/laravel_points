<?php

namespace App\Http\Requests\Coordinate;

use App\Dtos\Geocoding\PointDto;
use Illuminate\Foundation\Http\FormRequest;

class PointStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lat' => 'required|numeric', // -90 to 90 degrees.
            'lon' => 'required|numeric', // -180 to 180 degrees.
        ];
    }

    public function getPoint(): PointDto
    {
        return new PointDto(
            $this->lat,
            $this->lon
        );
    }
}
