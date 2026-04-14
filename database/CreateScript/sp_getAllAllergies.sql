USE maaskantje_sprint2;

DROP PROCEDURE IF EXISTS sp_getAllAllergies;

DELIMITER $$

CREATE PROCEDURE sp_getAllAllergies()
BEGIN
    SELECT 
        Id,
        Naam
    FROM Allergie;
END $$

DELIMITER ;

CALL sp_getAllAllergies();