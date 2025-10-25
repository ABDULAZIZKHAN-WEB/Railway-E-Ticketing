<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('train_coaches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('train_id')->constrained('trains');
            $table->foreignId('seat_class_id')->constrained('seat_classes');
            $table->string('coach_number', 10);
            $table->integer('total_seats');
            $table->json('layout_json')->nullable(); // seat arrangement data
            $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('train_coaches');
    }
};