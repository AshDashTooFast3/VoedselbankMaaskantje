USE maaskantje_sprint2;

DROP PROCEDURE IF EXISTS sp_getAllFamilies;

DELIMITER $$

CREATE PROCEDURE sp_getAllFamilies()
BEGIN
    SELECT
        g.Id AS GezinId,
        a.Id AS AllergieId,
        g.Naam,
        g.Omschrijving,
        g.AantalVolwassenen,
        g.AantalKinderen,
        g.AantalBabys,
        p.IsVertegenwoordiger
    FROM Gezin g
    INNER JOIN Persoon p ON g.Id = p.GezinId
    INNER JOIN AllergiePerPersoon ap ON p.Id = ap.PersoonId
    INNER JOIN Allergie a ON ap.AllergieId = a.Id;
END $$

CALL sp_getAllFamilies();