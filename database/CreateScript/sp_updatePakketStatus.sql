USE VoedselbankMaaskantje;

DROP PROCEDURE IF EXISTS updatePakketStatus;

DELIMITER //

CREATE PROCEDURE updatePakketStatus(
    IN p_PakketNummer INT, 
    IN p_NieuweStatus VARCHAR(50)
)
BEGIN
    -- Update de status van het pakket gebaseerd op het unieke pakketnummer
    UPDATE Voedselpakket 
    SET Status = p_NieuweStatus 
    WHERE PakketNummer = p_PakketNummer;
END //

DELIMITER ;