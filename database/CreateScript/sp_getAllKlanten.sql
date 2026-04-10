USE VoedselbankMaaskantje;

DROP PROCEDURE IF EXISTS sp_getAllKlanten;

DELIMITER //

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
END //

DELIMITER ;