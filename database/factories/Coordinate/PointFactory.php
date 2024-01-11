<?php

namespace Database\Factories\Coordinate;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Geocoding\Point>
 */
class PointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker\Factory::create();

        return [
            'lat' => $faker->latitude(-90, 90),
            'lon' => $faker->longitude(-180, 180),
            'address_id' => null,
            'user_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
