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
        Schema::create('taches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('stagiaire_id');
            $table->string('titre_tache');
            $table->text('description_tache')->nullable();
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->enum('statut', ['en cours', 'terminée', 'annulée'])->default('en cours');
            $table->timestamps();

            $table->foreign('stagiaire_id')->references('id')->on('stagiaires')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taches');
    }
};

