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
        $fn = dirname(__FILE__) . "/sql/001_create_earthdistance_extension.sql";
        DB::unprepared(file_get_contents($fn));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $fn = dirname(__FILE__) . "/sql/002_drop_earthdistance_extension.sql";
        DB::unprepared(file_get_contents($fn));
    }
};
