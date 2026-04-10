USE maaskantje_sprint2;

DROP PROCEDURE IF EXISTS sp_getAllFamiliesBySelectedAllergy;

DELIMITER $$

CREATE PROCEDURE sp_getAllFamiliesBySelectedAllergy(
    p_AllergieNaam VARCHAR(255)
)
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
    INNER JOIN Persoon p ON g.Id = p.GezinId
    INNER JOIN AllergiePerPersoon ap ON p.Id = ap.PersoonId
    INNER JOIN Allergie a ON ap.AllergieId = a.Id
    WHERE a.Naam = p_AllergieNaam COLLATE utf8mb4_unicode_ci;
END $$

DELIMITER ;

CALL sp_getAllFamiliesBySelectedAllergy('Pindas');

        
