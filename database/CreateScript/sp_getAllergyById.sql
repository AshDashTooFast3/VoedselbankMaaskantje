USE maaskantje_sprint2;
DROP PROCEDURE IF EXISTS sp_getAllergyById;
DELIMITER $$
CREATE PROCEDURE sp_getAllergyById(
    IN p_PersoonId INT
)
BEGIN
    SELECT 
        a.Id AS AllergieId,
        a.Naam
    FROM Allergie a
    INNER JOIN AllergiePerPersoon app ON a.Id = app.AllergieId
    WHERE app.PersoonId = p_PersoonId;
END $$
DELIMITER ;

CALL sp_getAllergyById(14);