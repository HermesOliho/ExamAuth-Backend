<?php

use App\Models\FraisAcademiques;
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
        Schema::create('promotions_frais_academiques', function (Blueprint $table) {
            $table->foreignIdFor(Promotion::class)->constrained()->nullOnDelete();
            $table->foreignIdFor(FraisAcademiques::class)->constrained()->nullOnDelete();
            $table->string("annee_academique");
            // $table->unique([
            //     "promotion_id_promotion",
            //     "frais_academique_id_tranche",
            //     "annee_academique"
            // ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions_frais_academiques');
    }
};
