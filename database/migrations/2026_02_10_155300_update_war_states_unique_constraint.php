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
        Schema::table('war_states', function (Blueprint $table) {
            // Drop the old unique constraint on just 'war_id'
            $table->dropUnique('war_states_war_id_unique');
            
            // Add a composite unique constraint on 'war_id' and 'shard'
            $table->unique(['war_id', 'shard'], 'war_states_war_id_shard_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('war_states', function (Blueprint $table) {
            // Drop the composite unique constraint
            $table->dropUnique('war_states_war_id_shard_unique');
            
            // Restore the old unique constraint on just 'war_id'
            $table->unique('war_id', 'war_states_war_id_unique');
        });
    }
};
