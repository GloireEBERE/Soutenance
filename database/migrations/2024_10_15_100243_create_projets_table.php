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
        Schema::create('projets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('titre_projet');
            $table->text('description_projet')->nullable();
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->enum('statut', ['en cours', 'terminé', 'annulé'])->default('en cours');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projets');
    }
};

