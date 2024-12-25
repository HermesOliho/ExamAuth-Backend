<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Derogation;
use Illuminate\Http\Request;

class DerogationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Derogation::with("etudiant")->get();
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
    public function show(Derogation $derogation)
    {
        return $derogation->load("etudiant");
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
    public function destroy(Derogation $derogation)
    {
        $derogation->delete();
        return [
            "message" => "La dérogation a été supprimée",
            "success" => true
        ];
    }
}
