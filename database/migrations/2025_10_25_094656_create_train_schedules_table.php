<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('train_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('train_id')->constrained('trains');
            $table->foreignId('route_id')->constrained('routes');
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->json('running_days_json'); // [0,1,2,3,4,5,6] for Sun-Sat
            $table->date('effective_from');
            $table->date('effective_to')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('train_schedules');
    }
};