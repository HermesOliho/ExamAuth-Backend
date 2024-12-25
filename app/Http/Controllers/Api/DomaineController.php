<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Domaine;
use App\Models\Filiere;
use Illuminate\Http\Request;

class DomaineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Domaine::all();
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
            "nom" => ["required", "min:3", "unique:domaines,nom_domaine"]
        ]);
        $domaine = new Domaine();
        $domaine->nom_domaine = $request->input("nom");
        $domaine->save();
        return $domaine;
    }

    /**
     * Display the specified resource.
     */
    public function show(Domaine $domaine)
    {
        return $domaine->load("filieres");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Domaine $domaine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Domaine $domaine)
    {
        $request->validate([
            "nom" => ["required", "min:3", "unique:domaines,nom_domaine,except,{$domaine->id_domaine}"]
        ]);
        $domaine->nom_domaine = $request->input("nom");
        $domaine->save();
        return [
            "message" => "Le domaine a bien été modifié",
            "success" => true
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Domaine $domaine)
    {
        $domaine->delete();
        return [
            "message" => "Le domaine a bien été supprimé",
            "success" => true
        ];
    }

    /**
     * Montre les filières appartenant à ce domaine
     */
    public function filieres(Domaine $domaine)
    {
        return $domaine->filieres()->get();
    }

    /**
     * Ajoute une filière à ce domaine
     */
    public function addFiliere(Request $request, Domaine $domaine)
    {
        $request->validate([
            "nom" => ["required", "min:3", "unique:filieres,nom_filiere"]
        ]);
        $filiere = new Filiere();
        $filiere->nom_filiere = $request->input("nom");
        $filiere->domaine()->associate($domaine);
        $filiere->save();
        return $filiere;
    }
}
