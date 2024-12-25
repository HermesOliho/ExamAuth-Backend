<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FraisAcademiques;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FraisAcademiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FraisAcademiques::with("promotions")->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "semestre" => ["required", "min:1"],
            "montant" => ["required", "numeric"],
            "echeance_paiement" => ["required", "date"]
        ]);
        $frais_academiques = new FraisAcademiques();
        $frais_academiques->semestre = $request->input("semestre");
        $frais_academiques->montant = $request->input("montant");
        $frais_academiques->echeance_paiement = $request->input("echeance_paiement");
        $frais_academiques->save();
        return $frais_academiques;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return FraisAcademiques::with("promotions")->findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function associerPromotion(Request $request)
    {
        $request->validate([
            "promotion" => ["required", "exists:promotions,id_promotion"],
            "frais_academiques" => ["required", "exists:frais_academiques,id_tranche"],
            "annee_academique" => ["required", "regex:/^[0-9]{4}-[0-9]{4}$/"]
        ]);
        $frais_academiques = FraisAcademiques::findOrFail($request->input("frais_academiques"));
        $promotion = Promotion::findOrFail($request->input("promotion"));
        DB::table("promotions_frais_academiques")->insert([
            "annee_academique" => $request->input("annee_academique"),
            "promotion_id_promotion" => $promotion->id_promotion,
            "frais_academiques_id_tranche" => $frais_academiques->id_tranche,
        ]);
        return [
            "success" => true,
            "message" => "Frais académiques ajoutés à la promotion"
        ];
    }

    public function supprimerPromotion(Request $request)
    {
        $request->validate([
            "promotion" => ["required", "exists:promotions,id_promotion"],
            "frais_academiques" => ["required", "exists:frais_academiques,id_tranche"],
            "annee_academique" => ["required", "regex:/^[0-9]{4}-[0-9]{4}$/"]
        ]);
        $frais_academiques = FraisAcademiques::findOrFail($request->input("frais_academiques"));
        $promotion = Promotion::findOrFail($request->input("promotion"));
        DB::table("promotions_frais_academiques")
            ->where("annee_academique", $request->input("annee_academique"))
            ->where("promotion_id_promotion", $promotion->id_promotion)
            ->where("frais_academiques_id_tranche", $frais_academiques->id_tranche)
            ->delete();
        return [
            "success" => true,
            "message" => "Frais académiques supprimés à la promotion"
        ];
    }
}
