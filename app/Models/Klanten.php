<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; // Vergeet deze niet te importeren!

class Klanten extends Model
{
    use HasFactory;

    /**
     * Haal het klantenoverzicht op via de Stored Procedure.
     */
    public static function getKlantenOverzicht()
    {
        // We gebruiken DB::select om de procedure aan te roepen
        return DB::select('CALL sp_getAllKlanten()');
    }
}