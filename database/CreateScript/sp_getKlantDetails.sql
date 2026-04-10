USE VoedselbankMaaskantje;

-- 1. SP om details van één klant op te halen
DROP PROCEDURE IF EXISTS sp_getKlantDetails;
DELIMITER //
CREATE PROCEDURE sp_getKlantDetails(IN p_GezinId INT)
BEGIN
    SELECT 
        G.Id AS GezinId,
        P.Id AS PersoonId,
        P.Voornaam, P.Tussenvoegsel, P.Achternaam, 
        DATE_FORMAT(P.Geboortedatum, '%d-%m-%Y') AS Geboortedatum,
        'Klant' AS TypePersoon, -- Hardcoded of uit een tabel TypePersoon
        IF(P.IsVertegenwoordiger = 1, 'Ja', 'Nee') AS Vertegenwoordiger,
        C.Straat AS Straatnaam, C.Huisnummer, C.Toevoeging, 
        C.Postcode, C.Woonplaats, C.Email, C.Mobiel
    FROM Gezin G
    INNER JOIN Persoon P ON G.Id = P.GezinId AND P.IsVertegenwoordiger = 1
    INNER JOIN ContactPerGezin CPG ON G.Id = CPG.GezinId
    INNER JOIN Contact C ON CPG.ContactId = C.Id
    WHERE G.Id = p_GezinId LIMIT 1;
END //
DELIMITER ;

-- 2. SP om de contactgegevens te updaten
DROP PROCEDURE IF EXISTS sp_updateKlantContact;
DELIMITER //
CREATE PROCEDURE sp_updateKlantContact(
    IN p_GezinId INT,
    IN p_Straatnaam VARCHAR(50), IN p_Huisnummer VARCHAR(10), IN p_Toevoeging VARCHAR(10),
    IN p_Postcode VARCHAR(10), IN p_Woonplaats VARCHAR(50), 
    IN p_Email VARCHAR(100), IN p_Mobiel VARCHAR(20)
)
BEGIN
    -- Vind het ContactId dat bij dit gezin hoort
    DECLARE v_ContactId INT;
    SELECT ContactId INTO v_ContactId FROM ContactPerGezin WHERE GezinId = p_GezinId LIMIT 1;
    
    -- Update de gegevens in de Contact tabel
    UPDATE Contact 
    SET Straat = p_Straatnaam, Huisnummer = p_Huisnummer, Toevoeging = p_Toevoeging,
        Postcode = p_Postcode, Woonplaats = p_Woonplaats, Email = p_Email, Mobiel = p_Mobiel
    WHERE Id = v_ContactId;
END //
DELIMITER ;