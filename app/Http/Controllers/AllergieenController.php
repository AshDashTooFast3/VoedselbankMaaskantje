<?php

namespace App\Http\Controllers;

use App\Models\Allergie;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class AllergieenController extends Controller
{
    // Instantie van het Allergie model voor databaseoperaties
    private $AllergieModel;

    /**
     * Constructor: Initialiseer het Allergie model
     */
    public function __construct()
    {
        // Maak een nieuwe instantie van het Allergie model aan
        $this->AllergieModel = new Allergie;
    }

    /**
     * Toon overzicht van gezinnen met allergiën (met optionele allergie-filter)
     */
    public function index($allergieId = null)
    {
        try {
            // Haal allergie filter op uit query parameters
            $allergieId = request('allergie_id');

            // Haal alle beschikbare allergiën op voor de dropdown selector
            $allergieenselector = $this->AllergieModel->getAllAllergies();

            // Haal gezinnen op: gefilterd op allergie of alle gezinnen
            $results = $allergieId
                ? $this->AllergieModel->getAllFamiliesBySelectedAllergy($allergieId)
                : $this->AllergieModel->getAllFamilies();

            // Handmatige paginatie: stored procedures geven alle resultaten terug, Laravel kan dit niet automatisch
            $page = request('page', 1);
            $perPage = 4;

            // Zet resultaten in een Laravel collection voor makkelijkere manipulatie
            $allResults = collect($results);

            // Bereken offset voor huidige pagina (bijv. pagina 2 = skip 4 items)
            $offset = ($page - 1) * $perPage;

            // Maak een Laravel paginatie-object aan met de handmatig geslicede resultaten
            $gezinnen = new LengthAwarePaginator(
                $allResults->slice($offset, $perPage)->values(),  // slice: haal items voor huidige pagina
                \count($results),                                   // totaal aantal items
                $perPage,                                           // items per pagina
                $page,                                              // huidige pagina
                ['path' => request()->url(), 'query' => request()->query()]  // paginatie URLs
            );

            // Log succesvolle ophaling met filterdetails
            Log::info('Allergieen overzicht geladen.', [
                'allergie_id' => $allergieId,
                'aantal_resultaten' => \count($results),
                'pagina' => (int) $page,
            ]);

            // Render de index view met paginatie en allergie dropdown
            return view('allergieen.index', [
                'gezinnen' => $gezinnen,
                'allergieenselector' => $allergieenselector,
            ]);
        } catch (Throwable $e) {
            // Log fout en stuur gebruiker terug naar dashboard
            Log::error('Fout bij laden van allergieen overzicht.', [
                'allergie_id' => request('allergie_id'),
                'message' => $e->getMessage(),
            ]);

            // Redirect naar dashboard met foutmelding
            return redirect()->route('dashboard')->with('error', 'Er is iets misgegaan bij het laden van het overzicht.');
        }
    }

    /**
     * Toon gedetailleerde allergie informatie voor een specifiek gezin met alle personen
     */
    public function show($gezinId)
    {
        try {
            // Haal alle personen van dit gezin op met hun allergiën
            $gezin = $this->AllergieModel->getAllergiesInFamily($gezinId);

            // Log succesvolle ophaling
            Log::info('Allergieen gezin detail geladen.', [
                'gezin_id' => (int) $gezinId,
                'aantal_personen' => \count($gezin),
            ]);

            // Render detail view met gezinsgegevens en personen
            return view('allergieen.show', [
                'gezin' => $gezin,
                'gezinId' => (int) $gezinId,
            ]);
        } catch (Throwable $e) {
            // Log fout en stuur terug naar allergieen overzicht
            Log::error('Fout bij laden van gezin detail.', [
                'gezin_id' => (int) $gezinId,
                'message' => $e->getMessage(),
            ]);

            // Redirect naar lijst met foutmelding
            return redirect()->route('allergieen.index')->with('error', 'Er is iets misgegaan bij het openen van dit gezin.');
        }
    }

    /**
     * Toon formulier voor het bewerken van een allergie van een persoon
     */
    public function edit($id)
    {
        try {
            // Cast persoon ID naar integer en haal gezin ID op uit query parameter
            $persoonId = (int) $id;
            $gezinId = (int) request('gezin_id');

            // Haal persoongegevens op
            $Persoon = $this->AllergieModel->getAllergyById($persoonId);

            // Haal alle allergiën op voor de dropdown in het formulier
            $allergies = $this->AllergieModel->getAllAllergies();

            // Log verduidelijking dat bewerkpagina geopend is
            Log::info('Allergie bewerkpagina geopend.', [
                'persoon_id' => $persoonId,
                'gezin_id' => $gezinId,
            ]);

            // Render edit view met persoon, allergiën en context
            return view('allergieen.edit', compact('Persoon', 'allergies', 'persoonId', 'gezinId'));
        } catch (Throwable $e) {
            // Log fout bij openenen van edit formulier
            Log::error('Fout bij openen van allergie bewerkpagina.', [
                'persoon_id' => (int) $id,
                'gezin_id' => (int) request('gezin_id'),
                'message' => $e->getMessage(),
            ]);

            // Redirect naar allergieen lijst met foutmelding
            return redirect()->route('allergieen.index')->with('error', 'Er is iets misgegaan bij het openen van de bewerkpagina.');
        }
    }

    /**
     * Sla de gewijzigde allergie op in de database
     */
    public function update(Request $request, $id)
    {
        try {
            // Cast persoon ID als integer
            $persoonId = (int) $id;

            // Valideer dat de vereiste formulier velden aanwezig en correct zijn
            $validatedData = $request->validate([
                'allergie_id' => 'required|integer',
                'gezin_id' => 'required|integer',
            ]);

            // Extract en cast de gevalideerde data
            $gezinId = (int) $validatedData['gezin_id'];
            $allergieId = (int) $validatedData['allergie_id'];

            // Haal persoongegevens op om te verifiëren dat persoon bestaat
            $persoon = $this->AllergieModel->getAllergyById($persoonId);

            // VALIDATIE: Controleer of persoon ID geldig is
            if (! $persoonId) {
                Log::warning('Update gestopt: persoon ID ontbreekt.', ['persoon_id' => $persoonId]);

                return redirect()->back()->with('error', 'Persoon niet gevonden.');
            }

            // VALIDATIE: Controleer of allergie ID geldig is
            if (! $allergieId) {
                Log::warning('Update gestopt: allergie ID ontbreekt.', ['persoon_id' => $persoonId]);

                return redirect()->back()->with('error', 'Allergie niet geselecteerd.');
            }

            // VALIDATIE: Controleer of gezin ID geldig is
            if (! $gezinId) {
                Log::warning('Update gestopt: gezin ID ontbreekt.', ['persoon_id' => $persoonId]);

                return redirect()->back()->with('error', 'Gezin niet gevonden.');
            }

            // VALIDATIE: Verifieer dat persoon daadwerkelijk in database bestaat
            if (empty($persoon)) {
                Log::warning('Update gestopt: persoon niet gevonden in database.', ['persoon_id' => $persoonId]);

                return redirect()->back()->with('error', 'Persoon niet gevonden.');
            }
            // Haal het anafylactische risico niveau op voor deze allergie
            $Risico = Allergie::where('Id', $allergieId)->value('AnafylactischRisico');

            // VEILIGHEIDSCHECKS: Als allergie "Hoog" risico heeft, vraag bevestiging
            if ($Risico && $Risico === 'Hoog') {
                Log::warning('Update gestopt: geselecteerde allergie heeft hoog anafylactisch risico.', [
                    'persoon_id' => $persoonId,
                    'allergie_id' => $allergieId,
                ]);

                // Waarschuw gebruiker en stop update
                return redirect()->back()->with('error', 'Voor het wijzigen van deze allergie wordt geadviseerd eerst een arts te raadplegen vanwege een hoog risico op een anafylactisch shock.');
            }

            // Voer de allergie update uit in de database
            $this->AllergieModel->updateAllergy($persoonId, $allergieId, $gezinId);

            // Log succesvolle update
            Log::info('Allergie succesvol bijgewerkt.', [
                'persoon_id' => $persoonId,
                'allergie_id' => $allergieId,
                'gezin_id' => $gezinId,
            ]);

            // Ga terug naar vorige pagina met succesmelding
            return redirect()->back()->with('success', 'De wijziging is doorgevoerd.');
        } catch (ValidationException $e) {
            // Validation mislukt: log en geef error door aan Laravel
            Log::warning('Validatiefout bij bijwerken allergie.', [
                'persoon_id' => (int) $id,
                'errors' => $e->errors(),
            ]);

            // Gooi exception door zodat Laravel error feedback toont
            throw $e;
        } catch (Throwable $e) {
            // Log onverwachte fout (niet validatiefout)
            Log::error('Onverwachte fout bij bijwerken allergie.', [
                'persoon_id' => (int) $id,
                'message' => $e->getMessage(),
            ]);

            // Ga terug en bewaar formulier data zodat gebruiker het opnieuw kan proberen
            return redirect()->back()->withInput()->with('error', 'Er is iets misgegaan bij het opslaan van de allergie.');
        }
    }
}
