<?php

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
        Schema::create('etudiants', function (Blueprint $table) {
            $table->integer("id_etudiant", true);
            $table->string("nom");
            $table->string("post_nom");
            $table->string("prenom")->nullable();
            $table->enum("sexe", ["M", "F"]);
            $table->string("matricule", 25);
            $table->string("adresse");
            $table->string("lieu_naissance");
            $table->date("date_naissance");
            $table->string("image_url");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};
