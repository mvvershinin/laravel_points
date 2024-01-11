<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->float('lat');
            $table->float('lon');
            $table->integer('address_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });

        Schema::table('points', function (Blueprint $table) {
            $table->index(['created_at', 'user_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points');
    }
};
