<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use PDO;

class Pakket
{
    /**
     * Haalt alle voedselpakketten op via de stored procedure.
     * We maken de functie static zodat Pakket::getAllPakketten() werkt.
     */
    public static function getAllPakketten() 
    {
        // Haal de PDO connectie op vanuit de Laravel database verbinding
        $pdo = DB::connection()->getPdo();

        // Bereid de aanroep voor
        $sql = "CALL getAllPakketten()";
        $query = $pdo->prepare($sql);

        // Voer de query uit
        $query->execute();

        // Retourneer de resultaten als een array van objecten
        $result = $query->fetchAll(PDO::FETCH_OBJ);

        // Sluit de cursor
        $query->closeCursor();

        return $result;
    }
}