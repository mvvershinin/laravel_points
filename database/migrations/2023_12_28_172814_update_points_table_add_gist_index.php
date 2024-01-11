<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $fn = dirname(__FILE__) . "/sql/003_create_idx_points_gist.sql";
        DB::unprepared(file_get_contents($fn));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $fn = dirname(__FILE__) . "/sql/004_drop_idx_points_gist.sql";
        DB::unprepared(file_get_contents($fn));
    }
};
