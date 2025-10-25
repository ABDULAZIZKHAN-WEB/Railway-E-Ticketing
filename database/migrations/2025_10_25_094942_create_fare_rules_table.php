<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fare_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_station_id')->constrained('stations');
            $table->foreignId('to_station_id')->constrained('stations');
            $table->foreignId('seat_class_id')->constrained('seat_classes');
            $table->decimal('base_fare', 8, 2);
            $table->decimal('distance_km', 8, 2);
            $table->decimal('vat_percentage', 5, 2)->default(5.00);
            $table->decimal('service_charge', 8, 2)->default(0);
            $table->date('effective_from');
            $table->date('effective_to')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fare_rules');
    }
};