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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('chemin')->nullable(false);
            $table->string('description');
            $table->foreignId('idTypeMedia')->constrained(table: 'type_media',indexName: 'media_idTypeMedia');
            $table->foreignId('idContenu')->constrained(table: 'contenus',indexName: 'media_idContenu')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
