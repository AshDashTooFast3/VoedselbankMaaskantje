USE VoedselbankMaaskantje;

DROP PROCEDURE IF EXISTS sp_getLeverancierTypes;

DELIMITER //

CREATE PROCEDURE sp_getLeverancierTypes()
BEGIN
    SELECT DISTINCT LeverancierType
    FROM Leverancier
    WHERE IsActief = 1
    ORDER BY LeverancierType ASC;
END //

DELIMITER ;
