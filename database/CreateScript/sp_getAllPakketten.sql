DELIMITER //

CREATE PROCEDURE getAllPakketten()
BEGIN
    SELECT 
        g.Code AS GezinCode,
        g.Naam AS GezinNaam,
        vp.PakketNummer,
        vp.DatumSamenstelling,
        vp.DatumUitgifte,
        vp.Status AS PakketStatus,
        COUNT(ppv.ProductId) AS AantalVerschillendeProducten,
        IFNULL(SUM(ppv.AantalProductEenheden), 0) AS TotaalProductEenheden
    FROM Voedselpakket vp
    -- Join 1: Koppel het voedselpakket aan het bijbehorende gezin
    INNER JOIN Gezin g 
        ON vp.GezinId = g.Id
    -- Join 2: Haal de productregels van het pakket op (LEFT JOIN voor lege pakketten)
    LEFT JOIN ProductPerVoedselpakket ppv 
        ON vp.Id = ppv.VoedselpakketId
    -- Join 3: Koppel aan de producttabel om te valideren dat het product bestaat
    LEFT JOIN Product pr 
        ON ppv.ProductId = pr.Id
    GROUP BY 
        g.Id, 
        vp.Id
    ORDER BY 
        vp.DatumSamenstelling DESC, 
        g.Naam ASC;
END //

DELIMITER ;