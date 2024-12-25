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
        Schema::create('frais_academiques', function (Blueprint $table) {
            $table->integer("id_tranche", true);
            $table->string("semestre", 50);
            $table->decimal("montant", 10, 2);
            $table->date("echeance_paiement");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frais_academiques');
    }
};
