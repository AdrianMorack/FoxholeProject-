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
        Schema::create('api_etags', function (Blueprint $table) {
            $table->id();
            $table->string('endpoint')->unique(); // e.g. "war", "maps", "warReport:Deadlands", "dynamic:Deadlands"
            $table->string('etag')->nullable();
            $table->timestamp('last_http_200_at')->nullable();
            $table->timestamp('last_http_304_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_etags');
    }
};
