<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FraisAcademiques;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Promotion::with("mention")->get();
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
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
        return $promotion->load(["inscriptions", "inscriptions.etudiant"]);
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
    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            "nom" => ["required", "min:2", "unique:promotions,nom_promotion,except,{$promotion->id_promotion}"]
        ]);
        $promotion->update(["nom_promotion" => $request->input("nom")]);
        return [
            "message" => "La promotion a bien été modifiée",
            "success" => true
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return [
            "message" => "La promotion a bien été supprimée",
            "success" => true
        ];
    }

    public function addFraisAcademiques(Request $request, Promotion $promotion)
    {
        $request->validate([
            "id_etudiant" => ["exists:frais_academiques,id_tranche", "nullable"],
            "semestre" => ["required_without:id_etudiant", "min:3"],
            "montant" => ["required_without:id_etudiant", "min:3"],
            "echeance_paiement" => ["required_without:id_etudiant", "date"],
        ]);
        if (!is_null($request->input("id_tranche"))) {
            $frais_academiques = FraisAcademiques::findOrFail($request->input("id_tranche"));
        } else {
            $frais_academiques = new FraisAcademiques();
            $frais_academiques->semestre = $request->input("semestre");
            $frais_academiques->montant = $request->input("montant");
            $frais_academiques->echeance_paiement = $request->input("echeance_paiement");
        }
        $frais_academiques->promotions()->attach($promotion);
        return $promotion->load(["frais_academiques"]);
    }
}
