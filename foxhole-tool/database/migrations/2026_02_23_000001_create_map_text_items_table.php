<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('map_text_items', function (Blueprint $table) {
            $table->id();
            $table->string('shard', 20);
            $table->string('war_id', 100);
            $table->string('map_name', 100);
            $table->string('text', 255);
            $table->decimal('x', 10, 8);
            $table->decimal('y', 10, 8);
            $table->string('map_marker_type', 20)->default('Minor'); // Major or Minor
            $table->timestamps();

            $table->unique(['shard', 'war_id', 'map_name', 'text'], 'map_text_items_unique');
            $table->index(['shard', 'war_id', 'map_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('map_text_items');
    }
};
