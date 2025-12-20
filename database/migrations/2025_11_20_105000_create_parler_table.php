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
        Schema::create('parler', function (Blueprint $table) {
            $table->foreignId('idRegion')->constrained(table: 'regions',indexName: 'parler_idRegion')->onDelete('cascade');
            $table->foreignId('idLangue')->constrained(table: 'langues',indexName: 'parler_idLangue')->onDelete('cascade');
            $table->primary(['idRegion', 'idLangue']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parler');
    }
};
