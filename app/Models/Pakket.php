<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Pakket
{
    /**
     * Haalt alle voedselpakketten op via de stored procedure.
     * We maken de functie static zodat Pakket::getAllPakketten() werkt.
     */
    public static function getAllPakketten($eetwensId = 0)
    {
        // We gebruiken de DB facade om de procedure aan te roepen met de parameter
        return DB::select('CALL getAllPakketten(?)', [$eetwensId]);
    }

    public static function getPakketDetails($gezinId)
    {
        return DB::select('CALL getPakketDetailsByGezin(?)', [$gezinId]);
    }

    public static function updateStatus($nummer, $status)
    {
        // Gebruik statement voor updates via een Stored Procedure
        return DB::statement('CALL updatePakketStatus(?, ?)', [$nummer, $status]);
    }

    public static function getPakketByNummer($nummer)
    {
        $result = DB::select('CALL getPakketByNummer(?)', [$nummer]);

        return $result[0] ?? null;
    }
}
