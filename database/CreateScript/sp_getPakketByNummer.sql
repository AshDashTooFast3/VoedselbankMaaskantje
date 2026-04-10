USE VoedselbankMaaskantje;

DROP PROCEDURE IF EXISTS getPakketByNummer;

DELIMITER //

CREATE PROCEDURE getPakketByNummer(IN p_PakketNummer INT)
BEGIN
    SELECT
        vp.PakketNummer,
        vp.Status,
        vp.GezinId,
        g.IsActief
    FROM Voedselpakket vp
    LEFT JOIN Gezin g ON g.Id = vp.GezinId
    WHERE vp.PakketNummer = p_PakketNummer;
END //

DELIMITER ;
