<?php

namespace App\Http\Controllers;

use App\Models\Klanten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class KlantenController extends Controller
{
    /**
     * Toon klantenoverzicht met optionele postcode-filter.
     */
    public function index(Request $request)
    {
        try {
            // Lees de filterwaarde uit request (leeg = geen filter)
            $selectedPostcode = $request->input('postcode'); // Haal postcode uit de URL/Form
            Log::info('Klanten index opgevraagd.', ['postcode' => $selectedPostcode]);

            // Haal de lijst met klanten en mogelijke postcodes op
            $klanten = Klanten::getKlantenOverzicht($selectedPostcode);
            $postcodes = Klanten::getUniquePostcodes();
            Log::info('Klanten index geladen.', [
                'aantal_klanten' => count($klanten),
                'aantal_postcodes' => count($postcodes),
            ]);

            // Render overzichtspagina met data
            return view('klanten.index', compact('klanten', 'postcodes', 'selectedPostcode'));
        } catch (Throwable $e) {
            // Fallback bij onverwachte fout
            Log::error('Fout in klanten index.', ['exception' => $e]);

            return redirect()->route('klanten.index')->with('error', 'Er is iets misgegaan bij het laden van de klanten.');
        }
    }

    /**
     * Placeholder voor create-flow (nog niet geimplementeerd).
     */
    public function create()
    {
        // Alleen loggen zolang create niet gebruikt wordt
        Log::info('Klanten create aangeroepen (nog niet geimplementeerd).');
    }

    /**
     * Placeholder voor opslaan van nieuwe klant (nog niet geimplementeerd).
     */
    public function store(Request $request)
    {
        // Log payload om toekomstige implementatie te ondersteunen
        Log::warning('Klanten store aangeroepen (nog niet geimplementeerd).', ['request' => $request->all()]);
    }

    /**
     * Toon detailpagina van een klant.
     */
    public function show($id)
    {
        try {
            // Start detailflow voor gekozen gezin/klant
            Log::info('Klant show opgevraagd.', ['gezin_id' => $id]);

            // Haal detailgegevens op via model/procedure
            $klant = Klanten::getKlantDetails($id);
            Log::info('Klant show geladen.', ['gezin_id' => $id, 'gevonden' => (bool) $klant]);

            // Render detailpagina
            return view('klanten.show', compact('klant'));
        } catch (Throwable $e) {
            // Fallback naar index bij fouten
            Log::error('Fout in klant show.', ['gezin_id' => $id, 'exception' => $e]);

            return redirect()->route('klanten.index')->with('error', 'Er is iets misgegaan bij het laden van de klant.');
        }
    }

    /**
     * Toon bewerkpagina van een klant.
     */
    public function edit($id)
    {
        try {
            // Start editflow voor gekozen klant
            Log::info('Klant edit opgevraagd.', ['gezin_id' => $id]);

            // Hergebruik detail-ophaalmethode als bron voor het formulier
            $klant = Klanten::getKlantDetails($id);
            Log::info('Klant edit geladen.', ['gezin_id' => $id, 'gevonden' => (bool) $klant]);

            // Render bewerkpagina
            return view('klanten.edit', compact('klant'));
        } catch (Throwable $e) {
            // Fallback naar index bij fouten
            Log::error('Fout in klant edit.', ['gezin_id' => $id, 'exception' => $e]);

            return redirect()->route('klanten.index')->with('error', 'Er is iets misgegaan bij het openen van de klant.');
        }
    }

    /**
     * Werk klantgegevens bij met postcode-validatie.
     */
    public function update(Request $request, $id)
    {
        // Log start van update inclusief opgegeven postcode
        Log::info('Klant update gestart.', ['gezin_id' => $id, 'postcode' => $request->input('Postcode')]);

        // Businessregel: bepaalde postcodes zijn niet toegestaan
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

        try {
            // Schrijf gewijzigde contactdata weg
            Klanten::updateKlantContact($id, $request->all());
            Log::info('Klant update geslaagd.', ['gezin_id' => $id]);

            // Terug naar vorige pagina met succesmelding
            return redirect()->back()->with('success', 'De klantgegevens zijn gewijzigd');
        } catch (Throwable $e) {
            // Bij fout: input behouden en fout tonen
            Log::error('Fout in klant update.', ['gezin_id' => $id, 'exception' => $e]);

            return redirect()->back()->withInput()->with('error', 'Er is iets misgegaan bij het wijzigen van de klantgegevens.');
        }
    }

    /**
     * Placeholder voor verwijderen (nog niet geimplementeerd).
     */
    public function destroy(string $id)
    {
        // Alleen loggen zolang delete-flow niet gebouwd is
        Log::warning('Klanten destroy aangeroepen (nog niet geimplementeerd).', ['gezin_id' => $id]);
    }
}
