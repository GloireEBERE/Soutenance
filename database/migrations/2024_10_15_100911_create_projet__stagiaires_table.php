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
        Schema::create('projet_stagiaire', function (Blueprint $table) {
            $table->uuid('stagiaire_id');
            $table->uuid('projet_id');
            $table->foreign('projet_id')->references('id')->on('projets')->onDelete('cascade');
            $table->primary(['stagiaire_id', 'projet_id']); // Clé composite pour éviter les doublons
            $table->timestamps();

            $table->foreign('stagiaire_id')->references('id')->on('stagiaires')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projet_stagiaire');
    }
};

