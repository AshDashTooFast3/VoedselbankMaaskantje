USE VoedselbankMaaskantje;

DROP PROCEDURE IF EXISTS sp_getLeverancierTypes;

DELIMITER //

CREATE PROCEDURE sp_getLeverancierTypes()
BEGIN
    SELECT LeverancierType
    FROM (
        SELECT DISTINCT LeverancierType
        FROM Leverancier
        WHERE IsActief = 1

        UNION

        SELECT 'Donor' AS LeverancierType
    ) AS TypeLijst
    WHERE LeverancierType IS NOT NULL
      AND LeverancierType <> ''
    ORDER BY LeverancierType ASC;
END //

DELIMITER ;
