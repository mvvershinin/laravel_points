<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Geocoding\Point;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $start_lat = 54.932793;
        $start_lon = 82.697323;
        for($i = 1; $i < 100; $i++) {
            Point::factory()->create([
                'lat' => $start_lat + $i*0.000001,
                'lon' => $start_lon + $i*0.000001
            ]);
        }
    }
}
