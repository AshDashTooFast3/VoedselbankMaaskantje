USE maaskantje_sprint2;

DROP PROCEDURE IF EXISTS sp_getAllFamilies;

DELIMITER $$

CREATE PROCEDURE sp_getAllFamilies()
BEGIN
    SELECT
        g.Id,
        g.Naam,
        g.Omschrijving,
        g.AantalVolwassenen,
        g.AantalKinderen,
        g.AantalBabys,
        p.IsVertegenwoordiger
    FROM Gezin g
    INNER JOIN Persoon p ON g.Id = p.GezinId;
END $$

CALL sp_getAllFamilies();