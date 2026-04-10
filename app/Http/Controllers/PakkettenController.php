<?php

namespace App\Http\Controllers;

use App\Models\Pakket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class PakkettenController extends Controller
{
    /**
     * Toon het overzicht van voedselpakketten met optionele eetwens-filter.
     */
    public function index(Request $request)
    {
        try {
            // 1) Lees de gekozen eetwens uit de querystring (0 = geen filter)
            $selectedEetwens = $request->input('eetwens_id', 0);
            Log::info('Pakketten index opgevraagd.', ['eetwens_id' => $selectedEetwens]);

            // 2) Haal alle pakketten op op basis van de gekozen filterwaarde
            $pakketten = Pakket::getAllPakketten($selectedEetwens);
            Log::info('Pakketten opgehaald voor index.', ['aantal' => count($pakketten)]);

            // 3) Haal eetwensen op om de dropdown in de view te vullen
            $eetwensen = DB::table('Eetwens')->get();
            Log::info('Eetwensen opgehaald voor filter.', ['aantal' => $eetwensen->count()]);

            // 4) Geef pakketten, eetwensen en huidige filter door aan de view
            return view('pakketten.index', compact('pakketten', 'eetwensen', 'selectedEetwens'));
        } catch (Throwable $e) {
            Log::error('Fout bij laden van pakkettenoverzicht.', ['exception' => $e]);

            return redirect()->back()->with('error', 'Er is iets misgegaan bij het laden van het overzicht.');
        }
    }

    /**
     * Toon eventueel later een formulier om een nieuw pakket te maken.
     */
    public function create()
    {
        Log::info('Pakketten create pagina opgevraagd, maar nog niet geïmplementeerd.');
    }

    /**
        * Sla eventueel later een nieuw pakket op.
     */
    public function store(Request $request)
    {
        Log::warning('Pakketten store aangeroepen, maar nog niet geïmplementeerd.', [
            'request_data' => $request->all(),
        ]);
    }

    /**
     * Toon detailinformatie van alle pakketten van een specifiek gezin.
     */
    public function show($id)
    {
        try {
            Log::info('Pakketdetails opgevraagd.', ['gezin_id' => $id]);

            // Vraag de pakketdetails op via de stored procedure in het model
            $details = Pakket::getPakketDetails($id);

            // Geen records gevonden: terug met foutmelding
            if (empty($details)) {
                Log::warning('Geen pakketdetails gevonden voor gezin.', ['gezin_id' => $id]);

                return redirect()->back()->with('error', 'Geen gegevens gevonden.');
            }

            // Algemene gezinsinformatie staat in elke rij; neem daarom de eerste
            $gezinInfo = (object) [
                'Naam' => $details[0]->Naam,
                'Omschrijving' => $details[0]->Omschrijving,
                'TotaalAantalPersonen' => $details[0]->TotaalAantalPersonen,
            ];
            Log::info('Pakketdetails succesvol geladen.', ['gezin_id' => $id, 'aantal_regels' => count($details)]);

            // Stuur zowel rijdata als samengevatte gezinsinfo naar de detailpagina
            return view('pakketten.show', compact('details', 'gezinInfo'));
        } catch (Throwable $e) {
            Log::error('Fout bij laden van pakketdetails.', ['gezin_id' => $id, 'exception' => $e]);

            return redirect()->route('pakketten.index')->with('error', 'Er is iets misgegaan bij het laden van de gegevens.');
        }
    }

    /**
     * Toon het formulier om de status van een pakket te wijzigen.
     */
    public function edit($id) // Laravel vult hier het PakketNummer in
    {
        try {
            Log::info('Pakket edit pagina opgevraagd.', ['pakket_nummer' => $id]);

            // Haal pakketgegevens op op basis van pakketnummer
            $pakket = Pakket::getPakketByNummer($id);

            // Bestaat pakket niet: terug naar overzicht met foutmelding
            if (! $pakket) {
                Log::warning('Pakket niet gevonden voor edit.', ['pakket_nummer' => $id]);

                return redirect()->route('pakketten.index')->with('error', 'Pakket niet gevonden.');
            }

            // Beschikbare statussen voor de dropdown
            $statussen = ['Niet Uitgereikt', 'In behandeling', 'Uitgereikt', 'Geannuleerd'];
            Log::info('Editgegevens opgebouwd voor pakket.', ['pakket_nummer' => $id]);

            // Render editpagina met pakket en statusopties
            return view('pakketten.edit', compact('pakket', 'statussen'));
        } catch (Throwable $e) {
            Log::error('Fout bij openen van status-wijzigpagina.', ['pakket_nummer' => $id, 'exception' => $e]);

            return redirect()->route('pakketten.index')->with('error', 'Er is iets misgegaan bij het openen van het pakket.');
        }
    }

    /**
     * Verwerk de statuswijziging van een pakket.
     */
    public function update(Request $request, $nummer)
    {
        try {
            Log::info('Pakketstatus update gestart.', [
                'pakket_nummer' => $nummer,
                'nieuwe_status' => $request->input('status'),
            ]);

            // Basisvalidatie van de gekozen status
            $request->validate(['status' => 'required|string']);

            // Haal pakket op zodat we gezinstatus en redirect-doel kennen
            $pakket = Pakket::getPakketByNummer($nummer);

            // Pakketnummer ongeldig of niet gevonden
            if (! $pakket) {
                Log::warning('Pakket niet gevonden tijdens update.', ['pakket_nummer' => $nummer]);

                return redirect()->route('pakketten.index')->with('error', 'Pakket niet gevonden.');
            }

            // Controle: inactieve gezinnen mogen geen pakketstatus wijzigen
            $isInactiefGezin = isset($pakket->IsActief) && (int) $pakket->IsActief === 0;

            // Bij inactief gezin geen update uitvoeren, wel melding en timed redirect
            if ($isInactiefGezin) {
                Log::warning('Statusupdate geblokkeerd: gezin is inactief.', [
                    'pakket_nummer' => $nummer,
                    'gezin_id' => $pakket->GezinId ?? null,
                ]);

                return redirect()->route('pakketten.edit', $nummer)->with([
                    'success' => 'Dit gezin is niet meer ingeschreven bij de voedselbank en daarom kan er geen voedselpakket worden uitgereikt',
                    'pakket_nummer' => $nummer,
                    'is_inactief_gezin' => true,
                    'redirect_to' => isset($pakket->GezinId)
                        ? route('pakketten.show', $pakket->GezinId)
                        : route('pakketten.index'),
                ]);
            }

            // Gezin is actief: status daadwerkelijk wijzigen via model/procedure
            Pakket::updateStatus($nummer, $request->status);
            Log::info('Pakketstatus succesvol bijgewerkt.', [
                'pakket_nummer' => $nummer,
                'nieuwe_status' => $request->status,
                'gezin_id' => $pakket->GezinId ?? null,
            ]);

            // Toon succesmelding en laat frontend na 3 seconden terugsturen
            return redirect()->route('pakketten.edit', $nummer)->with([
                'success' => 'De wijziging is doorgevoerd',
                'pakket_nummer' => $nummer,
                'is_inactief_gezin' => false,
                'redirect_to' => isset($pakket->GezinId)
                    ? route('pakketten.show', $pakket->GezinId)
                    : route('pakketten.index'),
            ]);
        } catch (Throwable $e) {
            Log::error('Fout bij bijwerken van pakketstatus.', ['pakket_nummer' => $nummer, 'exception' => $e]);

            return redirect()->route('pakketten.edit', $nummer)->with('error', 'Er is iets misgegaan bij het wijzigen van de status.');
        }
    }

    /**
        * Verwijderfunctie nog niet in gebruik.
     */
    public function destroy(string $id)
    {
        Log::warning('Pakketten destroy aangeroepen, maar nog niet geïmplementeerd.', ['id' => $id]);
    }
}
