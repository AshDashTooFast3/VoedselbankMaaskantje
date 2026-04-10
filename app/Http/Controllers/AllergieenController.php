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
    private $AllergieModel;

    public function __construct()
    {
        $this->AllergieModel = new Allergie;
    }

    public function index($allergieId = null)
    {
        try {
            $allergieId = request('allergie_id');
            $allergieenselector = $this->AllergieModel->getAllAllergies();
            $results = $allergieId
                ? $this->AllergieModel->getAllFamiliesBySelectedAllergy($allergieId)
                : $this->AllergieModel->getAllFamilies();

            // Handmatige paginatie voor de resultaten uit de stored procedures.
            $page = request('page', 1);
            $perPage = 4;
            $allResults = collect($results);
            $offset = ($page - 1) * $perPage;

            $gezinnen = new LengthAwarePaginator(
                $allResults->slice($offset, $perPage)->values(),
                \count($results),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );

            Log::info('Allergieen overzicht geladen.', [
                'allergie_id' => $allergieId,
                'aantal_resultaten' => \count($results),
                'pagina' => (int) $page,
            ]);

            return view('allergieen.index', [
                'gezinnen' => $gezinnen,
                'allergieenselector' => $allergieenselector,
            ]);
        } catch (Throwable $e) {
            Log::error('Fout bij laden van allergieen overzicht.', [
                'allergie_id' => request('allergie_id'),
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('dashboard')->with('error', 'Er is iets misgegaan bij het laden van het overzicht.');
        }
    }

    public function show($gezinId)
    {
        try {
            $gezin = $this->AllergieModel->getAllergiesInFamily($gezinId);

            Log::info('Allergieen gezin detail geladen.', [
                'gezin_id' => (int) $gezinId,
                'aantal_personen' => \count($gezin),
            ]);

            return view('allergieen.show', [
                'gezin' => $gezin,
                'gezinId' => (int) $gezinId,
            ]);
        } catch (Throwable $e) {
            Log::error('Fout bij laden van gezin detail.', [
                'gezin_id' => (int) $gezinId,
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('allergieen.index')->with('error', 'Er is iets misgegaan bij het openen van dit gezin.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $persoonId = (int) $id;
            $gezinId = (int) request('gezin_id');

            $Persoon = $this->AllergieModel->getAllergyById($persoonId);
            $allergies = $this->AllergieModel->getAllAllergies();

            Log::info('Allergie bewerkpagina geopend.', [
                'persoon_id' => $persoonId,
                'gezin_id' => $gezinId,
            ]);

            return view('allergieen.edit', compact('Persoon', 'allergies', 'persoonId', 'gezinId'));
        } catch (Throwable $e) {
            Log::error('Fout bij openen van allergie bewerkpagina.', [
                'persoon_id' => (int) $id,
                'gezin_id' => (int) request('gezin_id'),
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('allergieen.index')->with('error', 'Er is iets misgegaan bij het openen van de bewerkpagina.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $persoonId = (int) $id;

            // Alleen velden valideren die daadwerkelijk uit het formulier komen.
            $validatedData = $request->validate([
                'allergie_id' => 'required|integer',
                'gezin_id' => 'required|integer',
            ]);

            $gezinId = (int) $validatedData['gezin_id'];
            $allergieId = (int) $validatedData['allergie_id'];
            $persoon = $this->AllergieModel->getAllergyById($persoonId);

            if (! $persoonId) {
                Log::warning('Update gestopt: persoon ID ontbreekt.', ['persoon_id' => $persoonId]);

                return redirect()->back()->with('error', 'Persoon niet gevonden.');
            }
            if (! $allergieId) {
                Log::warning('Update gestopt: allergie ID ontbreekt.', ['persoon_id' => $persoonId]);

                return redirect()->back()->with('error', 'Allergie niet geselecteerd.');
            }
            if (! $gezinId) {
                Log::warning('Update gestopt: gezin ID ontbreekt.', ['persoon_id' => $persoonId]);

                return redirect()->back()->with('error', 'Gezin niet gevonden.');
            }
            if (empty($persoon)) {
                Log::warning('Update gestopt: persoon niet gevonden in database.', ['persoon_id' => $persoonId]);

                return redirect()->back()->with('error', 'Persoon niet gevonden.');
            }
            $Risico = Allergie::where('Id', $allergieId)->value('AnafylactischRisico');

            if ($Risico && $Risico === 'Hoog') {
                Log::warning('Update gestopt: geselecteerde allergie heeft hoog anafylactisch risico.', [
                    'persoon_id' => $persoonId,
                    'allergie_id' => $allergieId,
                ]);

                return redirect()->back()->with('error', 'Voor het wijzigen van deze allergie wordt geadviseerd eerst een arts te raadplegen vanwege een hoog risico op een anafylactisch shock.');
            }

            $this->AllergieModel->updateAllergy($persoonId, $allergieId, $gezinId);

            Log::info('Allergie succesvol bijgewerkt.', [
                'persoon_id' => $persoonId,
                'allergie_id' => $allergieId,
                'gezin_id' => $gezinId,
            ]);

            return redirect()->back()->with('success', 'De wijziging is doorgevoerd.');
        } catch (ValidationException $e) {
            Log::warning('Validatiefout bij bijwerken allergie.', [
                'persoon_id' => (int) $id,
                'errors' => $e->errors(),
            ]);

            throw $e;
        } catch (Throwable $e) {
            Log::error('Onverwachte fout bij bijwerken allergie.', [
                'persoon_id' => (int) $id,
                'message' => $e->getMessage(),
            ]);

            return redirect()->back()->withInput()->with('error', 'Er is iets misgegaan bij het opslaan van de allergie.');
        }
    }
}
