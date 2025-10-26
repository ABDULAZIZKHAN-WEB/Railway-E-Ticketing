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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // General Information, Train Arrival, etc.
            $table->string('train_number')->nullable(); // Related train number
            $table->string('platform')->nullable(); // Platform number
            $table->text('message_en'); // English message
            $table->text('message_bn')->nullable(); // Bengali message
            $table->string('priority'); // Normal, High, Emergency
            $table->integer('repeat_times')->default(1); // How many times to repeat
            $table->integer('repeat_interval')->default(0); // Interval in seconds
            $table->string('status')->default('draft'); // draft, published, completed
            $table->timestamp('scheduled_at')->nullable(); // When to announce
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};