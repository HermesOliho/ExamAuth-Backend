<?php

use App\Models\Etudiant;
use App\Models\Promotion;
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
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->string("annee_academique", 20);
            $table->foreignIdFor(Etudiant::class);
            $table->foreignIdFor(Promotion::class);
            $table->primary(["etudiant_id_etudiant", "promotion_id_promotion"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
