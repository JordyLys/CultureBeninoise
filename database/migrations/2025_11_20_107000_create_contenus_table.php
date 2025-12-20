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
        Schema::create('contenus', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->nullable(false);
            $table->text('texte')->nullable();
            $table->string('statut')->default('en cours');
            $table->date('dateCreation')->useCurrent()->nullable(false);
            $table->date('dateValidation')->nullable();
            $table->foreignId('idTypeContenu')->constrained(table: 'type_contenu',indexName: 'contenus_idTypeContenu')->onDelete('cascade');
            $table->foreignId('idAuteur')->nullable(false)->constrained(table: 'users',indexName: 'contenus_idAuteur')->onDelete('cascade');
            $table->foreignId('idParent')->nullable()->constrained(table: 'contenus',indexName: 'contenus_idParent')->onDelete('cascade');
            $table->foreignId('idRegion')->nullable()->constrained(table: 'regions',indexName: 'contenus_idRegion')->onDelete('cascade');
            $table->foreignId('idLangue')->nullable(false)->constrained(table: 'langues',indexName: 'contenus_idLangue')->onDelete('cascade');
            $table->foreignId('idModerateur')->nullable()->constrained(table: 'users',indexName: 'contenus_idModerateur')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contenus');
    }
};
