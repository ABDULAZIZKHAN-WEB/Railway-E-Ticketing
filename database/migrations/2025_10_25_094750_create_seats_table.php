<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_id')->constrained('train_coaches');
            $table->string('seat_number', 10);
            $table->enum('seat_type', ['window', 'aisle', 'middle']);
            $table->enum('deck', ['upper', 'lower'])->nullable();
            $table->enum('status', ['available', 'maintenance', 'blocked'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};