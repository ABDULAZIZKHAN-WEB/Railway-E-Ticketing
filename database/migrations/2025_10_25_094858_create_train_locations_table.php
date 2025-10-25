<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('train_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('train_id')->constrained('trains');
            $table->foreignId('schedule_id')->constrained('train_schedules');
            $table->date('journey_date');
            $table->decimal('current_latitude', 10, 8);
            $table->decimal('current_longitude', 11, 8);
            $table->foreignId('current_station_id')->nullable()->constrained('stations');
            $table->foreignId('next_station_id')->nullable()->constrained('stations');
            $table->decimal('speed_kmph', 5, 2)->default(0);
            $table->decimal('bearing', 5, 2)->default(0);
            $table->timestamp('last_updated_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('train_locations');
    }
};