Drop database if exists VoedselbankMaaskantje;
CREATE DATABASE IF NOT EXISTS VoedselbankMaaskantje;
USE VoedselbankMaaskantje;
 
-- --------------------------------------------------------
-- 1. Gezin
-- --------------------------------------------------------
CREATE TABLE Gezin (
    Id INT PRIMARY KEY,
    Naam VARCHAR(255) NOT NULL,
    Code VARCHAR(50) NOT NULL,
    Omschrijving VARCHAR(255),
    AantalVolwassenen INT,
    AantalKinderen INT,
    AantalBabys INT,
    TotaalAantalPersonen INT,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6)
);
 
INSERT INTO Gezin (Id, Naam, Code, Omschrijving, AantalVolwassenen, AantalKinderen, AantalBabys, TotaalAantalPersonen) VALUES
(1, 'ZevenhuizenGezin', 'G0001', 'Bijstandsgezin', 2, 2, 0, 4),
(2, 'BergkampGezin', 'G0002', 'Bijstandsgezin', 2, 1, 1, 4),
(3, 'HeuvelGezin', 'G0003', 'Bijstandsgezin', 2, 0, 0, 2),
(4, 'ScherderGezin', 'G0004', 'Bijstandsgezin', 1, 2, 0, 3),
(5, 'DeJongGezin', 'G0005', 'Bijstandsgezin', 1, 1, 0, 2),
(6, 'VanderBergGezin', 'G0006', 'AlleenGaande', 1, 0, 0, 1);
 
-- --------------------------------------------------------
-- 2. Persoon
-- --------------------------------------------------------
CREATE TABLE Persoon (
    Id INT PRIMARY KEY,
    GezinId INT NOT NULL,
    Voornaam VARCHAR(100) NOT NULL,
    Tussenvoegsel VARCHAR(50) NULL,
    Achternaam VARCHAR(100) NOT NULL,
    Geboortedatum DATE,
    TypePersoon VARCHAR(100),
    IsVertegenwoordiger BIT,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
    FOREIGN KEY (GezinId) REFERENCES Gezin(Id)
);
 
INSERT INTO Persoon (Id, GezinId, Voornaam, Tussenvoegsel, Achternaam, Geboortedatum, TypePersoon, IsVertegenwoordiger) VALUES
(1, 1, 'Hans', 'van', 'Leeuwen', '1958-02-12', 'Manager', 0),
(2, 1, 'Jan', 'van der', 'Sluijs', '1993-04-30', 'Medewerker', 0),
(3, 2, 'Herman', 'den', 'Duiker', '1989-08-30', 'Vrijwilliger', 0),
(4, 1, 'Johan', 'van', 'Zevenhuizen', '1990-05-20', 'Klant', 1),
(5, 1, 'Sarah', 'den', 'Dolder', '1985-03-23', 'Klant', 0),
(6, 1, 'Theo', 'van', 'Zevenhuizen', '2015-03-08', 'Klant', 0),
(7, 1, 'Jantien', 'van', 'Zevenhuizen', '2016-09-20', 'Klant', 0),
(8, 2, 'Arjan', NULL, 'Bergkamp', '1968-07-12', 'Klant', 1),
(9, 2, 'Janneke', NULL, 'Sanders', '1969-05-11', 'Klant', 0),
(10, 2, 'Stein', NULL, 'Bergkamp', '2011-02-02', 'Klant', 0),
(11, 2, 'Judith', NULL, 'Bergkamp', '2026-02-05', 'Klant', 0),
(12, 3, 'Mazin', 'van', 'Vliet', '1968-08-18', 'Klant', 1),
(13, 3, 'Selma', 'van de', 'Heuvel', '1965-09-04', 'Klant', 0),
(14, 4, 'Eva', NULL, 'Scherder', '2000-04-07', 'Klant', 1),
(15, 4, 'Felicia', NULL, 'Scherder', '2025-11-29', 'Klant', 0),
(16, 4, 'Devin', NULL, 'Scherder', '2026-03-01', 'Klant', 0),
(17, 5, 'Frieda', 'de', 'Jong', '1980-09-04', 'Klant', 1),
(18, 5, 'Simeon', 'de', 'Jong', '2018-05-23', 'Klant', 0),
(19, 6, 'Hanna', 'van der', 'Berg', '1999-09-09', 'Klant', 1);
 
-- --------------------------------------------------------
-- 3. Gebruiker
-- --------------------------------------------------------
CREATE TABLE Gebruiker (
    Id INT PRIMARY KEY,
    PersoonId INT NOT NULL,
    InlogNaam VARCHAR(100) NOT NULL,
    Gebruikersnaam VARCHAR(100) NOT NULL,
    Wachtwoord VARCHAR(255) NOT NULL,
    IsIngelogd BIT,
    Ingelogd DATETIME,
    Uitgelogd DATETIME NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
    FOREIGN KEY (PersoonId) REFERENCES Persoon(Id)
);
 
INSERT INTO Gebruiker (Id, PersoonId, InlogNaam, Gebruikersnaam, Wachtwoord, IsIngelogd, Ingelogd, Uitgelogd) VALUES
(1, 1, 'Hans', 'hans@maaskantje.nl', '$2y$10$296RtyZZqzEwNU9yyi16axedDDKfsuykbvo1/AXVOvwCp/DL6zKfGI', 1, '2026-04-10 09:03:06', NULL),
(2, 2, 'Jan', 'jan@maaskantje.nl', '$2y$10$296RtyZZqzEwNU9yyi16axedDDKfsuykbvo1/AXVOvwCp/DL3zKfGI', 0, '2026-04-09 15:13:23', '2026-04-09 15:23:46'),
(3, 3, 'Herman', 'herman@maaskantje.nl', '$2y$10$296RtyZZqzEwNU9yyi16axedDDKfsuykbvo1/AXVOvwCp/DL9zKfGI', 1, '2026-04-08 12:05:20', NULL);
 
-- --------------------------------------------------------
-- 4. Rol
-- --------------------------------------------------------
CREATE TABLE Rol (
    Id INT PRIMARY KEY,
    Naam VARCHAR(100) NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6)
);
 
INSERT INTO Rol (Id, Naam) VALUES
(1, 'Manager'),
(2, 'Medewerker'),
(3, 'Vrijwilliger');
 
-- --------------------------------------------------------
-- 5. RolPerGebruiker
-- --------------------------------------------------------
CREATE TABLE RolPerGebruiker (
    Id INT PRIMARY KEY,
    GebruikerId INT NOT NULL,
    RolId INT NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id),
    FOREIGN KEY (RolId) REFERENCES Rol(Id)
);
 
INSERT INTO RolPerGebruiker (Id, GebruikerId, RolId) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3);
 
-- --------------------------------------------------------
-- 6. Allergie
-- --------------------------------------------------------
CREATE TABLE Allergie (
    Id INT PRIMARY KEY,
    Naam VARCHAR(100) NOT NULL,
    Omschrijving VARCHAR(255),
    AnafylactischRisico VARCHAR(50),
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6)
);
 
INSERT INTO Allergie (Id, Naam, Omschrijving, AnafylactischRisico) VALUES
(1, 'Gluten', 'Allergisch voor gluten', 'zeerlaag'),
(2, 'Pindas', 'Allergisch voor pindas', 'Hoog'),
(3, 'Schaaldieren', 'Allergisch voor schaaldieren', 'RedelijkHoog'),
(4, 'Hazelnoten', 'Allergisch voor hazelnoten', 'laag'),
(5, 'Lactose', 'Allergisch voor lactose', 'Zeerlaag'),
(6, 'Soja', 'Allergisch voor soja', 'Zeerlaag');
 
-- --------------------------------------------------------
-- 7. AllergiePerPersoon
-- --------------------------------------------------------
CREATE TABLE AllergiePerPersoon (
    Id INT PRIMARY KEY,
    PersoonId INT NOT NULL,
    AllergieId INT NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
    FOREIGN KEY (PersoonId) REFERENCES Persoon(Id),
    FOREIGN KEY (AllergieId) REFERENCES Allergie(Id)
);
 
INSERT INTO AllergiePerPersoon (Id, PersoonId, AllergieId) VALUES
(1, 4, 1),
(2, 5, 2),
(3, 6, 3),
(4, 7, 4),
(5, 8, 3),
(6, 9, 2),
(7, 10, 5),
(8, 12, 2),
(9, 13, 4),
(10, 14, 1),
(11, 15, 3),
(12, 16, 5),
(13, 17, 1),
(14, 17, 2),
(15, 18, 4),
(16, 19, 4);
 
-- --------------------------------------------------------
-- 8. Categorie
-- --------------------------------------------------------
CREATE TABLE Categorie (
    Id INT PRIMARY KEY,
    Naam VARCHAR(100) NOT NULL,
    Omschrijving VARCHAR(255),
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6)
);
 
INSERT INTO Categorie (Id, Naam, Omschrijving) VALUES
(1, 'AGF', 'Aardappelen groente en fruit'),
(2, 'KV', 'Kaas en vleeswaren'),
(3, 'ZPE', 'Zuivel plantaardig en eieren'),
(4, 'BB', 'Bakkerij en Banket'),
(5, 'FSKT', 'Frisdranken, sappen, koffie en thee'),
(6, 'PRW', 'Pasta, rijst en wereldkeuken'),
(7, 'SSKO', 'Soepen, sauzen, kruiden en olie'),
(8, 'SKCC', 'Snoep, koek, chips en chocolade'),
(9, 'BVH', 'Baby, verzorging en hygiëne');
 
-- --------------------------------------------------------
-- 9. Product
-- --------------------------------------------------------
CREATE TABLE Product (
    Id INT PRIMARY KEY,
    CategorieId INT NOT NULL,
    Naam VARCHAR(100) NOT NULL,
    SoortAllergie VARCHAR(100) NULL,
    Barcode VARCHAR(50) NOT NULL,
    Houdbaarheidsdatum DATE,
    Omschrijving VARCHAR(255),
    Status VARCHAR(100),
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
    FOREIGN KEY (CategorieId) REFERENCES Categorie(Id)
);
 
INSERT INTO Product (Id, CategorieId, Naam, SoortAllergie, Barcode, Houdbaarheidsdatum, Omschrijving, Status) VALUES
(1, 1, 'Aardappel', NULL, '8719587321239', '2026-05-12', 'Kruimige aardappel', 'OpVoorraad'),
(2, 1, 'Aardappel', NULL, '8719587321239', '2026-05-26', 'Kruimige aardappel', 'OpVoorraad'),
(3, 1, 'Ui', NULL, '8719437321335', '2026-05-02', 'Gele ui', 'NietOpVoorraad'),
(4, 1, 'Appel', NULL, '8719486321332', '2026-05-16', 'Granny Smith', 'NietLeverbaar'),
(5, 1, 'Appel', NULL, '8719486321332', '2026-05-23', 'Granny Smith', 'NietLeverbaar'),
(6, 1, 'Banaan', 'Banaan', '8719484321336', '2026-05-12', 'Biologische Banaan', 'OverHoudbaarheidsDatum'),
(7, 1, 'Banaan', 'Banaan', '8719484321336', '2026-05-19', 'Biologische Banaan', 'OverHoudbaarheidsDatum'),
(8, 2, 'Kaas', 'Lactose', '8719487421338', '2026-05-19', 'Jonge Kaas', 'OpVoorraad'),
(9, 2, 'Rosbief', NULL, '8719487421331', '2026-05-23', 'Rundvlees', 'OpVoorraad'),
(10, 3, 'Melk', 'Lactose', '8719447321332', '2026-05-23', 'Halfvolle melk', 'OpVoorraad'),
(11, 3, 'Margarine', NULL, '8719486321336', '2026-05-02', 'Plantaardige boter', 'OpVoorraad'),
(12, 3, 'Ei', 'Eier', '8719487421334', '2026-05-04', 'Scharrelei', 'OpVoorraad'),
(13, 4, 'Brood', 'Gluten', '8719487721331', '2026-05-07', 'Volkoren brood', 'OpVoorraad'),
(14, 4, 'Gevulde Koek', 'Amandel', '8719483321333', '2026-05-04', 'Banketbakkers kwaliteit', 'NietOpVoorraad'),
(15, 5, 'Fristi', 'Lactose', '8719487121331', '2026-05-28', 'Frisdrank', 'OpVoorraad'),
(16, 5, 'Appelsap', NULL, '8719487521335', '2026-05-19', '100% vruchtensap', 'OpVoorraad'),
(17, 5, 'Koffie', 'Caffeine', '8719487381338', '2026-05-23', 'Arabica koffie', 'OverHoudbaarheidsDatum'),
(18, 5, 'Thee', 'Theine', '8719487329339', '2026-05-02', 'Ceylon thee', 'OpVoorraad'),
(19, 6, 'Pasta', 'Gluten', '8719487321334', '2026-05-16', 'Macaroni', 'NietLeverbaar'),
(20, 6, 'Rijst', NULL, '8719487331332', '2026-05-25', 'Basmati Rijst', 'OpVoorraad'),
(21, 6, 'Knorr Nasi Mix', NULL, '8719487351335', '2026-05-13', 'Nasi kruiden', 'OpVoorraad'),
(22, 7, 'Tomatensoep', NULL, '8719487371337', '2026-05-23', 'Romige tomatensoep', 'OpVoorraad'),
(23, 7, 'Tomatensaus', NULL, '8719487341334', '2026-05-21', 'Pizza saus', 'NietOpVoorraad'),
(24, 7, 'Peterselie', NULL, '8719487321636', '2026-05-31', 'Verse kruidenpot', 'OpVoorraad'),
(25, 8, 'Olie', NULL, '8719487327337', '2026-05-11', 'Olijfolie', 'OpVoorraad'),
(26, 8, 'Mars', NULL, '8719487324334', '2026-05-11', 'Snoep', 'OpVoorraad'),
(27, 8, 'Biscuit', NULL, '8719487311331', '2026-05-07', 'San Francisco biscuit', 'OpVoorraad'),
(28, 8, 'Paprika Chips', NULL, '8719487321839', '2026-05-22', 'Ribbelchips paprika', 'OpVoorraad'),
(29, 8, 'Chocolade reep', 'Cacao', '8719487321533', '2026-05-21', 'Tony Chocolonely', 'OpVoorraad');
 
-- --------------------------------------------------------
-- 10. Eetwens
-- --------------------------------------------------------
CREATE TABLE Eetwens (
    Id INT PRIMARY KEY,
    Naam VARCHAR(100) NOT NULL,
    Omschrijving VARCHAR(255),
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6)
);
 
INSERT INTO Eetwens (Id, Naam, Omschrijving) VALUES
(1, 'GeenVarken', 'Geen Varkensvlees'),
(2, 'Veganistisch', 'Geen zuivelproducten en vlees'),
(3, 'Vegetarisch', 'Geen vlees'),
(4, 'Omnivoor', 'Geen beperkingen');
 
-- --------------------------------------------------------
-- 11. EetwensPerGezin
-- --------------------------------------------------------
CREATE TABLE EetwensPerGezin (
    Id INT PRIMARY KEY,
    GezinId INT NOT NULL,
    EetwensId INT NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
    FOREIGN KEY (GezinId) REFERENCES Gezin(Id),
    FOREIGN KEY (EetwensId) REFERENCES Eetwens(Id)
);
 
INSERT INTO EetwensPerGezin (Id, GezinId, EetwensId) VALUES
(1, 1, 2),
(2, 2, 4),
(3, 3, 4),
(4, 4, 3),
(5, 5, 2);
 
-- --------------------------------------------------------
-- 12. Contact
-- --------------------------------------------------------
CREATE TABLE Contact (
    Id INT PRIMARY KEY,
    Straat VARCHAR(150) NOT NULL,
    Huisnummer INT NOT NULL,
    Toevoeging VARCHAR(50) NULL,
    Postcode VARCHAR(10) NOT NULL,
    Woonplaats VARCHAR(100) NOT NULL,
    Email VARCHAR(150),
    Mobiel VARCHAR(50),
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6)
);
 
INSERT INTO Contact (Id, Straat, Huisnummer, Toevoeging, Postcode, Woonplaats, Email, Mobiel) VALUES
(1, 'Prinses Irenestraat', 12, 'A', '5271TH', 'Maaskantje', 'j.van.zevenhuizen@gmail.com', '+31 623456123'),
(2, 'Gibraltarstraat', 234, NULL, '5271TJ', 'Maaskantje', 'a.bergkamp@hotmail.com', '+31 623456123'),
(3, 'Der Kinderenstraat', 456, 'Bis', '5271TH', 'Maaskantje', 's.van.de.heuvel@gmail.com', '+31 623456123'),
(4, 'Nachtegaalstraat', 233, 'A', '5271TJ', 'Maaskantje', 'e.scherder@gmail.com', '+31 623456123'),
(5, 'Bertram Russellstraat', 45, NULL, '5271ZE', 'Maaskantje', 'f.de.jong@hotmail.com', '+31 623456123'),
(6, 'Leonardo Da VinciHof', 34, NULL, '5271ZE', 'Maaskantje', 'h.van.der.berg@gmail.com', '+31 623456123'),
(7, 'Siegfried Knutsenlaan', 234, NULL, '5271ZE', 'Maaskantje', 'r.ter.weijden@ah.nl', '+31 623456123'),
(8, 'Theo de Bokstraat', 256, NULL, '5271ZH', 'Maaskantje', 'l.pastor@gmail.com', '+31 623456123'),
(9, 'Meester van Leerhof', 2, 'A', '5271ZH', 'Maaskantje', 'm.yazidi@gemeenteutrecht.nl', '+31 623456123'),
(10, 'van Wemelenplantsoen', 300, NULL, '5271TH', 'Maaskantje', 'b.van.driel@gmail.com', '+31 623456123'),
(11, 'Teefingenhof', 20, NULL, '5271TH', 'Maaskantje', 'j.pastorius@gmail.com', '+31 623456356'),
(12, 'veldhoen', 31, NULL, '5271ZE', 'Maaskantje', 's.dollaard@gmail.com', '+31 623452314'),
(13, 'ScheringaDreef', 37, NULL, '5271ZE', 'Vught', 'j.blokker@gemeentevught.nl', '+31 623452314');
 
-- --------------------------------------------------------
-- 13. ContactPerGezin
-- --------------------------------------------------------
CREATE TABLE ContactPerGezin (
    Id INT PRIMARY KEY,
    GezinId INT NOT NULL,
    ContactId INT NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
    FOREIGN KEY (GezinId) REFERENCES Gezin(Id),
    FOREIGN KEY (ContactId) REFERENCES Contact(Id)
);
 
INSERT INTO ContactPerGezin (Id, GezinId, ContactId) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 6);
 
-- --------------------------------------------------------
-- 14. Leverancier
-- --------------------------------------------------------
CREATE TABLE Leverancier (
    Id INT PRIMARY KEY,
    Naam VARCHAR(150) NOT NULL,
    Contactpersoon VARCHAR(150),
    LeverancierNummer VARCHAR(50),
    LeverancierType VARCHAR(50),
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6)
);
 
INSERT INTO Leverancier (Id, Naam, Contactpersoon, LeverancierNummer, LeverancierType) VALUES
(1, 'Albert Heijn', 'Ruud ter Weijden', 'L0001', 'Bedrijf'),
(2, 'Albertus Kerk', 'Leo Pastor', 'L0002', 'Instelling'),
(3, 'Gemeente Utrecht', 'Mohammed Yazidi', 'L0003', 'Overheid'),
(4, 'Boerderij Meerhoven', 'Bertus van Driel', 'L0004', 'Particulier'),
(6, 'Vomar', 'Jaco Pastorius', 'L0006', 'Bedrijf'),
(7, 'DekaMarkt', 'Sil den Dollaard', 'L0007', 'Bedrijf'),
(8, 'Gemeente Vught', 'Jan Blokker', 'L0008', 'Overheid');
 
-- --------------------------------------------------------
-- 15. ContactPerLeverancier
-- --------------------------------------------------------
CREATE TABLE ContactPerLeverancier (
    Id INT PRIMARY KEY,
    LeverancierId INT NOT NULL,
    ContactId INT NOT NULL,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
    FOREIGN KEY (LeverancierId) REFERENCES Leverancier(Id),
    FOREIGN KEY (ContactId) REFERENCES Contact(Id)
);
 
INSERT INTO ContactPerLeverancier (Id, LeverancierId, ContactId) VALUES
(1, 1, 7),
(2, 2, 8),
(3, 3, 9),
(4, 4, 10),
(5, 6, 11),
(6, 7, 12),
(7, 8, 13);
 
-- --------------------------------------------------------
-- 16. Magazijn
-- --------------------------------------------------------
CREATE TABLE Magazijn (
    Id INT PRIMARY KEY,
    Ontvangstdatum DATE,
    Uitleveringsdatum DATE NULL,
    Verpakkingseenheid VARCHAR(50),
    Aantal DECIMAL(10,2),
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6)
);
 
INSERT INTO Magazijn (Id, Ontvangstdatum, Uitleveringsdatum, Verpakkingseenheid, Aantal) VALUES
(1, '2026-03-12', NULL, '5 kg', 20),
(2, '2026-04-02', NULL, '2.5 kg', 40),
(3, '2026-03-16', NULL, '1 kg', 30),
(4, '2026-04-08', NULL, '1.5 kg', 25),
(5, '2026-04-06', NULL, '4 stuks', 75),
(6, '2026-03-12', NULL, '1 kg/tros', 60),
(7, '2026-03-20', NULL, '2 kg/tros', 200),
(8, '2026-04-02', NULL, '200 g', 45),
(9, '2026-04-04', NULL, '100 g', 60),
(10, '2026-04-07', NULL, '1 liter', 120),
(11, '2026-04-01', NULL, '250 g', 80),
(12, '2026-03-18', NULL, '6 stuks', 120),
(13, '2026-03-19', NULL, '800 g', 220),
(14, '2026-03-10', NULL, '1 stuk', 130),
(15, '2026-05-20', NULL, '150 ml', 72),
(16, '2026-03-18', NULL, '1 l', 12),
(17, '2026-03-11', NULL, '250 g', 300),
(18, '2026-04-02', NULL, '25 zakjes', 280),
(19, '2026-04-09', NULL, '500 g', 330),
(20, '2026-04-03', NULL, '1 kg', 34),
(21, '2026-04-02', NULL, '50 g', 23),
(22, '2026-03-16', NULL, '1 l', 46),
(23, '2026-03-14', NULL, '250 ml', 98),
(24, '2026-04-07', NULL, '1 potje', 56),
(25, '2026-03-17', NULL, '1 l', 210),
(26, '2026-04-05', NULL, '4 stuks', 24),
(27, '2026-04-07', NULL, '300 g', 87),
(28, '2026-04-06', NULL, '200 g', 230),
(29, '2026-04-08', NULL, '80 g', 30);
 
-- --------------------------------------------------------
-- 17. ProductPerMagazijn
-- --------------------------------------------------------
CREATE TABLE ProductPerMagazijn (
    Id INT PRIMARY KEY,
    ProductId INT NOT NULL,
    MagazijnId INT NOT NULL,
    Locatie VARCHAR(150),
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
    FOREIGN KEY (ProductId) REFERENCES Product(Id),
    FOREIGN KEY (MagazijnId) REFERENCES Magazijn(Id)
);
 
INSERT INTO ProductPerMagazijn (Id, ProductId, MagazijnId, Locatie) VALUES
(1, 1, 1, 'Berlicum'),
(2, 2, 2, 'Berlicum'),
(3, 3, 3, 'Rosmalen'),
(4, 4, 4, 'Berlicum'),
(5, 5, 5, 'Rosmalen'),
(6, 6, 6, 'Berlicum'),
(7, 7, 7, 'Rosmalen'),
(8, 8, 8, 'Sint-MichielsGestel'),
(9, 9, 9, 'Sint-MichielsGestel'),
(10, 10, 10, 'Middelrode'),
(11, 11, 11, 'Middelrode'),
(12, 12, 12, 'Middelrode'),
(13, 13, 13, 'Schijndel'),
(14, 14, 14, 'Schijndel'),
(15, 15, 15, 'Gemonde'),
(16, 16, 16, 'Gemonde'),
(17, 17, 17, 'Gemonde'),
(18, 18, 18, 'Gemonde'),
(19, 19, 19, 'Den Bosch'),
(20, 20, 20, 'Den Bosch'),
(21, 21, 21, 'Den Bosch'),
(22, 22, 22, 'Heeswijk Dinther'),
(23, 23, 23, 'Heeswijk Dinther'),
(24, 24, 24, 'Vught'),
(25, 25, 25, 'Vught'),
(26, 26, 26, 'Vught'),
(27, 27, 27, 'Vught'),
(28, 28, 28, 'Vught'),
(29, 29, 29, 'Vught');
 
-- --------------------------------------------------------
-- 18. ProductPerLeverancier
-- --------------------------------------------------------
CREATE TABLE ProductPerLeverancier (
    Id INT PRIMARY KEY,
    LeverancierId INT NOT NULL,
    ProductId INT NOT NULL,
    DatumAangeleverd DATE,
    DatumEerstVolgendeLevering DATE,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
    FOREIGN KEY (LeverancierId) REFERENCES Leverancier(Id),
    FOREIGN KEY (ProductId) REFERENCES Product(Id)
);
 
INSERT INTO ProductPerLeverancier (Id, LeverancierId, ProductId, DatumAangeleverd, DatumEerstVolgendeLevering) VALUES
(1, 4, 1, '2026-03-12', '2026-05-15'),
(2, 4, 2, '2026-04-02', '2026-05-05'),
(3, 2, 3, '2026-03-16', '2026-05-18'),
(4, 1, 4, '2026-04-08', '2026-05-11'),
(5, 4, 5, '2026-04-06', '2026-05-10'),
(6, 1, 6, '2026-03-12', '2026-05-15'),
(7, 4, 7, '2026-03-20', '2026-05-21'),
(8, 4, 8, '2026-04-02', '2026-05-08'),
(9, 4, 9, '2026-04-04', '2026-05-09'),
(10, 3, 10, '2026-04-07', '2026-05-11'),
(11, 3, 11, '2026-04-01', '2026-05-06'),
(12, 3, 12, '2026-03-18', '2026-05-20'),
(13, 3, 13, '2026-03-19', '2026-05-20'),
(14, 2, 14, '2026-04-10', '2026-05-12'),
(15, 2, 15, '2026-03-13', '2026-05-15'),
(16, 1, 16, '2026-03-18', '2026-05-21'),
(17, 1, 17, '2026-03-11', '2026-05-15'),
(18, 1, 18, '2026-04-02', '2026-05-06'),
(19, 1, 19, '2026-04-09', '2026-05-12'),
(20, 4, 20, '2026-04-03', '2026-05-06'),
(21, 2, 21, '2026-04-02', '2026-05-08'),
(22, 1, 22, '2026-03-16', '2026-05-19'),
(23, 3, 23, '2026-03-14', '2026-05-18'),
(24, 3, 24, '2026-04-07', '2026-05-15'),
(25, 1, 25, '2026-03-17', '2026-05-21'),
(26, 2, 26, '2026-04-05', '2026-05-12'),
(27, 1, 27, '2026-04-07', '2026-05-10'),
(28, 2, 28, '2026-04-06', '2026-05-09'),
(29, 3, 29, '2026-04-08', '2026-05-11');
 
-- --------------------------------------------------------
-- 19. Voedselpakket
-- --------------------------------------------------------
CREATE TABLE Voedselpakket (
    Id INT PRIMARY KEY,
    GezinId INT NOT NULL,
    PakketNummer INT NOT NULL,
    DatumSamenstelling DATE,
    DatumUitgifte DATE NULL,
    Status VARCHAR(100),
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
    FOREIGN KEY (GezinId) REFERENCES Gezin(Id)
);
 
INSERT INTO Voedselpakket (Id, GezinId, PakketNummer, DatumSamenstelling, DatumUitgifte, Status) VALUES
(1, 1, 1, '2026-03-21', '2026-03-21', 'Uitgereikt'),
(2, 1, 2, '2026-03-19', NULL, 'NietUitgereikt'),
(3, 1, 3, '2026-03-17', NULL, 'NietMeeringeschreven'),
(4, 2, 4, '2026-03-10', '2026-03-14', 'Uitgereikt'),
(5, 2, 5, '2026-03-18', '2026-03-20', 'Uitgereikt'),
(6, 2, 6, '2026-04-08', NULL, 'NietUitgereikt');
 
-- --------------------------------------------------------
-- 20. ProductPerVoedselpakket
-- --------------------------------------------------------
CREATE TABLE ProductPerVoedselpakket (
    Id INT PRIMARY KEY,
    VoedselpakketId INT NOT NULL,
    ProductId INT NOT NULL,
    AantalProductEenheden INT,
    IsActief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(255) NULL,
    DatumAangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6),
    DatumGewijzigd DATETIME(6) NOT NULL DEFAULT NOW(6) ON UPDATE NOW(6),
    FOREIGN KEY (VoedselpakketId) REFERENCES Voedselpakket(Id),
    FOREIGN KEY (ProductId) REFERENCES Product(Id)
);
 
INSERT INTO ProductPerVoedselpakket (Id, VoedselpakketId, ProductId, AantalProductEenheden) VALUES
(1, 1, 7, 1),
(2, 1, 8, 2),
(3, 1, 9, 1),
(4, 2, 12, 1),
(5, 2, 13, 2),
(6, 2, 14, 1),
(7, 3, 3, 1),
(8, 3, 4, 1),
(9, 4, 20, 1),
(10, 4, 19, 1),
(11, 4, 21, 1),
(12, 5, 24, 1),
(13, 5, 25, 1),
(14, 5, 26, 1),
(15, 6, 27, 1);