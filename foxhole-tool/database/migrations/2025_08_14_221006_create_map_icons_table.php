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
        Schema::create('map_icons', function (Blueprint $table) {
            $table->id();
            $table->string('war_id')->index();
            $table->string('map_name')->index();
            $table->string('team_id')->default('NONE')->index();
            $table->integer('icon_type')->index();
            $table->decimal('x', 10, 8);
            $table->decimal('y', 10, 8);
            $table->integer('flags')->default(0);
            $table->integer('version')->nullable();
            $table->unsignedBigInteger('last_updated_ms')->nullable();
            $table->timestamps();

            $table->unique(['war_id','map_name','icon_type','x','y'], 'map_icons_natural_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('map_icons');
    }
};
