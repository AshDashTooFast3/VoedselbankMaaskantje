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
        DB::unprepared('USE VoedselbankMaaskantje');

        DB::unprepared('DROP PROCEDURE IF EXISTS getAllPakketten');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_getAllKlanten');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_getKlantDetails');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_updateKlantContact');

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

        DB::unprepared(<<<'SQL'
CREATE PROCEDURE sp_getAllKlanten(IN p_Postcode VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci)
BEGIN
    SELECT 
        G.Id AS KlantId,
        G.Naam AS 'Naam Gezin',
        CONCAT(
            P.Voornaam, 
            IF(P.Tussenvoegsel IS NOT NULL AND P.Tussenvoegsel <> '', CONCAT(' ', P.Tussenvoegsel), ''), 
            ' ', 
            P.Achternaam
        ) AS 'Vertegenwoordiger',
        C.Email AS 'E-mailadres',
        C.Mobiel,
        CONCAT(
            C.Straat, ' ', 
            C.Huisnummer, 
            IF(C.Toevoeging IS NOT NULL AND C.Toevoeging <> '', CONCAT(' ', C.Toevoeging), '')
        ) AS 'Adres',
        C.Woonplaats,
        C.Postcode
    FROM Gezin G
    INNER JOIN Persoon P 
        ON G.Id = P.GezinId 
        AND P.IsVertegenwoordiger = 1
    INNER JOIN ContactPerGezin CPG 
        ON G.Id = CPG.GezinId
    INNER JOIN Contact C 
        ON CPG.ContactId = C.Id
    WHERE G.IsActief = 1
    AND (p_Postcode IS NULL OR C.Postcode = p_Postcode)
    ORDER BY G.Naam ASC;
END
SQL);

        DB::unprepared(<<<'SQL'
CREATE PROCEDURE sp_getKlantDetails(IN p_GezinId INT)
BEGIN
    SELECT
        G.Id AS GezinId,
        P.Id AS PersoonId,
        P.Voornaam,
        P.Tussenvoegsel,
        P.Achternaam,
        DATE_FORMAT(P.Geboortedatum, '%d-%m-%Y') AS Geboortedatum,
        'Klant' AS TypePersoon,
        IF(P.IsVertegenwoordiger = 1, 'Ja', 'Nee') AS Vertegenwoordiger,
        C.Straat AS Straatnaam,
        C.Huisnummer,
        C.Toevoeging,
        C.Postcode,
        C.Woonplaats,
        C.Email,
        C.Mobiel
    FROM Gezin G
    INNER JOIN Persoon P ON G.Id = P.GezinId AND P.IsVertegenwoordiger = 1
    INNER JOIN ContactPerGezin CPG ON G.Id = CPG.GezinId
    INNER JOIN Contact C ON CPG.ContactId = C.Id
    WHERE G.Id = p_GezinId
    LIMIT 1;
END
SQL);

        DB::unprepared(<<<'SQL'
CREATE PROCEDURE sp_updateKlantContact(
    IN p_GezinId INT,
    IN p_Straatnaam VARCHAR(50),
    IN p_Huisnummer VARCHAR(10),
    IN p_Toevoeging VARCHAR(10),
    IN p_Postcode VARCHAR(10),
    IN p_Woonplaats VARCHAR(50),
    IN p_Email VARCHAR(100),
    IN p_Mobiel VARCHAR(20)
)
BEGIN
    DECLARE v_ContactId INT;

    SELECT ContactId INTO v_ContactId
    FROM ContactPerGezin
    WHERE GezinId = p_GezinId
    LIMIT 1;

    UPDATE Contact
    SET Straat = p_Straatnaam,
        Huisnummer = p_Huisnummer,
        Toevoeging = p_Toevoeging,
        Postcode = p_Postcode,
        Woonplaats = p_Woonplaats,
        Email = p_Email,
        Mobiel = p_Mobiel
    WHERE Id = v_ContactId;
END
SQL);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS getAllPakketten');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_getAllKlanten');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_getKlantDetails');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_updateKlantContact');
    }
};
