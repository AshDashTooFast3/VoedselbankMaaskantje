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
    public static function getKlantenOverzicht($postcode = null)
    {
        return DB::select('CALL sp_getAllKlanten(?)', [$postcode]);
    }

    public static function getUniquePostcodes()
    {
        return DB::table('Contact')->distinct()->pluck('Postcode');
    }

    public static function getKlantDetails($id)
    {
        $result = DB::select('CALL sp_getKlantDetails(?)', [$id]);
        return count($result) > 0 ? $result[0] : null;
    }

    public static function updateKlantContact($id, $data)
    {
        DB::statement('CALL sp_updateKlantContact(?, ?, ?, ?, ?, ?, ?, ?)', [
            $id,
            $data['Straatnaam'], $data['Huisnummer'], $data['Toevoeging'],
            $data['Postcode'], $data['Woonplaats'], $data['Email'], $data['Mobiel']
        ]);
    }
}