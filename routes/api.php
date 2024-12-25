<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DomaineController;
use App\Http\Controllers\Api\FaculteController;
use App\Http\Controllers\Api\FiliereController;
use App\Http\Controllers\Api\MentionController;
use App\Http\Controllers\Api\EtudiantController;
use App\Http\Controllers\Api\PaiementController;
use App\Http\Controllers\Api\PromotionController;
use App\Http\Controllers\Api\DerogationController;
use App\Http\Controllers\Api\InscriptionController;
use App\Http\Controllers\Api\FraisAcademiqueController;

Route::get("/hello", function () {
    return "Hello Hermès";
});

// Les resources de l'API
// Domaines
Route::resource("domaines", DomaineController::class)->except(["create", "edit"]);
Route::prefix("domaine/{domaine}")->group(function () {
    Route::post("filieres", [DomaineController::class, "addFiliere"]);
    Route::get("filieres", [DomaineController::class, "filieres"]);
});
// Filieres
Route::resource("filieres", FiliereController::class)->except(["create", "store", "edit"]);
Route::prefix("filiere/{filiere}")->group(function () {
    Route::post("mentions", [FiliereController::class, "addMention"]);
    Route::get("mentions", [FiliereController::class, "mentions"]);
});
// Mentions
Route::resource("mentions", MentionController::class)->except(["create", "store", "edit"]);
Route::prefix("mention/{mention}")->group(function () {
    Route::post("promotions", [MentionController::class, "addPromotion"]);
    Route::get("promotions", [MentionController::class, "promotions"]);
});
// Promotions
Route::resource("promotions", PromotionController::class)->except(["create", "store", "edit"]);
Route::post("promotion/{promotion}/ajouter-frais-academique", [PromotionController::class, "addFraisAcademique"]);
/** @todo Impléménter la logique d'inscription et continuer avec les autres ressources */
Route::resource("etudiants", EtudiantController::class)->except(["create", "edit"]);
Route::get("etudiant/{matricule}/find", [EtudiantController::class, "find"])->where([
    "matricule" => "[0-9]{1,3}\/[0-9]{1,4}.[0-9]{2,8}"
]);
Route::get("etudiant/{etudiant}/paiements", [EtudiantController::class, "paiements"]);
Route::get("etudiant/{etudiant}/derogations", [EtudiantController::class, "derogations"]);
Route::post("etudiant/{etudiant}/paiements", [EtudiantController::class, "addPayment"]);
Route::post("etudiant/{etudiant}/derogations", [EtudiantController::class, "addDerogation"]);
Route::resource("inscriptions", InscriptionController::class)->only(["update", "index", "show", "destroy"]);
Route::resource("frais-academiques", FraisAcademiqueController::class);
Route::resource("paiements", PaiementController::class);
Route::resource("derogations", DerogationController::class);
Route::post("promotion-frais-academiques", [FraisAcademiqueController::class, "associerPromotion"]);
Route::delete("promotion-frais-academiques", [FraisAcademiqueController::class, "supprimerPromotion"]);
