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
        Schema::create('war_states', function (Blueprint $table) {
            $table->id();
            $table->string('war_id')->unique();
            $table->integer('war_number')->nullable();
            $table->string('winner')->default('NONE');
            $table->timestamp('conquest_start')->nullable();
            $table->timestamp('conquest_end')->nullable();
            $table->timestamp('resistance_start')->nullable();
            $table->timestamp('scheduled_conquest_end')->nullable();
            $table->integer('required_victory_towns')->nullable();
            $table->integer('short_required_victory_towns')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('war_states');
    }

    
};
