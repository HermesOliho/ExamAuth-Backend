<?php

namespace App\Http\Controllers\Api;

use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use App\Models\Derogation;
use App\Models\Inscription;
use App\Models\Paiement;
use App\Models\Promotion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EtudiantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $etudiants = Etudiant::with(["inscriptions", "inscriptions.promotion"])->get();
        foreach ($etudiants as $etudiant) {
            /** @var Inscription */
            $derniere_inscription = $etudiant->inscriptions()
                ->orderBy("annee_academique", "desc")
                ->first();
            $etudiant->promotion = $derniere_inscription->promotion->nom_promotion;
            $etudiant->annee_academique = $derniere_inscription->annee_academique;
        }
        return $etudiants;
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
        $last_authorized_birthday = now()->subYears(6)->toString();
        $request->validate([
            "nom" => ["required", "min:3"],
            "post_nom" => ["required", "min:3"],
            "prenom" => ["nullable", "min:3"],
            "sexe" => ["required", "in:M,F"],
            "matricule" => ["required", "min:5", "max:25"],
            "adresse" => ["required", "min:5", "max:255"],
            "lieu_naissance" => ["required", "min:5", "max:255"],
            "date_naissance" => ["required", "date", "before:{$last_authorized_birthday}"],
            "image" => ["required", "image"],
            "id_promotion" => ["required", "exists:promotions,id_promotion"],
            "annee_academique" => ["required", "regex:/^[0-9]{4}-[0-9]{4}$/"]
        ]);
        // Récupérer les attributs
        $attributes = [...$request->input(), "image_url" => $request->input("image")];
        /** @var UploadedFile $image */
        $image = $request->file("image");
        $image_url = $image->store("etudiants/images/", "public");
        $attributes["image_url"] = $image_url;
        $etudiant = new Etudiant($attributes);
        $promotion = Promotion::findOrFail($request->input("id_promotion"));
        $etudiant->save();
        $inscription = new Inscription();
        $inscription->annee_academique = $request->input("annee_academique");
        $inscription->promotion()->associate($promotion);
        $inscription->etudiant()->associate($etudiant);
        $inscription->save();
        return $inscription;
    }

    /**
     * Display the specified resource.
     */
    public function show(Etudiant $etudiant)
    {
        return $etudiant;
    }

    public function find(string $matricule)
    {
        $etudiant = Etudiant::with(["paiements", "derogations"])->where("matricule", $matricule)->first();
        // Récupérer la dernière inscription
        /** @var Inscription */
        $derniere_inscription = $etudiant->inscriptions()
            ->orderBy("annee_academique", "desc")
            ->first();
        $etudiant->promotion = $derniere_inscription->promotion->nom_promotion;
        // Récupérer la dernière année académique
        $etudiant->annee_academique = $derniere_inscription->annee_academique;
        // Récupérer les frais de la promotion
        $etudiant->frais_promotion = $derniere_inscription->promotion
            ->frais_academiques()
            ->where("annee_academique", $etudiant->annee_academique)
            ->orderBy("created_at", "desc")
            ->limit(2)
            ->get();
        $etudiant->total_frais = $derniere_inscription->promotion
            ->frais_academiques()
            ->select(DB::raw("SUM(montant) as total"))
            ->where("annee_academique", $etudiant->annee_academique)
            ->limit(2)
            ->first()->total;
        // Récupérer le paiement total
        $etudiant->total_paiement = $etudiant->paiements()->select(DB::raw('SUM(montant) as total'))->first()->total;
        $etudiant->solde_paiment = $etudiant->total_frais - $etudiant->total_paiement;
        // Corriger l'URL de la photo de l'étudiant
        $etudiant->image_url = "/storage/" . $etudiant->image_url;
        // Rétourner le résultat
        return $etudiant;
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
    public function update(Request $request, Etudiant $etudiant)
    {
        $last_authorized_birthday = now()->subYears(6)->toString();
        $request->validate([
            "nom" => ["required", "min:3"],
            "post_nom" => ["required", "min:3"],
            "prenom" => ["nullable", "min:3"],
            "sexe" => ["required", "in:M,F"],
            "adresse" => ["required", "min:5", "max:255"],
            "lieu_naissance" => ["required", "min:5", "max:255"],
            "date_naissance" => ["required", "date", "before:{$last_authorized_birthday}"],
            "image" => ["url"],
        ]);
        $etudiant->update($request->input());
        return [
            "message" => "L'étudiant a bien été modifiée",
            "success" => true
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();
        return [
            "message" => "L'étudiant a bien été modifiée",
            "success" => true
        ];
    }

    public function addPayment(Request $request, Etudiant $etudiant)
    {
        $request->validate([
            "montant" => ["required", "numeric"],
            "num_bordereau" => ["required", "min:3", "unique:paiements,num_bordereau"],
            "date_paiement" => ["required", "date"]
        ]);
        $paiement = new Paiement();
        $paiement->montant = $request->input("montant");
        $paiement->num_bordereau = $request->input("num_bordereau");
        $paiement->date_paiement = $request->input("date_paiement");
        $paiement->etudiant()->associate($etudiant);
        $paiement->save();
        return $paiement;
    }

    public function addDerogation(Request $request, Etudiant $etudiant)
    {
        $today = now()->toString();
        $request->validate([
            "motif" => ["required", "min:3"],
            "date_debut" => ["required", "after_or_equal:{$today}"],
            "date_fin" => ["required", "after:{$request->input('date_debut')}"]
        ]);
        $derogation = new Derogation();
        $derogation->motif = $request->input("motif");
        $derogation->date_debut = $request->input("date_debut");
        $derogation->date_fin = $request->input("date_fin");
        $derogation->etudiant()->associate($etudiant);
        $derogation->save();
        return $derogation;
    }

    public function paiements(Etudiant $etudiant)
    {
        return $etudiant->paiements()->get();
    }

    public function derogations(Etudiant $etudiant)
    {
        return $etudiant->derogations()->get();
    }
}
