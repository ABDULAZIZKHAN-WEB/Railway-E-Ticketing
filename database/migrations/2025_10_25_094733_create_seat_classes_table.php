<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seat_classes', function (Blueprint $table) {
            $table->id();
            $table->string('class_code', 10)->unique(); // AC_B, AC_S, SNIGDHA, S_CHAIR, SHOVON, F_BERTH
            $table->string('class_name');
            $table->string('class_name_bn')->nullable();
            $table->decimal('base_price_per_km', 8, 2);
            $table->json('amenities_json')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seat_classes');
    }
};