<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS getAllPakketten");

        DB::unprepared(<<<'SQL'
            CREATE PROCEDURE getAllPakketten(IN p_EetwensId INT)
            BEGIN
                SELECT 
                    g.Naam AS Gezinsnaam,
                    g.Omschrijving,
                    g.AantalVolwassenen AS Volwassenen,
                    g.AantalKinderen AS Kinderen,
                    g.AantalBabys AS Babys,
                    CONCAT(p.Voornaam, ' ', IFNULL(p.Tussenvoegsel, ''), ' ', p.Achternaam) AS Vertegenwoordiger,
                    ew.Naam AS Eetwens,
                    vp.PakketNummer,
                    vp.Status AS PakketStatus
                FROM Voedselpakket vp
                INNER JOIN Gezin g ON vp.GezinId = g.Id
                INNER JOIN Persoon p ON g.Id = p.GezinId AND p.IsVertegenwoordiger = 1
                LEFT JOIN EetwensPerGezin epg ON g.Id = epg.GezinId
                LEFT JOIN Eetwens ew ON epg.EetwensId = ew.Id
                WHERE (p_EetwensId IS NULL OR p_EetwensId = 0 OR ew.Id = p_EetwensId)
                GROUP BY 
                    vp.Id, 
                    g.Naam, 
                    g.Omschrijving, 
                    g.AantalVolwassenen, 
                    g.AantalKinderen, 
                    g.AantalBabys, 
                    p.Voornaam, 
                    p.Tussenvoegsel, 
                    p.Achternaam, 
                    ew.Naam, 
                    vp.PakketNummer, 
                    vp.Status
                ORDER BY g.Naam ASC;
            END
        SQL);
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS getAllPakketten");
    }
};
