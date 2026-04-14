USE maaskantje_sprint2;

DROP PROCEDURE IF EXISTS sp_updateAllergy;

DELIMITER $$

CREATE PROCEDURE sp_updateAllergy(
    IN p_PersoonId INT,
    IN p_AllergieId INT,
    IN p_GezinId INT
)
BEGIN
    DECLARE v_Count INT;
    -- Controleer of de persoon al een allergie heeft
    SELECT COUNT(*) INTO v_Count
    FROM AllergiePerPersoon
    WHERE PersoonId = p_PersoonId;

    IF v_Count > 0 THEN
        -- Update de bestaande allergie
        UPDATE AllergiePerPersoon
        SET AllergieId = p_AllergieId
        WHERE PersoonId = p_PersoonId;
    ELSE
        -- Voeg een nieuwe allergie toe voor de persoon
        INSERT INTO AllergiePerPersoon (PersoonId, AllergieId, GezinId)
        VALUES (p_PersoonId, p_AllergieId,p_GezinId);
    END IF;
END $$
DELIMITER ;

CALL sp_updateAllergy(14, 2, 1);