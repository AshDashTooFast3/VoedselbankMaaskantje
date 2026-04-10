USE maaskantje_sprint2;
DROP PROCEDURE IF EXISTS sp_getAllergiesInFamily;
DELIMITER $$
CREATE PROCEDURE sp_getAllergiesInFamily(
    IN p_GezinId INT
)
BEGIN
    SELECT 
        a.Id AS AllergieId,
        g.Id AS GezinId,
        CONCAT_WS(' ', p.Voornaam, p.Tussenvoegsel, p.Achternaam) AS Naam,
        p.TypePersoon,
        p.IsVertegenwoordiger,
        a.Naam AS Allergie,
        pa.AllergieId,
        p.Id AS PersoonId,
        g.Naam AS GezinsNaam,
        g.Omschrijving,
        (SELECT COUNT(*) FROM Persoon WHERE GezinId = p_GezinId) AS TotaalPersonen
        FROM Persoon p
        LEFT JOIN AllergiePerPersoon pa ON p.Id = pa.PersoonId
        LEFT JOIN Allergie a ON pa.AllergieId = a.Id
        JOIN Gezin g ON p.GezinId = g.Id
        WHERE p.GezinId = p_GezinId;
END$$
DELIMITER ;

CALL sp_getAllergiesInFamily(1);