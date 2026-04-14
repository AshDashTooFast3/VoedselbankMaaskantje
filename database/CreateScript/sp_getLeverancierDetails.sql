USE VoedselbankMaaskantje;

DROP PROCEDURE IF EXISTS sp_getLeverancierDetails;
DROP PROCEDURE IF EXISTS sp_getLeverancierProducten;
DROP PROCEDURE IF EXISTS sp_getLeverancierProductVoorWijzigen;
DROP PROCEDURE IF EXISTS sp_updateProductHoudbaarheidsdatum;
DROP PROCEDURE IF EXISTS sp_updateLeverancier;

DELIMITER //

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
END //

CREATE PROCEDURE sp_getLeverancierProducten(IN p_LeverancierId INT)
BEGIN
    SELECT
        p.Id AS ProductId,
        p.Naam,
        p.SoortAllergie,
        p.Houdbaarheidsdatum,
        p.Barcode,
        p.Status,
        ppl.DatumAangeleverd,
        ppl.DatumEerstVolgendeLevering
    FROM ProductPerLeverancier ppl
    INNER JOIN Product p
        ON p.Id = ppl.ProductId
    WHERE ppl.LeverancierId = p_LeverancierId
    ORDER BY p.Naam ASC;
END //

CREATE PROCEDURE sp_getLeverancierProductVoorWijzigen(
    IN p_LeverancierId INT,
    IN p_ProductId INT
)
BEGIN
    SELECT
        p.Id AS ProductId,
        p.Naam,
        p.Houdbaarheidsdatum
    FROM ProductPerLeverancier ppl
    INNER JOIN Product p
        ON p.Id = ppl.ProductId
    WHERE ppl.LeverancierId = p_LeverancierId
      AND p.Id = p_ProductId
    LIMIT 1;
END //

CREATE PROCEDURE sp_updateProductHoudbaarheidsdatum(
    IN p_LeverancierId INT,
    IN p_ProductId INT,
    IN p_NieuweHoudbaarheidsdatum DATE
)
BEGIN
    DECLARE v_HuidigeDatum DATE;

    SELECT p.Houdbaarheidsdatum
    INTO v_HuidigeDatum
    FROM ProductPerLeverancier ppl
    INNER JOIN Product p
        ON p.Id = ppl.ProductId
    WHERE ppl.LeverancierId = p_LeverancierId
      AND p.Id = p_ProductId
    LIMIT 1;

    IF v_HuidigeDatum IS NULL THEN
        SELECT 0 AS IsGewijzigd, 'Product niet gevonden' AS Bericht;
    ELSEIF p_NieuweHoudbaarheidsdatum > DATE_ADD(v_HuidigeDatum, INTERVAL 7 DAY) THEN
        SELECT 0 AS IsGewijzigd, 'De houdbaarheidsdatum mag met maximaal 7 dagen worden verlengd' AS Bericht;
    ELSE
        UPDATE Product
        SET Houdbaarheidsdatum = p_NieuweHoudbaarheidsdatum,
            DatumGewijzigd = NOW(6)
        WHERE Id = p_ProductId;

        SELECT 1 AS IsGewijzigd, 'De houdbaarheidsdatum is gewijzigd' AS Bericht;
    END IF;
END //

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
END //

DELIMITER ;
