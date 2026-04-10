DROP PROCEDURE IF EXISTS sp_getAllAllergies;

DELIMITER $$

CREATE PROCEDURE sp_getAllAllergies()
BEGIN
    SELECT
        a.Id
        
