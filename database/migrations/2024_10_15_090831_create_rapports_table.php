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
        Schema::create('rapports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('stagiaire_id');
            $table->string('theme_rapport');
            $table->string('document_rapport');
            $table->date('date_soumission'); 
            $table->timestamps();

            $table->foreign('stagiaire_id')->references('id')->on('stagiaires')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapports');
    }
};

