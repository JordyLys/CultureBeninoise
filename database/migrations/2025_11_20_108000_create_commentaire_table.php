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
        Schema::create('commentaire', function (Blueprint $table) {
            $table->id();
            $table->text('texte')->nullable(false);
            $table->integer('note')->default(00);
            $table->date('dateCommentaire')->useCurrent()->nullable(false);;
            $table->foreignId('idUsers')->constrained(table: 'users',indexName: 'commentaire_idUsers')->nullable(false);
            $table->foreignId('idContenu')->constrained(table: 'contenus',indexName: 'commentaire_idContenu')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commentaire');
    }
};
