<?php

namespace App\Http\Requests\Coordinate;

use App\Dtos\Geocoding\PointDto;
use App\Dtos\Geocoding\PointsFilterDto;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class PointIndexRequest extends FormRequest
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
            'user_id' => 'required|integer',
            'from' => 'required|date|date_format:Y-m-d H:i:s',
            'to' => 'required|date|date_format:Y-m-d H:i:s|after:from',
        ];
    }

    public function getPointsFilterDto(): PointsFilterDto
    {
        return new PointsFilterDto(
            $this->input('user_id'),
            Carbon::make($this->input('from')),
            Carbon::make($this->input('to'))
        );
    }
}
