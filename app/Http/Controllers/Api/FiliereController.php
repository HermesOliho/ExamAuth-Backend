<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Filiere;
use App\Models\Mention;
use Illuminate\Http\Request;

class FiliereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Filiere::with("domaine")->get();
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Filiere $filiere)
    {
        return $filiere->load("mentions");
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
    public function update(Request $request, Filiere $filiere)
    {
        $request->validate([
            "nom" => ["required", "min:2", "unique:filieres,nom_filiere,except,{$filiere->id_filiere}"]
        ]);
        $filiere->update(["nom_filiere" => $request->input("nom")]);
        return [
            "message" => "La filière a bine été modifiée",
            "success" => true
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Filiere $filiere)
    {
        $filiere->delete();
        return [
            "message" => "La filière a bine été supprimée",
            "success" => true
        ];
    }

    public function mentions(Filiere $filiere)
    {
        return $filiere->mentions->get();
    }

    public function addMention(Request $request, Filiere $filiere)
    {
        $request->validate([
            "nom" => ["required", "min:2", "unique:mentions,nom_mention"]
        ]);
        $mention = new Mention();
        $mention->nom_mention = $request->input("nom");
        $mention->filiere()->associate($filiere);
        $mention->save();
        return $mention;
    }
}
