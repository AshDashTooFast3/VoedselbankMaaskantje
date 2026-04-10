<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use App\Models\Leverancier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class LeverancierController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        try {
            $selectedType = $request->input('leverancier_type');
            $leveranciers = Leverancier::getLeveranciersOverzicht($selectedType);
            $leverancierTypes = Leverancier::getLeverancierTypes();

            Log::info('Leveranciers overzicht geladen.', [
                'filter_type' => $selectedType,
                'result_count' => $leveranciers->count(),
            ]);

            return view('leveranciers.index', compact('leveranciers', 'leverancierTypes', 'selectedType'));
        } catch (QueryException $exception) {
            Log::error('Databasefout bij ophalen leveranciers overzicht.', [
                'message' => $exception->getMessage(),
            ]);

            return redirect()->route('dashboard')->with('error', 'Leveranciers konden niet worden geladen.');
        }
    }

    public function show(int $id): View|RedirectResponse
    {
        try {
            $details = Leverancier::getLeverancierDetails($id);

            if (!$details['leverancier']) {
                return redirect()->route('leveranciers.index')->with('error', 'Leverancier niet gevonden.');
            }

            Log::info('Leverancier details geladen.', ['leverancier_id' => $id]);

            return view('leveranciers.show', [
                'leverancier' => $details['leverancier'],
                'producten' => $details['producten'],
            ]);
        } catch (QueryException $exception) {
            Log::error('Databasefout bij ophalen leverancier details.', [
                'leverancier_id' => $id,
                'message' => $exception->getMessage(),
            ]);

            return redirect()->route('leveranciers.index')->with('error', 'Details konden niet worden opgehaald.');
        }
    }

    public function edit(int $id): View|RedirectResponse
    {
        try {
            $details = Leverancier::getLeverancierDetails($id);

            if (!$details['leverancier']) {
                return redirect()->route('leveranciers.index')->with('error', 'Leverancier niet gevonden.');
            }

            return view('leveranciers.edit', [
                'leverancier' => $details['leverancier'],
            ]);
        } catch (QueryException $exception) {
            Log::error('Databasefout bij openen leverancier wijzigpagina.', [
                'leverancier_id' => $id,
                'message' => $exception->getMessage(),
            ]);

            return redirect()->route('leveranciers.index')->with('error', 'Wijzigpagina kon niet worden geladen.');
        }
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'Naam' => ['required', 'string', 'max:150'],
            'Contactpersoon' => ['required', 'string', 'max:150'],
            'LeverancierNummer' => ['required', 'string', 'max:50', 'regex:/^L[0-9]{4}$/'],
            'LeverancierType' => ['required', 'string', 'max:50'],
            'Email' => ['nullable', 'email:rfc,dns', 'max:150'],
            'Mobiel' => ['nullable', 'string', 'max:50', 'regex:/^[+0-9\-\s]+$/'],
        ]);

        try {
            Leverancier::updateLeverancier($id, $validated);

            Log::info('Leverancier bijgewerkt.', ['leverancier_id' => $id]);

            return redirect()->route('leveranciers.show', $id)->with('success', 'Leverancier is succesvol bijgewerkt.');
        } catch (QueryException $exception) {
            Log::error('Databasefout bij updaten leverancier.', [
                'leverancier_id' => $id,
                'message' => $exception->getMessage(),
            ]);

            return redirect()->back()->withInput()->with('error', 'Opslaan is mislukt. Probeer het opnieuw.');
        }
    }
}
