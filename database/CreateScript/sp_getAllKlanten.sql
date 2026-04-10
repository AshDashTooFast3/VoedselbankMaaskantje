USE VoedselbankMaaskantje;

DROP PROCEDURE IF EXISTS sp_getAllKlanten;

DELIMITER //

CREATE PROCEDURE sp_getAllKlanten()
BEGIN
    SELECT 
        G.Naam AS 'Naam Gezin',
        CONCAT(P.Voornaam, 
               IF(P.Tussenvoegsel IS NOT NULL AND P.Tussenvoegsel <> '', CONCAT(' ', P.Tussenvoegsel), ''), 
               ' ', P.Achternaam) AS 'Vertegenwoordiger',
        C.Email AS 'E-mailadres',
        C.Mobiel,
        CONCAT(C.Straat, ' ', C.Huisnummer, IFNULL(C.Toevoeging, '')) AS 'Adres',
        C.Woonplaats
    FROM Gezin G
    -- Haal alleen de persoon op die de vertegenwoordiger is
    INNER JOIN Persoon P ON G.Id = P.GezinId AND P.IsVertegenwoordiger = 1
    -- Koppel het gezin aan de contactgegevens
    INNER JOIN ContactPerGezin CPG ON G.Id = CPG.GezinId
    INNER JOIN Contact C ON CPG.ContactId = C.Id
    WHERE G.IsActief = 1
    ORDER BY G.Naam ASC;
END //

DELIMITER ;