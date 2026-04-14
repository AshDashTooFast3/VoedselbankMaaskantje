USE VoedselbankMaaskantje;

DROP PROCEDURE IF EXISTS sp_getAllLeveranciers;

DELIMITER //

CREATE PROCEDURE sp_getAllLeveranciers(
    IN p_LeverancierType VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
)
BEGIN
    SELECT
        l.Id AS LeverancierId,
        l.Naam,
        l.Contactpersoon,
        c.Email,
        c.Mobiel,
        l.LeverancierNummer,
        l.LeverancierType
    FROM Leverancier l
    LEFT JOIN ContactPerLeverancier cpl
        ON cpl.LeverancierId = l.Id
    LEFT JOIN Contact c
        ON c.Id = cpl.ContactId
        WHERE l.IsActief = 1
            AND (
                p_LeverancierType IS NULL
                OR p_LeverancierType = ''
                OR l.LeverancierType COLLATE utf8mb4_unicode_ci = p_LeverancierType COLLATE utf8mb4_unicode_ci
            )
    ORDER BY l.Naam ASC;
END //

DELIMITER ;
