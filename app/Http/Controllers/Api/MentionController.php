<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mention;
use App\Models\Promotion;
use Illuminate\Http\Request;

class MentionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Mention::with("filiere")->get();
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
    public function show(Mention $mention)
    {
        return $mention->load("promotions");
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
    public function update(Request $request, Mention $mention)
    {
        $request->validate([
            "nom" => ["required", "min:2", "unique:mentions,nom_mention,except,{$mention->id_mention}"]
        ]);
        $mention->nom_mention = $request->input("nom");
        $mention->save();
        return [
            "message" => "La mention a bien été modifiée",
            "success" => true
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mention $mention)
    {
        $mention->delete();
        return [
            "message" => "La mention a bien été supprimée",
            "success" => true
        ];
    }

    public function promotions(Mention $mention)
    {
        return $mention->promotions()->get();
    }

    public function addPromotion(Request $request, Mention $mention)
    {
        $request->validate([
            "nom" => ["required", "min:2", "unique:promotions,nom_promotion"]
        ]);
        $promotion = new Promotion();
        $promotion->nom_promotion = $request->input("nom");
        $promotion->mention()->associate($mention);
        $promotion->save();
        return $promotion;
    }
}
