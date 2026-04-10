<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pakket;
use Illuminate\Support\Facades\DB;

class PakkettenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Haal de geselecteerde eetwens op (default 0)
        $selectedEetwens = $request->input('eetwens_id', 0);

        // 2. Roep de model-functie aan met de filter
        $pakketten = Pakket::getAllPakketten($selectedEetwens);

        // 3. Haal de lijst met eetwensen op voor de dropdown boven de tabel
        $eetwensen = DB::table('Eetwens')->get();

        // 4. Stuur alles naar de view
        return view('pakketten.index', compact('pakketten', 'eetwensen', 'selectedEetwens'));
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
    public function show(string $id)
    {
        //
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
}
