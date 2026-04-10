<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_getAllLeveranciers');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_getLeverancierTypes');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_getLeverancierDetails');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_getLeverancierProducten');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_updateLeverancier');

        DB::unprepared(<<<'SQL'
CREATE PROCEDURE sp_getAllLeveranciers(IN p_LeverancierType VARCHAR(50))
BEGIN
    SELECT
        l.Id AS LeverancierId,
        l.Naam,
        l.Contactpersoon,
        c.Email,
        c.Mobiel,
        l.LeverancierNummer,
        l.LeverancierType
    FROM Leverancier l
    LEFT JOIN ContactPerLeverancier cpl
        ON cpl.LeverancierId = l.Id
    LEFT JOIN Contact c
        ON c.Id = cpl.ContactId
    WHERE l.IsActief = 1
      AND (p_LeverancierType IS NULL OR p_LeverancierType = '' OR l.LeverancierType = p_LeverancierType)
    ORDER BY l.Naam ASC;
END
SQL);

        DB::unprepared(<<<'SQL'
CREATE PROCEDURE sp_getLeverancierTypes()
BEGIN
    SELECT DISTINCT LeverancierType
    FROM Leverancier
    WHERE IsActief = 1
    ORDER BY LeverancierType ASC;
END
SQL);

        DB::unprepared(<<<'SQL'
CREATE PROCEDURE sp_getLeverancierDetails(IN p_LeverancierId INT)
BEGIN
    SELECT
        l.Id AS LeverancierId,
        l.Naam,
        l.Contactpersoon,
        l.LeverancierNummer,
        l.LeverancierType,
        c.Id AS ContactId,
        c.Email,
        c.Mobiel,
        c.Straat,
        c.Huisnummer,
        c.Toevoeging,
        c.Postcode,
        c.Woonplaats
    FROM Leverancier l
    LEFT JOIN ContactPerLeverancier cpl
        ON cpl.LeverancierId = l.Id
    LEFT JOIN Contact c
        ON c.Id = cpl.ContactId
    WHERE l.Id = p_LeverancierId
    LIMIT 1;
END
SQL);

        DB::unprepared(<<<'SQL'
CREATE PROCEDURE sp_getLeverancierProducten(IN p_LeverancierId INT)
BEGIN
    SELECT
        p.Naam,
        p.Barcode,
        p.Status,
        ppl.DatumAangeleverd,
        ppl.DatumEerstVolgendeLevering
    FROM ProductPerLeverancier ppl
    INNER JOIN Product p
        ON p.Id = ppl.ProductId
    WHERE ppl.LeverancierId = p_LeverancierId
    ORDER BY p.Naam ASC;
END
SQL);

        DB::unprepared(<<<'SQL'
CREATE PROCEDURE sp_updateLeverancier(
    IN p_LeverancierId INT,
    IN p_Naam VARCHAR(150),
    IN p_Contactpersoon VARCHAR(150),
    IN p_LeverancierNummer VARCHAR(50),
    IN p_LeverancierType VARCHAR(50),
    IN p_Email VARCHAR(150),
    IN p_Mobiel VARCHAR(50)
)
BEGIN
    DECLARE v_ContactId INT;

    UPDATE Leverancier
    SET Naam = p_Naam,
        Contactpersoon = p_Contactpersoon,
        LeverancierNummer = p_LeverancierNummer,
        LeverancierType = p_LeverancierType,
        DatumGewijzigd = NOW(6)
    WHERE Id = p_LeverancierId;

    SELECT ContactId INTO v_ContactId
    FROM ContactPerLeverancier
    WHERE LeverancierId = p_LeverancierId
    LIMIT 1;

    IF v_ContactId IS NOT NULL THEN
        UPDATE Contact
        SET Email = p_Email,
            Mobiel = p_Mobiel,
            DatumGewijzigd = NOW(6)
        WHERE Id = v_ContactId;
    END IF;
END
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_getAllLeveranciers');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_getLeverancierTypes');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_getLeverancierDetails');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_getLeverancierProducten');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_updateLeverancier');
    }
};
