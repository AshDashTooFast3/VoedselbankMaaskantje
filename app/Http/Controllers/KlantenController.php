<?php

namespace App\Http\Controllers;

use App\Models\Klanten;
use Illuminate\Http\Request;

class KlantenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectedPostcode = $request->input('postcode'); // Haal postcode uit de URL/Form
        
        $klanten = Klanten::getKlantenOverzicht($selectedPostcode);
        $postcodes = Klanten::getUniquePostcodes();

        return view('klanten.index', compact('klanten', 'postcodes', 'selectedPostcode'));
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
    public function show($id)
    {
        $klant = Klanten::getKlantDetails($id);
        return view('klanten.show', compact('klant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $klant = Klanten::getKlantDetails($id);
        return view('klanten.edit', compact('klant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Postcode' => [
                'required',
                function ($attribute, $value, $fail) {
                    $verkeerdePostcodes = ['1901CB', '1901 CB'];
                    if (in_array(strtoupper($value), $verkeerdePostcodes)) {
                        $fail('Deze postcode komt niet uit de regio Maaskantje');
                    }
                },
            ],
        ]);

        Klanten::updateKlantContact($id, $request->all());

        return redirect()->back()->with('success', 'De klantgegevens zijn gewijzigd');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
