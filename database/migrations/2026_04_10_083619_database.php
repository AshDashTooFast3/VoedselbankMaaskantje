<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Gezin', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->string('Naam', 255);
            $table->string('Code', 50);
            $table->string('Omschrijving', 255)->nullable();
            $table->integer('AantalVolwassenen')->nullable();
            $table->integer('AantalKinderen')->nullable();
            $table->integer('AantalBabys')->nullable();
            $table->integer('TotaalAantalPersonen')->nullable();
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();
        });

        DB::table('Gezin')->insert([
            ['Id' => 1, 'Naam' => 'ZevenhuizenGezin', 'Code' => 'G0001', 'Omschrijving' => 'Bijstandsgezin', 'AantalVolwassenen' => 2, 'AantalKinderen' => 2, 'AantalBabys' => 0, 'TotaalAantalPersonen' => 4],
            ['Id' => 2, 'Naam' => 'BergkampGezin', 'Code' => 'G0002', 'Omschrijving' => 'Bijstandsgezin', 'AantalVolwassenen' => 2, 'AantalKinderen' => 1, 'AantalBabys' => 1, 'TotaalAantalPersonen' => 4],
            ['Id' => 3, 'Naam' => 'HeuvelGezin', 'Code' => 'G0003', 'Omschrijving' => 'Bijstandsgezin', 'AantalVolwassenen' => 2, 'AantalKinderen' => 0, 'AantalBabys' => 0, 'TotaalAantalPersonen' => 2],
            ['Id' => 4, 'Naam' => 'ScherderGezin', 'Code' => 'G0004', 'Omschrijving' => 'Bijstandsgezin', 'AantalVolwassenen' => 1, 'AantalKinderen' => 2, 'AantalBabys' => 0, 'TotaalAantalPersonen' => 3],
            ['Id' => 5, 'Naam' => 'DeJongGezin', 'Code' => 'G0005', 'Omschrijving' => 'Bijstandsgezin', 'AantalVolwassenen' => 1, 'AantalKinderen' => 1, 'AantalBabys' => 0, 'TotaalAantalPersonen' => 2],
            ['Id' => 6, 'Naam' => 'VanderBergGezin', 'Code' => 'G0006', 'Omschrijving' => 'AlleenGaande', 'AantalVolwassenen' => 1, 'AantalKinderen' => 0, 'AantalBabys' => 0, 'TotaalAantalPersonen' => 1],
        ]);

        Schema::create('Persoon', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->integer('GezinId');
            $table->string('Voornaam', 100);
            $table->string('Tussenvoegsel', 50)->nullable();
            $table->string('Achternaam', 100);
            $table->date('Geboortedatum')->nullable();
            $table->string('TypePersoon', 100)->nullable();
            $table->boolean('IsVertegenwoordiger')->nullable();
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();

            $table->foreign('GezinId')->references('Id')->on('Gezin');
        });

        DB::table('Persoon')->insert([
            ['Id' => 1, 'GezinId' => 1, 'Voornaam' => 'Hans', 'Tussenvoegsel' => 'van', 'Achternaam' => 'Leeuwen', 'Geboortedatum' => '1958-02-12', 'TypePersoon' => 'Manager', 'IsVertegenwoordiger' => 0],
            ['Id' => 2, 'GezinId' => 1, 'Voornaam' => 'Jan', 'Tussenvoegsel' => 'van der', 'Achternaam' => 'Sluijs', 'Geboortedatum' => '1993-04-30', 'TypePersoon' => 'Medewerker', 'IsVertegenwoordiger' => 0],
            ['Id' => 3, 'GezinId' => 2, 'Voornaam' => 'Herman', 'Tussenvoegsel' => 'den', 'Achternaam' => 'Duiker', 'Geboortedatum' => '1989-08-30', 'TypePersoon' => 'Vrijwilliger', 'IsVertegenwoordiger' => 0],
            ['Id' => 4, 'GezinId' => 1, 'Voornaam' => 'Johan', 'Tussenvoegsel' => 'van', 'Achternaam' => 'Zevenhuizen', 'Geboortedatum' => '1990-05-20', 'TypePersoon' => 'Klant', 'IsVertegenwoordiger' => 1],
            ['Id' => 5, 'GezinId' => 1, 'Voornaam' => 'Sarah', 'Tussenvoegsel' => 'den', 'Achternaam' => 'Dolder', 'Geboortedatum' => '1985-03-23', 'TypePersoon' => 'Klant', 'IsVertegenwoordiger' => 0],
            ['Id' => 6, 'GezinId' => 1, 'Voornaam' => 'Theo', 'Tussenvoegsel' => 'van', 'Achternaam' => 'Zevenhuizen', 'Geboortedatum' => '2015-03-08', 'TypePersoon' => 'Klant', 'IsVertegenwoordiger' => 0],
            ['Id' => 7, 'GezinId' => 1, 'Voornaam' => 'Jantien', 'Tussenvoegsel' => 'van', 'Achternaam' => 'Zevenhuizen', 'Geboortedatum' => '2016-09-20', 'TypePersoon' => 'Klant', 'IsVertegenwoordiger' => 0],
            ['Id' => 8, 'GezinId' => 2, 'Voornaam' => 'Arjan', 'Tussenvoegsel' => null, 'Achternaam' => 'Bergkamp', 'Geboortedatum' => '1968-07-12', 'TypePersoon' => 'Klant', 'IsVertegenwoordiger' => 1],
            ['Id' => 9, 'GezinId' => 2, 'Voornaam' => 'Janneke', 'Tussenvoegsel' => null, 'Achternaam' => 'Sanders', 'Geboortedatum' => '1969-05-11', 'TypePersoon' => 'Klant', 'IsVertegenwoordiger' => 0],
            ['Id' => 10, 'GezinId' => 2, 'Voornaam' => 'Stein', 'Tussenvoegsel' => null, 'Achternaam' => 'Bergkamp', 'Geboortedatum' => '2011-02-02', 'TypePersoon' => 'Klant', 'IsVertegenwoordiger' => 0],
            ['Id' => 11, 'GezinId' => 2, 'Voornaam' => 'Judith', 'Tussenvoegsel' => null, 'Achternaam' => 'Bergkamp', 'Geboortedatum' => '2026-02-05', 'TypePersoon' => 'Klant', 'IsVertegenwoordiger' => 0],
            ['Id' => 12, 'GezinId' => 3, 'Voornaam' => 'Mazin', 'Tussenvoegsel' => 'van', 'Achternaam' => 'Vliet', 'Geboortedatum' => '1968-08-18', 'TypePersoon' => 'Klant', 'IsVertegenwoordiger' => 1],
            ['Id' => 13, 'GezinId' => 3, 'Voornaam' => 'Selma', 'Tussenvoegsel' => 'van de', 'Achternaam' => 'Heuvel', 'Geboortedatum' => '1965-09-04', 'TypePersoon' => 'Klant', 'IsVertegenwoordiger' => 0],
            ['Id' => 14, 'GezinId' => 4, 'Voornaam' => 'Eva', 'Tussenvoegsel' => null, 'Achternaam' => 'Scherder', 'Geboortedatum' => '2000-04-07', 'TypePersoon' => 'Klant', 'IsVertegenwoordiger' => 1],
            ['Id' => 15, 'GezinId' => 4, 'Voornaam' => 'Felicia', 'Tussenvoegsel' => null, 'Achternaam' => 'Scherder', 'Geboortedatum' => '2025-11-29', 'TypePersoon' => 'Klant', 'IsVertegenwoordiger' => 0],
            ['Id' => 16, 'GezinId' => 4, 'Voornaam' => 'Devin', 'Tussenvoegsel' => null, 'Achternaam' => 'Scherder', 'Geboortedatum' => '2026-03-01', 'TypePersoon' => 'Klant', 'IsVertegenwoordiger' => 0],
            ['Id' => 17, 'GezinId' => 5, 'Voornaam' => 'Frieda', 'Tussenvoegsel' => 'de', 'Achternaam' => 'Jong', 'Geboortedatum' => '1980-09-04', 'TypePersoon' => 'Klant', 'IsVertegenwoordiger' => 1],
            ['Id' => 18, 'GezinId' => 5, 'Voornaam' => 'Simeon', 'Tussenvoegsel' => 'de', 'Achternaam' => 'Jong', 'Geboortedatum' => '2018-05-23', 'TypePersoon' => 'Klant', 'IsVertegenwoordiger' => 0],
            ['Id' => 19, 'GezinId' => 6, 'Voornaam' => 'Hanna', 'Tussenvoegsel' => 'van der', 'Achternaam' => 'Berg', 'Geboortedatum' => '1999-09-09', 'TypePersoon' => 'Klant', 'IsVertegenwoordiger' => 1],
        ]);

        Schema::create('Gebruiker', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->integer('PersoonId');
            $table->string('InlogNaam', 100);
            $table->string('Gebruikersnaam', 100);
            $table->string('Wachtwoord', 255);
            $table->boolean('IsIngelogd')->nullable();
            $table->dateTime('Ingelogd')->nullable();
            $table->dateTime('Uitgelogd')->nullable();
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();

            $table->foreign('PersoonId')->references('Id')->on('Persoon');
        });

        DB::table('Gebruiker')->insert([
            ['Id' => 1, 'PersoonId' => 1, 'InlogNaam' => 'Hans', 'Gebruikersnaam' => 'hans@maaskantje.nl', 'Wachtwoord' => '$2y$10$296RtyZZqzEwNU9yyi16axedDDKfsuykbvo1/AXVOvwCp/DL6zKfGI', 'IsIngelogd' => 1, 'Ingelogd' => '2026-04-10 09:03:06', 'Uitgelogd' => null],
            ['Id' => 2, 'PersoonId' => 2, 'InlogNaam' => 'Jan', 'Gebruikersnaam' => 'jan@maaskantje.nl', 'Wachtwoord' => '$2y$10$296RtyZZqzEwNU9yyi16axedDDKfsuykbvo1/AXVOvwCp/DL3zKfGI', 'IsIngelogd' => 0, 'Ingelogd' => '2026-04-09 15:13:23', 'Uitgelogd' => '2026-04-09 15:23:46'],
            ['Id' => 3, 'PersoonId' => 3, 'InlogNaam' => 'Herman', 'Gebruikersnaam' => 'herman@maaskantje.nl', 'Wachtwoord' => '$2y$10$296RtyZZqzEwNU9yyi16axedDDKfsuykbvo1/AXVOvwCp/DL9zKfGI', 'IsIngelogd' => 1, 'Ingelogd' => '2026-04-08 12:05:20', 'Uitgelogd' => null],
        ]);

        Schema::create('Rol', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->string('Naam', 100);
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();
        });

        DB::table('Rol')->insert([
            ['Id' => 1, 'Naam' => 'Manager'],
            ['Id' => 2, 'Naam' => 'Medewerker'],
            ['Id' => 3, 'Naam' => 'Vrijwilliger'],
        ]);

        Schema::create('RolPerGebruiker', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->integer('GebruikerId');
            $table->integer('RolId');
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();

            $table->foreign('GebruikerId')->references('Id')->on('Gebruiker');
            $table->foreign('RolId')->references('Id')->on('Rol');
        });

        DB::table('RolPerGebruiker')->insert([
            ['Id' => 1, 'GebruikerId' => 1, 'RolId' => 1],
            ['Id' => 2, 'GebruikerId' => 2, 'RolId' => 2],
            ['Id' => 3, 'GebruikerId' => 3, 'RolId' => 3],
        ]);

        Schema::create('Allergie', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->string('Naam', 100);
            $table->string('Omschrijving', 255)->nullable();
            $table->string('AnafylactischRisico', 50)->nullable();
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();
        });

        DB::table('Allergie')->insert([
            ['Id' => 1, 'Naam' => 'Gluten', 'Omschrijving' => 'Allergisch voor gluten', 'AnafylactischRisico' => 'zeerlaag'],
            ['Id' => 2, 'Naam' => 'Pindas', 'Omschrijving' => 'Allergisch voor pindas', 'AnafylactischRisico' => 'Hoog'],
            ['Id' => 3, 'Naam' => 'Schaaldieren', 'Omschrijving' => 'Allergisch voor schaaldieren', 'AnafylactischRisico' => 'RedelijkHoog'],
            ['Id' => 4, 'Naam' => 'Hazelnoten', 'Omschrijving' => 'Allergisch voor hazelnoten', 'AnafylactischRisico' => 'laag'],
            ['Id' => 5, 'Naam' => 'Lactose', 'Omschrijving' => 'Allergisch voor lactose', 'AnafylactischRisico' => 'Zeerlaag'],
            ['Id' => 6, 'Naam' => 'Soja', 'Omschrijving' => 'Allergisch voor soja', 'AnafylactischRisico' => 'Zeerlaag'],
        ]);

        Schema::create('AllergiePerPersoon', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->integer('PersoonId');
            $table->integer('AllergieId');
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();

            $table->foreign('PersoonId')->references('Id')->on('Persoon');
            $table->foreign('AllergieId')->references('Id')->on('Allergie');
        });

        DB::table('AllergiePerPersoon')->insert([
            ['Id' => 1, 'PersoonId' => 4, 'AllergieId' => 1],
            ['Id' => 2, 'PersoonId' => 5, 'AllergieId' => 2],
            ['Id' => 3, 'PersoonId' => 6, 'AllergieId' => 3],
            ['Id' => 4, 'PersoonId' => 7, 'AllergieId' => 4],
            ['Id' => 5, 'PersoonId' => 8, 'AllergieId' => 3],
            ['Id' => 6, 'PersoonId' => 9, 'AllergieId' => 2],
            ['Id' => 7, 'PersoonId' => 10, 'AllergieId' => 5],
            ['Id' => 8, 'PersoonId' => 12, 'AllergieId' => 2],
            ['Id' => 9, 'PersoonId' => 13, 'AllergieId' => 4],
            ['Id' => 10, 'PersoonId' => 14, 'AllergieId' => 1],
            ['Id' => 11, 'PersoonId' => 15, 'AllergieId' => 3],
            ['Id' => 12, 'PersoonId' => 16, 'AllergieId' => 5],
            ['Id' => 13, 'PersoonId' => 17, 'AllergieId' => 1],
            ['Id' => 14, 'PersoonId' => 17, 'AllergieId' => 2],
            ['Id' => 15, 'PersoonId' => 18, 'AllergieId' => 4],
            ['Id' => 16, 'PersoonId' => 19, 'AllergieId' => 4],
        ]);

        Schema::create('Categorie', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->string('Naam', 100);
            $table->string('Omschrijving', 255)->nullable();
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();
        });

        DB::table('Categorie')->insert([
            ['Id' => 1, 'Naam' => 'AGF', 'Omschrijving' => 'Aardappelen groente en fruit'],
            ['Id' => 2, 'Naam' => 'KV', 'Omschrijving' => 'Kaas en vleeswaren'],
            ['Id' => 3, 'Naam' => 'ZPE', 'Omschrijving' => 'Zuivel plantaardig en eieren'],
            ['Id' => 4, 'Naam' => 'BB', 'Omschrijving' => 'Bakkerij en Banket'],
            ['Id' => 5, 'Naam' => 'FSKT', 'Omschrijving' => 'Frisdranken, sappen, koffie en thee'],
            ['Id' => 6, 'Naam' => 'PRW', 'Omschrijving' => 'Pasta, rijst en wereldkeuken'],
            ['Id' => 7, 'Naam' => 'SSKO', 'Omschrijving' => 'Soepen, sauzen, kruiden en olie'],
            ['Id' => 8, 'Naam' => 'SKCC', 'Omschrijving' => 'Snoep, koek, chips en chocolade'],
            ['Id' => 9, 'Naam' => 'BVH', 'Omschrijving' => 'Baby, verzorging en hygiëne'],
        ]);

        Schema::create('Product', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->integer('CategorieId');
            $table->string('Naam', 100);
            $table->string('SoortAllergie', 100)->nullable();
            $table->string('Barcode', 50);
            $table->date('Houdbaarheidsdatum')->nullable();
            $table->string('Omschrijving', 255)->nullable();
            $table->string('Status', 100)->nullable();
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();

            $table->foreign('CategorieId')->references('Id')->on('Categorie');
        });

        DB::table('Product')->insert([
            ['Id' => 1, 'CategorieId' => 1, 'Naam' => 'Aardappel', 'SoortAllergie' => null, 'Barcode' => '8719587321239', 'Houdbaarheidsdatum' => '2026-05-12', 'Omschrijving' => 'Kruimige aardappel', 'Status' => 'OpVoorraad'],
            ['Id' => 2, 'CategorieId' => 1, 'Naam' => 'Aardappel', 'SoortAllergie' => null, 'Barcode' => '8719587321239', 'Houdbaarheidsdatum' => '2026-05-26', 'Omschrijving' => 'Kruimige aardappel', 'Status' => 'OpVoorraad'],
            ['Id' => 3, 'CategorieId' => 1, 'Naam' => 'Ui', 'SoortAllergie' => null, 'Barcode' => '8719437321335', 'Houdbaarheidsdatum' => '2026-05-02', 'Omschrijving' => 'Gele ui', 'Status' => 'NietOpVoorraad'],
            ['Id' => 4, 'CategorieId' => 1, 'Naam' => 'Appel', 'SoortAllergie' => null, 'Barcode' => '8719486321332', 'Houdbaarheidsdatum' => '2026-05-16', 'Omschrijving' => 'Granny Smith', 'Status' => 'NietLeverbaar'],
            ['Id' => 5, 'CategorieId' => 1, 'Naam' => 'Appel', 'SoortAllergie' => null, 'Barcode' => '8719486321332', 'Houdbaarheidsdatum' => '2026-05-23', 'Omschrijving' => 'Granny Smith', 'Status' => 'NietLeverbaar'],
            ['Id' => 6, 'CategorieId' => 1, 'Naam' => 'Banaan', 'SoortAllergie' => 'Banaan', 'Barcode' => '8719484321336', 'Houdbaarheidsdatum' => '2026-05-12', 'Omschrijving' => 'Biologische Banaan', 'Status' => 'OverHoudbaarheidsDatum'],
            ['Id' => 7, 'CategorieId' => 1, 'Naam' => 'Banaan', 'SoortAllergie' => 'Banaan', 'Barcode' => '8719484321336', 'Houdbaarheidsdatum' => '2026-05-19', 'Omschrijving' => 'Biologische Banaan', 'Status' => 'OverHoudbaarheidsDatum'],
            ['Id' => 8, 'CategorieId' => 2, 'Naam' => 'Kaas', 'SoortAllergie' => 'Lactose', 'Barcode' => '8719487421338', 'Houdbaarheidsdatum' => '2026-05-19', 'Omschrijving' => 'Jonge Kaas', 'Status' => 'OpVoorraad'],
            ['Id' => 9, 'CategorieId' => 2, 'Naam' => 'Rosbief', 'SoortAllergie' => null, 'Barcode' => '8719487421331', 'Houdbaarheidsdatum' => '2026-05-23', 'Omschrijving' => 'Rundvlees', 'Status' => 'OpVoorraad'],
            ['Id' => 10, 'CategorieId' => 3, 'Naam' => 'Melk', 'SoortAllergie' => 'Lactose', 'Barcode' => '8719447321332', 'Houdbaarheidsdatum' => '2026-05-23', 'Omschrijving' => 'Halfvolle melk', 'Status' => 'OpVoorraad'],
            ['Id' => 11, 'CategorieId' => 3, 'Naam' => 'Margarine', 'SoortAllergie' => null, 'Barcode' => '8719486321336', 'Houdbaarheidsdatum' => '2026-05-02', 'Omschrijving' => 'Plantaardige boter', 'Status' => 'OpVoorraad'],
            ['Id' => 12, 'CategorieId' => 3, 'Naam' => 'Ei', 'SoortAllergie' => 'Eier', 'Barcode' => '8719487421334', 'Houdbaarheidsdatum' => '2026-05-04', 'Omschrijving' => 'Scharrelei', 'Status' => 'OpVoorraad'],
            ['Id' => 13, 'CategorieId' => 4, 'Naam' => 'Brood', 'SoortAllergie' => 'Gluten', 'Barcode' => '8719487721331', 'Houdbaarheidsdatum' => '2026-05-07', 'Omschrijving' => 'Volkoren brood', 'Status' => 'OpVoorraad'],
            ['Id' => 14, 'CategorieId' => 4, 'Naam' => 'Gevulde Koek', 'SoortAllergie' => 'Amandel', 'Barcode' => '8719483321333', 'Houdbaarheidsdatum' => '2026-05-04', 'Omschrijving' => 'Banketbakkers kwaliteit', 'Status' => 'NietOpVoorraad'],
            ['Id' => 15, 'CategorieId' => 5, 'Naam' => 'Fristi', 'SoortAllergie' => 'Lactose', 'Barcode' => '8719487121331', 'Houdbaarheidsdatum' => '2026-05-28', 'Omschrijving' => 'Frisdrank', 'Status' => 'OpVoorraad'],
            ['Id' => 16, 'CategorieId' => 5, 'Naam' => 'Appelsap', 'SoortAllergie' => null, 'Barcode' => '8719487521335', 'Houdbaarheidsdatum' => '2026-05-19', 'Omschrijving' => '100% vruchtensap', 'Status' => 'OpVoorraad'],
            ['Id' => 17, 'CategorieId' => 5, 'Naam' => 'Koffie', 'SoortAllergie' => 'Caffeine', 'Barcode' => '8719487381338', 'Houdbaarheidsdatum' => '2026-05-23', 'Omschrijving' => 'Arabica koffie', 'Status' => 'OverHoudbaarheidsDatum'],
            ['Id' => 18, 'CategorieId' => 5, 'Naam' => 'Thee', 'SoortAllergie' => 'Theine', 'Barcode' => '8719487329339', 'Houdbaarheidsdatum' => '2026-05-02', 'Omschrijving' => 'Ceylon thee', 'Status' => 'OpVoorraad'],
            ['Id' => 19, 'CategorieId' => 6, 'Naam' => 'Pasta', 'SoortAllergie' => 'Gluten', 'Barcode' => '8719487321334', 'Houdbaarheidsdatum' => '2026-05-16', 'Omschrijving' => 'Macaroni', 'Status' => 'NietLeverbaar'],
            ['Id' => 20, 'CategorieId' => 6, 'Naam' => 'Rijst', 'SoortAllergie' => null, 'Barcode' => '8719487331332', 'Houdbaarheidsdatum' => '2026-05-25', 'Omschrijving' => 'Basmati Rijst', 'Status' => 'OpVoorraad'],
            ['Id' => 21, 'CategorieId' => 6, 'Naam' => 'Knorr Nasi Mix', 'SoortAllergie' => null, 'Barcode' => '8719487351335', 'Houdbaarheidsdatum' => '2026-05-13', 'Omschrijving' => 'Nasi kruiden', 'Status' => 'OpVoorraad'],
            ['Id' => 22, 'CategorieId' => 7, 'Naam' => 'Tomatensoep', 'SoortAllergie' => null, 'Barcode' => '8719487371337', 'Houdbaarheidsdatum' => '2026-05-23', 'Omschrijving' => 'Romige tomatensoep', 'Status' => 'OpVoorraad'],
            ['Id' => 23, 'CategorieId' => 7, 'Naam' => 'Tomatensaus', 'SoortAllergie' => null, 'Barcode' => '8719487341334', 'Houdbaarheidsdatum' => '2026-05-21', 'Omschrijving' => 'Pizza saus', 'Status' => 'NietOpVoorraad'],
            ['Id' => 24, 'CategorieId' => 7, 'Naam' => 'Peterselie', 'SoortAllergie' => null, 'Barcode' => '8719487321636', 'Houdbaarheidsdatum' => '2026-05-31', 'Omschrijving' => 'Verse kruidenpot', 'Status' => 'OpVoorraad'],
            ['Id' => 25, 'CategorieId' => 8, 'Naam' => 'Olie', 'SoortAllergie' => null, 'Barcode' => '8719487327337', 'Houdbaarheidsdatum' => '2026-05-11', 'Omschrijving' => 'Olijfolie', 'Status' => 'OpVoorraad'],
            ['Id' => 26, 'CategorieId' => 8, 'Naam' => 'Mars', 'SoortAllergie' => null, 'Barcode' => '8719487324334', 'Houdbaarheidsdatum' => '2026-05-11', 'Omschrijving' => 'Snoep', 'Status' => 'OpVoorraad'],
            ['Id' => 27, 'CategorieId' => 8, 'Naam' => 'Biscuit', 'SoortAllergie' => null, 'Barcode' => '8719487311331', 'Houdbaarheidsdatum' => '2026-05-07', 'Omschrijving' => 'San Francisco biscuit', 'Status' => 'OpVoorraad'],
            ['Id' => 28, 'CategorieId' => 8, 'Naam' => 'Paprika Chips', 'SoortAllergie' => null, 'Barcode' => '8719487321839', 'Houdbaarheidsdatum' => '2026-05-22', 'Omschrijving' => 'Ribbelchips paprika', 'Status' => 'OpVoorraad'],
            ['Id' => 29, 'CategorieId' => 8, 'Naam' => 'Chocolade reep', 'SoortAllergie' => 'Cacao', 'Barcode' => '8719487321533', 'Houdbaarheidsdatum' => '2026-05-21', 'Omschrijving' => 'Tony Chocolonely', 'Status' => 'OpVoorraad'],
        ]);

        Schema::create('Eetwens', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->string('Naam', 100);
            $table->string('Omschrijving', 255)->nullable();
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();
        });

        DB::table('Eetwens')->insert([
            ['Id' => 1, 'Naam' => 'GeenVarken', 'Omschrijving' => 'Geen Varkensvlees'],
            ['Id' => 2, 'Naam' => 'Veganistisch', 'Omschrijving' => 'Geen zuivelproducten en vlees'],
            ['Id' => 3, 'Naam' => 'Vegetarisch', 'Omschrijving' => 'Geen vlees'],
            ['Id' => 4, 'Naam' => 'Omnivoor', 'Omschrijving' => 'Geen beperkingen'],
        ]);

        Schema::create('EetwensPerGezin', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->integer('GezinId');
            $table->integer('EetwensId');
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();

            $table->foreign('GezinId')->references('Id')->on('Gezin');
            $table->foreign('EetwensId')->references('Id')->on('Eetwens');
        });

        DB::table('EetwensPerGezin')->insert([
            ['Id' => 1, 'GezinId' => 1, 'EetwensId' => 2],
            ['Id' => 2, 'GezinId' => 2, 'EetwensId' => 4],
            ['Id' => 3, 'GezinId' => 3, 'EetwensId' => 4],
            ['Id' => 4, 'GezinId' => 4, 'EetwensId' => 3],
            ['Id' => 5, 'GezinId' => 5, 'EetwensId' => 2],
        ]);

        Schema::create('Contact', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->string('Straat', 150);
            $table->integer('Huisnummer');
            $table->string('Toevoeging', 50)->nullable();
            $table->string('Postcode', 10);
            $table->string('Woonplaats', 100);
            $table->string('Email', 150)->nullable();
            $table->string('Mobiel', 50)->nullable();
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();
        });

        DB::table('Contact')->insert([
            ['Id' => 1, 'Straat' => 'Prinses Irenestraat', 'Huisnummer' => 12, 'Toevoeging' => 'A', 'Postcode' => '5271TH', 'Woonplaats' => 'Maaskantje', 'Email' => 'j.van.zevenhuizen@gmail.com', 'Mobiel' => '+31 623456123'],
            ['Id' => 2, 'Straat' => 'Gibraltarstraat', 'Huisnummer' => 234, 'Toevoeging' => null, 'Postcode' => '5271TJ', 'Woonplaats' => 'Maaskantje', 'Email' => 'a.bergkamp@hotmail.com', 'Mobiel' => '+31 623456123'],
            ['Id' => 3, 'Straat' => 'Der Kinderenstraat', 'Huisnummer' => 456, 'Toevoeging' => 'Bis', 'Postcode' => '5271TH', 'Woonplaats' => 'Maaskantje', 'Email' => 's.van.de.heuvel@gmail.com', 'Mobiel' => '+31 623456123'],
            ['Id' => 4, 'Straat' => 'Nachtegaalstraat', 'Huisnummer' => 233, 'Toevoeging' => 'A', 'Postcode' => '5271TJ', 'Woonplaats' => 'Maaskantje', 'Email' => 'e.scherder@gmail.com', 'Mobiel' => '+31 623456123'],
            ['Id' => 5, 'Straat' => 'Bertram Russellstraat', 'Huisnummer' => 45, 'Toevoeging' => null, 'Postcode' => '5271ZE', 'Woonplaats' => 'Maaskantje', 'Email' => 'f.de.jong@hotmail.com', 'Mobiel' => '+31 623456123'],
            ['Id' => 6, 'Straat' => 'Leonardo Da VinciHof', 'Huisnummer' => 34, 'Toevoeging' => null, 'Postcode' => '5271ZE', 'Woonplaats' => 'Maaskantje', 'Email' => 'h.van.der.berg@gmail.com', 'Mobiel' => '+31 623456123'],
            ['Id' => 7, 'Straat' => 'Siegfried Knutsenlaan', 'Huisnummer' => 234, 'Toevoeging' => null, 'Postcode' => '5271ZE', 'Woonplaats' => 'Maaskantje', 'Email' => 'r.ter.weijden@ah.nl', 'Mobiel' => '+31 623456123'],
            ['Id' => 8, 'Straat' => 'Theo de Bokstraat', 'Huisnummer' => 256, 'Toevoeging' => null, 'Postcode' => '5271ZH', 'Woonplaats' => 'Maaskantje', 'Email' => 'l.pastor@gmail.com', 'Mobiel' => '+31 623456123'],
            ['Id' => 9, 'Straat' => 'Meester van Leerhof', 'Huisnummer' => 2, 'Toevoeging' => 'A', 'Postcode' => '5271ZH', 'Woonplaats' => 'Maaskantje', 'Email' => 'm.yazidi@gemeenteutrecht.nl', 'Mobiel' => '+31 623456123'],
            ['Id' => 10, 'Straat' => 'van Wemelenplantsoen', 'Huisnummer' => 300, 'Toevoeging' => null, 'Postcode' => '5271TH', 'Woonplaats' => 'Maaskantje', 'Email' => 'b.van.driel@gmail.com', 'Mobiel' => '+31 623456123'],
            ['Id' => 11, 'Straat' => 'Teefingenhof', 'Huisnummer' => 20, 'Toevoeging' => null, 'Postcode' => '5271TH', 'Woonplaats' => 'Maaskantje', 'Email' => 'j.pastorius@gmail.com', 'Mobiel' => '+31 623456356'],
            ['Id' => 12, 'Straat' => 'veldhoen', 'Huisnummer' => 31, 'Toevoeging' => null, 'Postcode' => '5271ZE', 'Woonplaats' => 'Maaskantje', 'Email' => 's.dollaard@gmail.com', 'Mobiel' => '+31 623452314'],
            ['Id' => 13, 'Straat' => 'ScheringaDreef', 'Huisnummer' => 37, 'Toevoeging' => null, 'Postcode' => '5271ZE', 'Woonplaats' => 'Vught', 'Email' => 'j.blokker@gemeentevught.nl', 'Mobiel' => '+31 623452314'],
        ]);

        Schema::create('ContactPerGezin', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->integer('GezinId');
            $table->integer('ContactId');
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();

            $table->foreign('GezinId')->references('Id')->on('Gezin');
            $table->foreign('ContactId')->references('Id')->on('Contact');
        });

        DB::table('ContactPerGezin')->insert([
            ['Id' => 1, 'GezinId' => 1, 'ContactId' => 1],
            ['Id' => 2, 'GezinId' => 2, 'ContactId' => 2],
            ['Id' => 3, 'GezinId' => 3, 'ContactId' => 3],
            ['Id' => 4, 'GezinId' => 4, 'ContactId' => 4],
            ['Id' => 5, 'GezinId' => 5, 'ContactId' => 5],
            ['Id' => 6, 'GezinId' => 6, 'ContactId' => 6],
        ]);

        Schema::create('Leverancier', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->string('Naam', 150);
            $table->string('Contactpersoon', 150)->nullable();
            $table->string('LeverancierNummer', 50)->nullable();
            $table->string('LeverancierType', 50)->nullable();
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();
        });

        DB::table('Leverancier')->insert([
            ['Id' => 1, 'Naam' => 'Albert Heijn', 'Contactpersoon' => 'Ruud ter Weijden', 'LeverancierNummer' => 'L0001', 'LeverancierType' => 'Bedrijf'],
            ['Id' => 2, 'Naam' => 'Albertus Kerk', 'Contactpersoon' => 'Leo Pastor', 'LeverancierNummer' => 'L0002', 'LeverancierType' => 'Instelling'],
            ['Id' => 3, 'Naam' => 'Gemeente Utrecht', 'Contactpersoon' => 'Mohammed Yazidi', 'LeverancierNummer' => 'L0003', 'LeverancierType' => 'Overheid'],
            ['Id' => 4, 'Naam' => 'Boerderij Meerhoven', 'Contactpersoon' => 'Bertus van Driel', 'LeverancierNummer' => 'L0004', 'LeverancierType' => 'Particulier'],
            ['Id' => 5, 'Naam' => 'Jan van der Heijden', 'Contactpersoon' => 'Jan van der Heijden', 'LeverancierNummer' => 'L0005', 'LeverancierType' => 'Donor'],
            ['Id' => 6, 'Naam' => 'Vomar', 'Contactpersoon' => 'Jaco Pastorius', 'LeverancierNummer' => 'L0006', 'LeverancierType' => 'Bedrijf'],
            ['Id' => 7, 'Naam' => 'DekaMarkt', 'Contactpersoon' => 'Sil den Dollaard', 'LeverancierNummer' => 'L0007', 'LeverancierType' => 'Bedrijf'],
            ['Id' => 8, 'Naam' => 'Gemeente Vught', 'Contactpersoon' => 'Jan Blokker', 'LeverancierNummer' => 'L0008', 'LeverancierType' => 'Overheid'],
        ]);

        Schema::create('ContactPerLeverancier', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->integer('LeverancierId');
            $table->integer('ContactId');
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();

            $table->foreign('LeverancierId')->references('Id')->on('Leverancier');
            $table->foreign('ContactId')->references('Id')->on('Contact');
        });

        DB::table('ContactPerLeverancier')->insert([
            ['Id' => 1, 'LeverancierId' => 1, 'ContactId' => 7],
            ['Id' => 2, 'LeverancierId' => 2, 'ContactId' => 8],
            ['Id' => 3, 'LeverancierId' => 3, 'ContactId' => 9],
            ['Id' => 4, 'LeverancierId' => 4, 'ContactId' => 10],
            ['Id' => 5, 'LeverancierId' => 6, 'ContactId' => 11],
            ['Id' => 6, 'LeverancierId' => 7, 'ContactId' => 12],
            ['Id' => 7, 'LeverancierId' => 8, 'ContactId' => 13],
        ]);

        Schema::create('Magazijn', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->date('Ontvangstdatum')->nullable();
            $table->date('Uitleveringsdatum')->nullable();
            $table->string('Verpakkingseenheid', 50)->nullable();
            $table->decimal('Aantal', 10, 2)->nullable();
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();
        });

        DB::table('Magazijn')->insert([
            ['Id' => 1, 'Ontvangstdatum' => '2026-03-12', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '5 kg', 'Aantal' => 20],
            ['Id' => 2, 'Ontvangstdatum' => '2026-04-02', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '2.5 kg', 'Aantal' => 40],
            ['Id' => 3, 'Ontvangstdatum' => '2026-03-16', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '1 kg', 'Aantal' => 30],
            ['Id' => 4, 'Ontvangstdatum' => '2026-04-08', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '1.5 kg', 'Aantal' => 25],
            ['Id' => 5, 'Ontvangstdatum' => '2026-04-06', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '4 stuks', 'Aantal' => 75],
            ['Id' => 6, 'Ontvangstdatum' => '2026-03-12', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '1 kg/tros', 'Aantal' => 60],
            ['Id' => 7, 'Ontvangstdatum' => '2026-03-20', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '2 kg/tros', 'Aantal' => 200],
            ['Id' => 8, 'Ontvangstdatum' => '2026-04-02', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '200 g', 'Aantal' => 45],
            ['Id' => 9, 'Ontvangstdatum' => '2026-04-04', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '100 g', 'Aantal' => 60],
            ['Id' => 10, 'Ontvangstdatum' => '2026-04-07', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '1 liter', 'Aantal' => 120],
            ['Id' => 11, 'Ontvangstdatum' => '2026-04-01', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '250 g', 'Aantal' => 80],
            ['Id' => 12, 'Ontvangstdatum' => '2026-03-18', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '6 stuks', 'Aantal' => 120],
            ['Id' => 13, 'Ontvangstdatum' => '2026-03-19', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '800 g', 'Aantal' => 220],
            ['Id' => 14, 'Ontvangstdatum' => '2026-03-10', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '1 stuk', 'Aantal' => 130],
            ['Id' => 15, 'Ontvangstdatum' => '2026-05-20', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '150 ml', 'Aantal' => 72],
            ['Id' => 16, 'Ontvangstdatum' => '2026-03-18', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '1 l', 'Aantal' => 12],
            ['Id' => 17, 'Ontvangstdatum' => '2026-03-11', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '250 g', 'Aantal' => 300],
            ['Id' => 18, 'Ontvangstdatum' => '2026-04-02', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '25 zakjes', 'Aantal' => 280],
            ['Id' => 19, 'Ontvangstdatum' => '2026-04-09', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '500 g', 'Aantal' => 330],
            ['Id' => 20, 'Ontvangstdatum' => '2026-04-03', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '1 kg', 'Aantal' => 34],
            ['Id' => 21, 'Ontvangstdatum' => '2026-04-02', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '50 g', 'Aantal' => 23],
            ['Id' => 22, 'Ontvangstdatum' => '2026-03-16', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '1 l', 'Aantal' => 46],
            ['Id' => 23, 'Ontvangstdatum' => '2026-03-14', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '250 ml', 'Aantal' => 98],
            ['Id' => 24, 'Ontvangstdatum' => '2026-04-07', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '1 potje', 'Aantal' => 56],
            ['Id' => 25, 'Ontvangstdatum' => '2026-03-17', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '1 l', 'Aantal' => 210],
            ['Id' => 26, 'Ontvangstdatum' => '2026-04-05', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '4 stuks', 'Aantal' => 24],
            ['Id' => 27, 'Ontvangstdatum' => '2026-04-07', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '300 g', 'Aantal' => 87],
            ['Id' => 28, 'Ontvangstdatum' => '2026-04-06', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '200 g', 'Aantal' => 230],
            ['Id' => 29, 'Ontvangstdatum' => '2026-04-08', 'Uitleveringsdatum' => null, 'Verpakkingseenheid' => '80 g', 'Aantal' => 30],
        ]);

        Schema::create('ProductPerMagazijn', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->integer('ProductId');
            $table->integer('MagazijnId');
            $table->string('Locatie', 150)->nullable();
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();

            $table->foreign('ProductId')->references('Id')->on('Product');
            $table->foreign('MagazijnId')->references('Id')->on('Magazijn');
        });

        DB::table('ProductPerMagazijn')->insert([
            ['Id' => 1, 'ProductId' => 1, 'MagazijnId' => 1, 'Locatie' => 'Berlicum'],
            ['Id' => 2, 'ProductId' => 2, 'MagazijnId' => 2, 'Locatie' => 'Berlicum'],
            ['Id' => 3, 'ProductId' => 3, 'MagazijnId' => 3, 'Locatie' => 'Rosmalen'],
            ['Id' => 4, 'ProductId' => 4, 'MagazijnId' => 4, 'Locatie' => 'Berlicum'],
            ['Id' => 5, 'ProductId' => 5, 'MagazijnId' => 5, 'Locatie' => 'Rosmalen'],
            ['Id' => 6, 'ProductId' => 6, 'MagazijnId' => 6, 'Locatie' => 'Berlicum'],
            ['Id' => 7, 'ProductId' => 7, 'MagazijnId' => 7, 'Locatie' => 'Rosmalen'],
            ['Id' => 8, 'ProductId' => 8, 'MagazijnId' => 8, 'Locatie' => 'Sint-MichielsGestel'],
            ['Id' => 9, 'ProductId' => 9, 'MagazijnId' => 9, 'Locatie' => 'Sint-MichielsGestel'],
            ['Id' => 10, 'ProductId' => 10, 'MagazijnId' => 10, 'Locatie' => 'Middelrode'],
            ['Id' => 11, 'ProductId' => 11, 'MagazijnId' => 11, 'Locatie' => 'Middelrode'],
            ['Id' => 12, 'ProductId' => 12, 'MagazijnId' => 12, 'Locatie' => 'Middelrode'],
            ['Id' => 13, 'ProductId' => 13, 'MagazijnId' => 13, 'Locatie' => 'Schijndel'],
            ['Id' => 14, 'ProductId' => 14, 'MagazijnId' => 14, 'Locatie' => 'Schijndel'],
            ['Id' => 15, 'ProductId' => 15, 'MagazijnId' => 15, 'Locatie' => 'Gemonde'],
            ['Id' => 16, 'ProductId' => 16, 'MagazijnId' => 16, 'Locatie' => 'Gemonde'],
            ['Id' => 17, 'ProductId' => 17, 'MagazijnId' => 17, 'Locatie' => 'Gemonde'],
            ['Id' => 18, 'ProductId' => 18, 'MagazijnId' => 18, 'Locatie' => 'Gemonde'],
            ['Id' => 19, 'ProductId' => 19, 'MagazijnId' => 19, 'Locatie' => 'Den Bosch'],
            ['Id' => 20, 'ProductId' => 20, 'MagazijnId' => 20, 'Locatie' => 'Den Bosch'],
            ['Id' => 21, 'ProductId' => 21, 'MagazijnId' => 21, 'Locatie' => 'Den Bosch'],
            ['Id' => 22, 'ProductId' => 22, 'MagazijnId' => 22, 'Locatie' => 'Heeswijk Dinther'],
            ['Id' => 23, 'ProductId' => 23, 'MagazijnId' => 23, 'Locatie' => 'Heeswijk Dinther'],
            ['Id' => 24, 'ProductId' => 24, 'MagazijnId' => 24, 'Locatie' => 'Vught'],
            ['Id' => 25, 'ProductId' => 25, 'MagazijnId' => 25, 'Locatie' => 'Vught'],
            ['Id' => 26, 'ProductId' => 26, 'MagazijnId' => 26, 'Locatie' => 'Vught'],
            ['Id' => 27, 'ProductId' => 27, 'MagazijnId' => 27, 'Locatie' => 'Vught'],
            ['Id' => 28, 'ProductId' => 28, 'MagazijnId' => 28, 'Locatie' => 'Vught'],
            ['Id' => 29, 'ProductId' => 29, 'MagazijnId' => 29, 'Locatie' => 'Vught'],
        ]);

        Schema::create('ProductPerLeverancier', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->integer('LeverancierId');
            $table->integer('ProductId');
            $table->date('DatumAangeleverd')->nullable();
            $table->date('DatumEerstVolgendeLevering')->nullable();
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();

            $table->foreign('LeverancierId')->references('Id')->on('Leverancier');
            $table->foreign('ProductId')->references('Id')->on('Product');
        });

        DB::table('ProductPerLeverancier')->insert([
            ['Id' => 1, 'LeverancierId' => 4, 'ProductId' => 1, 'DatumAangeleverd' => '2026-03-12', 'DatumEerstVolgendeLevering' => '2026-05-15'],
            ['Id' => 2, 'LeverancierId' => 4, 'ProductId' => 2, 'DatumAangeleverd' => '2026-04-02', 'DatumEerstVolgendeLevering' => '2026-05-05'],
            ['Id' => 3, 'LeverancierId' => 2, 'ProductId' => 3, 'DatumAangeleverd' => '2026-03-16', 'DatumEerstVolgendeLevering' => '2026-05-18'],
            ['Id' => 4, 'LeverancierId' => 1, 'ProductId' => 4, 'DatumAangeleverd' => '2026-04-08', 'DatumEerstVolgendeLevering' => '2026-05-11'],
            ['Id' => 5, 'LeverancierId' => 4, 'ProductId' => 5, 'DatumAangeleverd' => '2026-04-06', 'DatumEerstVolgendeLevering' => '2026-05-10'],
            ['Id' => 6, 'LeverancierId' => 1, 'ProductId' => 6, 'DatumAangeleverd' => '2026-03-12', 'DatumEerstVolgendeLevering' => '2026-05-15'],
            ['Id' => 7, 'LeverancierId' => 4, 'ProductId' => 7, 'DatumAangeleverd' => '2026-03-20', 'DatumEerstVolgendeLevering' => '2026-05-21'],
            ['Id' => 8, 'LeverancierId' => 4, 'ProductId' => 8, 'DatumAangeleverd' => '2026-04-02', 'DatumEerstVolgendeLevering' => '2026-05-08'],
            ['Id' => 9, 'LeverancierId' => 4, 'ProductId' => 9, 'DatumAangeleverd' => '2026-04-04', 'DatumEerstVolgendeLevering' => '2026-05-09'],
            ['Id' => 10, 'LeverancierId' => 3, 'ProductId' => 10, 'DatumAangeleverd' => '2026-04-07', 'DatumEerstVolgendeLevering' => '2026-05-11'],
            ['Id' => 11, 'LeverancierId' => 3, 'ProductId' => 11, 'DatumAangeleverd' => '2026-04-01', 'DatumEerstVolgendeLevering' => '2026-05-06'],
            ['Id' => 12, 'LeverancierId' => 3, 'ProductId' => 12, 'DatumAangeleverd' => '2026-03-18', 'DatumEerstVolgendeLevering' => '2026-05-20'],
            ['Id' => 13, 'LeverancierId' => 3, 'ProductId' => 13, 'DatumAangeleverd' => '2026-03-19', 'DatumEerstVolgendeLevering' => '2026-05-20'],
            ['Id' => 14, 'LeverancierId' => 2, 'ProductId' => 14, 'DatumAangeleverd' => '2026-04-10', 'DatumEerstVolgendeLevering' => '2026-05-12'],
            ['Id' => 15, 'LeverancierId' => 2, 'ProductId' => 15, 'DatumAangeleverd' => '2026-03-13', 'DatumEerstVolgendeLevering' => '2026-05-15'],
            ['Id' => 16, 'LeverancierId' => 1, 'ProductId' => 16, 'DatumAangeleverd' => '2026-03-18', 'DatumEerstVolgendeLevering' => '2026-05-21'],
            ['Id' => 17, 'LeverancierId' => 1, 'ProductId' => 17, 'DatumAangeleverd' => '2026-03-11', 'DatumEerstVolgendeLevering' => '2026-05-15'],
            ['Id' => 18, 'LeverancierId' => 1, 'ProductId' => 18, 'DatumAangeleverd' => '2026-04-02', 'DatumEerstVolgendeLevering' => '2026-05-06'],
            ['Id' => 19, 'LeverancierId' => 1, 'ProductId' => 19, 'DatumAangeleverd' => '2026-04-09', 'DatumEerstVolgendeLevering' => '2026-05-12'],
            ['Id' => 20, 'LeverancierId' => 4, 'ProductId' => 20, 'DatumAangeleverd' => '2026-04-03', 'DatumEerstVolgendeLevering' => '2026-05-06'],
            ['Id' => 21, 'LeverancierId' => 2, 'ProductId' => 21, 'DatumAangeleverd' => '2026-04-02', 'DatumEerstVolgendeLevering' => '2026-05-08'],
            ['Id' => 22, 'LeverancierId' => 1, 'ProductId' => 22, 'DatumAangeleverd' => '2026-03-16', 'DatumEerstVolgendeLevering' => '2026-05-19'],
            ['Id' => 23, 'LeverancierId' => 3, 'ProductId' => 23, 'DatumAangeleverd' => '2026-03-14', 'DatumEerstVolgendeLevering' => '2026-05-18'],
            ['Id' => 24, 'LeverancierId' => 3, 'ProductId' => 24, 'DatumAangeleverd' => '2026-04-07', 'DatumEerstVolgendeLevering' => '2026-05-15'],
            ['Id' => 25, 'LeverancierId' => 1, 'ProductId' => 25, 'DatumAangeleverd' => '2026-03-17', 'DatumEerstVolgendeLevering' => '2026-05-21'],
            ['Id' => 26, 'LeverancierId' => 2, 'ProductId' => 26, 'DatumAangeleverd' => '2026-04-05', 'DatumEerstVolgendeLevering' => '2026-05-12'],
            ['Id' => 27, 'LeverancierId' => 1, 'ProductId' => 27, 'DatumAangeleverd' => '2026-04-07', 'DatumEerstVolgendeLevering' => '2026-05-10'],
            ['Id' => 28, 'LeverancierId' => 2, 'ProductId' => 28, 'DatumAangeleverd' => '2026-04-06', 'DatumEerstVolgendeLevering' => '2026-05-09'],
            ['Id' => 29, 'LeverancierId' => 3, 'ProductId' => 29, 'DatumAangeleverd' => '2026-04-08', 'DatumEerstVolgendeLevering' => '2026-05-11'],
        ]);

        Schema::create('Voedselpakket', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->integer('GezinId');
            $table->integer('PakketNummer');
            $table->date('DatumSamenstelling')->nullable();
            $table->date('DatumUitgifte')->nullable();
            $table->string('Status', 100)->nullable();
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();

            $table->foreign('GezinId')->references('Id')->on('Gezin');
        });

        DB::table('Voedselpakket')->insert([
            ['Id' => 1, 'GezinId' => 1, 'PakketNummer' => 1, 'DatumSamenstelling' => '2026-03-21', 'DatumUitgifte' => '2026-03-21', 'Status' => 'Uitgereikt'],
            ['Id' => 2, 'GezinId' => 1, 'PakketNummer' => 2, 'DatumSamenstelling' => '2026-03-19', 'DatumUitgifte' => null, 'Status' => 'NietUitgereikt'],
            ['Id' => 3, 'GezinId' => 1, 'PakketNummer' => 3, 'DatumSamenstelling' => '2026-03-17', 'DatumUitgifte' => null, 'Status' => 'NietMeeringeschreven'],
            ['Id' => 4, 'GezinId' => 2, 'PakketNummer' => 4, 'DatumSamenstelling' => '2026-03-10', 'DatumUitgifte' => '2026-03-14', 'Status' => 'Uitgereikt'],
            ['Id' => 5, 'GezinId' => 2, 'PakketNummer' => 5, 'DatumSamenstelling' => '2026-03-18', 'DatumUitgifte' => '2026-03-20', 'Status' => 'Uitgereikt'],
            ['Id' => 6, 'GezinId' => 2, 'PakketNummer' => 6, 'DatumSamenstelling' => '2026-04-08', 'DatumUitgifte' => null, 'Status' => 'NietUitgereikt'],
        ]);

        Schema::create('ProductPerVoedselpakket', function (Blueprint $table) {
            $table->integer('Id')->primary();
            $table->integer('VoedselpakketId');
            $table->integer('ProductId');
            $table->integer('AantalProductEenheden')->nullable();
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('DatumAangemaakt', 6)->useCurrent();
            $table->dateTime('DatumGewijzigd', 6)->useCurrent()->useCurrentOnUpdate();

            $table->foreign('VoedselpakketId')->references('Id')->on('Voedselpakket');
            $table->foreign('ProductId')->references('Id')->on('Product');
        });

        DB::table('ProductPerVoedselpakket')->insert([
            ['Id' => 1, 'VoedselpakketId' => 1, 'ProductId' => 7, 'AantalProductEenheden' => 1],
            ['Id' => 2, 'VoedselpakketId' => 1, 'ProductId' => 8, 'AantalProductEenheden' => 2],
            ['Id' => 3, 'VoedselpakketId' => 1, 'ProductId' => 9, 'AantalProductEenheden' => 1],
            ['Id' => 4, 'VoedselpakketId' => 2, 'ProductId' => 12, 'AantalProductEenheden' => 1],
            ['Id' => 5, 'VoedselpakketId' => 2, 'ProductId' => 13, 'AantalProductEenheden' => 2],
            ['Id' => 6, 'VoedselpakketId' => 2, 'ProductId' => 14, 'AantalProductEenheden' => 1],
            ['Id' => 7, 'VoedselpakketId' => 3, 'ProductId' => 3, 'AantalProductEenheden' => 1],
            ['Id' => 8, 'VoedselpakketId' => 3, 'ProductId' => 4, 'AantalProductEenheden' => 1],
            ['Id' => 9, 'VoedselpakketId' => 4, 'ProductId' => 20, 'AantalProductEenheden' => 1],
            ['Id' => 10, 'VoedselpakketId' => 4, 'ProductId' => 19, 'AantalProductEenheden' => 1],
            ['Id' => 11, 'VoedselpakketId' => 4, 'ProductId' => 21, 'AantalProductEenheden' => 1],
            ['Id' => 12, 'VoedselpakketId' => 5, 'ProductId' => 24, 'AantalProductEenheden' => 1],
            ['Id' => 13, 'VoedselpakketId' => 5, 'ProductId' => 25, 'AantalProductEenheden' => 1],
            ['Id' => 14, 'VoedselpakketId' => 5, 'ProductId' => 26, 'AantalProductEenheden' => 1],
            ['Id' => 15, 'VoedselpakketId' => 6, 'ProductId' => 27, 'AantalProductEenheden' => 1],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ProductPerVoedselpakket');
        Schema::dropIfExists('Voedselpakket');
        Schema::dropIfExists('ProductPerLeverancier');
        Schema::dropIfExists('Magazijn');
        Schema::dropIfExists('ContactPerLeverancier');
        Schema::dropIfExists('Leverancier');
        Schema::dropIfExists('ContactPerGezin');
        Schema::dropIfExists('Contact');
        Schema::dropIfExists('EetwensPerGezin');
        Schema::dropIfExists('Eetwens');
        Schema::dropIfExists('ProductPerMagazijn');
        Schema::dropIfExists('Product');
        Schema::dropIfExists('Categorie');
        Schema::dropIfExists('AllergiePerPersoon');
        Schema::dropIfExists('Allergie');
        Schema::dropIfExists('RolPerGebruiker');
        Schema::dropIfExists('Rol');
        Schema::dropIfExists('Gebruiker');
        Schema::dropIfExists('Persoon');
        Schema::dropIfExists('Gezin');
    }
};
