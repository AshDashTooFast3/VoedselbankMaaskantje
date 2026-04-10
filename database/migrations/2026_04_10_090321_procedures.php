<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS getAllPakketten');

        DB::unprepared(<<<'SQL'
CREATE PROCEDURE getAllPakketten()
BEGIN
    SELECT 
        g.Code AS GezinCode,
        g.Naam AS GezinNaam,
        vp.PakketNummer,
        vp.DatumSamenstelling,
        vp.DatumUitgifte,
        vp.Status AS PakketStatus,
        COUNT(ppv.ProductId) AS AantalVerschillendeProducten,
        IFNULL(SUM(ppv.AantalProductEenheden), 0) AS TotaalProductEenheden
    FROM Voedselpakket vp
    INNER JOIN Gezin g 
        ON vp.GezinId = g.Id
    LEFT JOIN ProductPerVoedselpakket ppv 
        ON vp.Id = ppv.VoedselpakketId
    LEFT JOIN Product pr 
        ON ppv.ProductId = pr.Id
    GROUP BY 
        g.Id, 
        vp.Id
    ORDER BY 
        vp.DatumSamenstelling DESC, 
        g.Naam ASC;
END
SQL);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS getAllPakketten');
    }
};
