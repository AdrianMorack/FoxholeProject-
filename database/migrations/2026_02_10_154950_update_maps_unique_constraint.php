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
        Schema::table('maps', function (Blueprint $table) {
            // Drop the old unique constraint on just 'name'
            $table->dropUnique('maps_name_unique');
            
            // Add a composite unique constraint on 'name' and 'shard'
            $table->unique(['name', 'shard'], 'maps_name_shard_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maps', function (Blueprint $table) {
            // Drop the composite unique constraint
            $table->dropUnique('maps_name_shard_unique');
            
            // Restore the old unique constraint on just 'name'
            $table->unique('name', 'maps_name_unique');
        });
    }
};
