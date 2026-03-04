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
        Schema::create('map_reports', function (Blueprint $table) {
            $table->id();
            $table->string('map_name')->index();
            $table->integer('total_enlistments')->default(0);
            $table->integer('colonial_casualties')->default(0);
            $table->integer('warden_casualties')->default(0);
            $table->integer('day_of_war')->default(0);
            $table->timestamp('fetched_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('map_reports');
    }
};
