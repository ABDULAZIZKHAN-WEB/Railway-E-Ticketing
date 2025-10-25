<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_passengers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings');
            $table->string('passenger_name');
            $table->integer('age');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->enum('id_type', ['nid', 'passport', 'birth_certificate']);
            $table->string('id_number', 50);
            $table->foreignId('seat_id')->constrained('seats');
            $table->decimal('fare_amount', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_passengers');
    }
};