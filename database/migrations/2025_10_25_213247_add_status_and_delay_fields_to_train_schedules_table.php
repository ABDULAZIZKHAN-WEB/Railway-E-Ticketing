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
        Schema::table('train_schedules', function (Blueprint $table) {
            $table->integer('delay_minutes')->default(0);
            // Change the default value of status column
            $table->string('status')->default('on_time')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('train_schedules', function (Blueprint $table) {
            $table->dropColumn('delay_minutes');
        });
    }
};