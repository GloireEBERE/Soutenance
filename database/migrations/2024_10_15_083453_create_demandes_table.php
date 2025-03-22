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
        Schema::create('demandes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('stagiaire_id');
            $table->string('lettre_de_demande');
            $table->string('cv');
            $table->enum('statut', ['en attente', 'refusée', 'acceptée'])->default('en attente');
            $table->date('date_soumission');
            $table->date('date_acceptation')->nullable();
            $table->timestamps();

            $table->foreign('stagiaire_id')->references('id')->on('stagiaires')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};
