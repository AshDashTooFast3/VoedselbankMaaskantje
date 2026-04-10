USE VoedselbankMaaskantje;

DROP PROCEDURE IF EXISTS updatePakketStatus;

DELIMITER //

CREATE PROCEDURE updatePakketStatus(
    IN p_PakketNummer INT, 
    IN p_NieuweStatus VARCHAR(50)
)
BEGIN
    -- Alleen actieve gezinnen mogen een pakketstatuswijziging krijgen
    UPDATE Voedselpakket vp
    INNER JOIN Gezin g ON g.Id = vp.GezinId
    SET vp.Status = p_NieuweStatus
    WHERE vp.PakketNummer = p_PakketNummer
      AND g.IsActief = 1;
END //

DELIMITER ;