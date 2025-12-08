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
            $table->text('texte');
            $table->string('statut')->default('en cours');
            $table->date('dateCreation')->useCurrent()->nullable(false);
            $table->date('dateValidation');
            $table->foreignId('idTypeContenu')->constrained(table: 'type_contenu',indexName: 'contenus_idTypeContenu');
            $table->foreignId('idAuteur')->constrained(table: 'users',indexName: 'contenus_idAuteur')->nullable(false);
            $table->foreignId('idParent')->constrained(table: 'contenus',indexName: 'contenus_idParent');
            $table->foreignId('idRegion')->constrained(table: 'regions',indexName: 'contenus_idRegion');
            $table->foreignId('idLangue')->constrained(table: 'langues',indexName: 'contenus_idLangue')->nullable(false);
            $table->foreignId('idModerateur')->constrained(table: 'users',indexName: 'contenus_idModerateur');
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
