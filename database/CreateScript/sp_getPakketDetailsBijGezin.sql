USE VoedselbankMaaskantje;

DROP PROCEDURE IF EXISTS getPakketDetailsByGezin;

DELIMITER //

CREATE PROCEDURE getPakketDetailsByGezin(IN p_GezinId INT)
BEGIN
    SELECT 
        g.Naam,
        g.Omschrijving,
        g.TotaalAantalPersonen,
        vp.PakketNummer,
        vp.DatumSamenstelling,
        vp.DatumUitgifte,
        vp.Status,
        (SELECT COUNT(*) FROM ProductPerVoedselpakket ppv WHERE ppv.VoedselpakketId = vp.Id) AS AantalProducten
    FROM Gezin g
    LEFT JOIN Voedselpakket vp ON g.Id = vp.GezinId
    WHERE g.Id = p_GezinId
    ORDER BY vp.DatumSamenstelling DESC;
END //

DELIMITER ;