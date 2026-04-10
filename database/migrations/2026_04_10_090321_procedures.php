<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS getAllPakketten');
        DB::unprepared('DROP PROCEDURE IF EXISTS getPakketDetailsByGezin');
        DB::unprepared('DROP PROCEDURE IF EXISTS updatePakketStatus');
        DB::unprepared('DROP PROCEDURE IF EXISTS getPakketByNummer');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_getAllKlanten');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_getKlantDetails');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_updateKlantContact');

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

        DB::unprepared(<<<'SQL'
            CREATE PROCEDURE getPakketDetailsByGezin(IN p_GezinId INT)
            BEGIN
                SELECT
                    g.Naam,
                    g.Omschrijving,
                    g.TotaalAantalPersonen,
                    vp.PakketNummer,
                    vp.DatumSamenstelling,
                    vp.DatumUitgifte,
                    vp.Status,
                    (
                        SELECT COUNT(*)
                        FROM ProductPerVoedselpakket ppv
                        WHERE ppv.VoedselpakketId = vp.Id
                    ) AS AantalProducten
                FROM Gezin g
                LEFT JOIN Voedselpakket vp ON g.Id = vp.GezinId
                WHERE g.Id = p_GezinId
                ORDER BY vp.DatumSamenstelling DESC;
            END
        SQL);

        DB::unprepared(<<<'SQL'
            CREATE PROCEDURE updatePakketStatus(
                IN p_PakketNummer INT,
                IN p_NieuweStatus VARCHAR(50)
            )
            BEGIN
                UPDATE Voedselpakket vp
                INNER JOIN Gezin g ON g.Id = vp.GezinId
                SET vp.Status = p_NieuweStatus
                WHERE vp.PakketNummer = p_PakketNummer
                  AND g.IsActief = 1;
            END
        SQL);

        DB::unprepared(<<<'SQL'
            CREATE PROCEDURE getPakketByNummer(IN p_PakketNummer INT)
            BEGIN
                SELECT
                    vp.PakketNummer,
                    vp.Status,
                    vp.GezinId,
                    g.IsActief
                FROM Voedselpakket vp
                LEFT JOIN Gezin g ON g.Id = vp.GezinId
                WHERE vp.PakketNummer = p_PakketNummer;
            END
        SQL);

        DB::unprepared(<<<'SQL'
CREATE PROCEDURE sp_getAllKlanten(IN p_Postcode VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci)
BEGIN
    SELECT 
        G.Id AS GezinId, -- DIT IS DE NIEUWE REGEL DIE WE NODIG HEBBEN
        G.Naam AS 'Naam Gezin',

        CONCAT(P.Voornaam, IF(P.Tussenvoegsel IS NOT NULL, CONCAT(' ', P.Tussenvoegsel), ''), ' ', P.Achternaam) AS 'Vertegenwoordiger',

        C.Email AS 'E-mailadres',
        C.Mobiel,

        CONCAT(C.Straat, ' ', C.Huisnummer, IFNULL(C.Toevoeging, '')) AS 'Adres',

        C.Woonplaats,
        C.Postcode
    FROM Gezin G
    INNER JOIN Persoon P ON G.Id = P.GezinId AND P.IsVertegenwoordiger = 1
    INNER JOIN ContactPerGezin CPG ON G.Id = CPG.GezinId
    INNER JOIN Contact C ON CPG.ContactId = C.Id
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

    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS getAllPakketten');
        DB::unprepared('DROP PROCEDURE IF EXISTS getPakketDetailsByGezin');
        DB::unprepared('DROP PROCEDURE IF EXISTS updatePakketStatus');
        DB::unprepared('DROP PROCEDURE IF EXISTS getPakketByNummer');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_getAllKlanten');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_getKlantDetails');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_updateKlantContact');
    }
};
