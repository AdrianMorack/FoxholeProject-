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
        // Add shard column to war_states table
        Schema::table('war_states', function (Blueprint $table) {
            $table->string('shard', 20)->default('baker')->after('war_id');
            $table->index('shard');
        });

        // Add shard column to maps table
        Schema::table('maps', function (Blueprint $table) {
            $table->string('shard', 20)->default('baker')->after('name');
            $table->index('shard');
        });

        // Add shard column to map_reports table
        Schema::table('map_reports', function (Blueprint $table) {
            $table->string('shard', 20)->default('baker')->after('map_name');
            $table->index('shard');
        });

        // Add shard column to map_icons table
        Schema::table('map_icons', function (Blueprint $table) {
            $table->string('shard', 20)->default('baker')->after('war_id');
            $table->index('shard');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('war_states', function (Blueprint $table) {
            $table->dropColumn('shard');
        });

        Schema::table('maps', function (Blueprint $table) {
            $table->dropColumn('shard');
        });

        Schema::table('map_reports', function (Blueprint $table) {
            $table->dropColumn('shard');
        });

        Schema::table('map_icons', function (Blueprint $table) {
            $table->dropColumn('shard');
        });
    }
};
