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
}
