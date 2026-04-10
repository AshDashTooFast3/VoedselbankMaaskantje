<?php

namespace App\Http\Controllers;

use App\Models\Allergie;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AllergieenController extends Controller
{
    private $AllergieModel;

    public function __construct()
    {
        $this->AllergieModel = new Allergie;
    }

    public function index($allergieId = null)
    {
        $allergieId = request('allergie_id');
        $allergieenselector = $this->AllergieModel->getAllAllergies();
        $results = $allergieId
            ? $this->AllergieModel->getAllFamiliesBySelectedAllergy($allergieId)
            : $this->AllergieModel->getAllFamilies();

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

        return view('allergieen.index', [
            'gezinnen' => $gezinnen,
            'allergieenselector' => $allergieenselector,
        ]);
    }

    public function show()
    {
        return view('allergieen.show');
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
}
