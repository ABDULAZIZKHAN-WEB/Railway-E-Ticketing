<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('route_stations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained('routes');
            $table->foreignId('station_id')->constrained('stations');
            $table->integer('sequence_order');
            $table->integer('arrival_time_offset_minutes')->default(0);
            $table->integer('departure_time_offset_minutes')->default(0);
            $table->string('platform_number', 10)->nullable();
            $table->decimal('distance_from_start_km', 8, 2)->default(0);
            $table->integer('halt_duration_minutes')->default(2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('route_stations');
    }
};