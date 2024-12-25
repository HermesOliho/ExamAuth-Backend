<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inscription;
use Illuminate\Http\Request;

class InscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inscription::with(["etudiant", "promotion"])->get();
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
    public function show(Inscription $inscription)
    {
        return $inscription->load(["etudiant", "promotion"]);
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
    public function update(Request $request, Inscription $inscription)
    {
        $request->validate([
            "annee_academique" => ["required", "regex:/^[0-9]{4}-[0-9]{4}$/"]
        ]);
        $inscription->annee_academique = $request->input("annee_academique");
        $inscription->save();
        return [
            "message" => "L'inscription a bien été modifiée",
            "success" => true
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inscription $inscription)
    {
        $inscription->delete();
        return [
            "message" => "L'inscription a bien été supprimée",
            "success" => true
        ];
    }
}
