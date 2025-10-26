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
        Schema::create('platforms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('status')->default('available'); // available, occupied, maintenance, blocked
            $table->string('type')->default('passenger'); // passenger, freight
            $table->integer('capacity')->default(0); // number of coaches
            $table->text('current_train')->nullable(); // current train information
            $table->dateTime('next_arrival')->nullable(); // next arrival time
            $table->dateTime('last_maintenance')->nullable(); // last maintenance date
            $table->text('maintenance_notes')->nullable(); // maintenance details
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platforms');
    }
};