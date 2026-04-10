<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Allergie;

class AllergieenController extends Controller
{
    private $AllergieModel;
    public function __construct()
    {
        $this->AllergieModel = new Allergie();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('allergieen.index');
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
