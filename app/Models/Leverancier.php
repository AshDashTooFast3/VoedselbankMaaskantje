<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Leverancier
{
    /**
     * Haalt leveranciers op via stored procedure, optioneel gefilterd op type.
     *
     * Waarom procedure:
     * - querylogica blijft centraal in de database
     * - controller blijft dun en gericht op HTTP-flow
     */
    public static function getLeveranciersOverzicht(?string $leverancierType = null): Collection
    {
        // Lege string vertalen we naar null, zodat de procedure "geen filter" toepast.
        $typeFilter = $leverancierType ?: null;

        return collect(DB::select('CALL sp_getAllLeveranciers(?)', [$typeFilter]));
    }

    /**
     * Haalt unieke leveranciertypes op voor de filter-dropdown.
     */
    public static function getLeverancierTypes(): Collection
    {
        return collect(DB::select('CALL sp_getLeverancierTypes()'))
            ->pluck('LeverancierType')
            ->filter()
            ->values();
    }

    /**
     * Haalt details en producten van een leverancier op via stored procedures.
     *
        * Return-structuur:
        * - leverancier: object met leverancier/contactgegevens
        * - producten: collectie met producten van die leverancier
        *
     * @return array<string, mixed>
     */
    public static function getLeverancierDetails(int $leverancierId): array
    {
        $leverancier = collect(DB::select('CALL sp_getLeverancierDetails(?)', [$leverancierId]))->first();
        $producten = collect(DB::select('CALL sp_getLeverancierProducten(?)', [$leverancierId]));

        return [
            'leverancier' => $leverancier,
            'producten' => $producten,
        ];
    }

    /**
     * Haalt een specifiek product van een leverancier op voor de wijzigpagina.
     * Hiermee voorkomen we dat een gebruiker een product van een andere leverancier wijzigt.
     */
    public static function getLeverancierProductVoorWijzigen(int $leverancierId, int $productId): ?object
    {
        return collect(DB::select('CALL sp_getLeverancierProductVoorWijzigen(?, ?)', [$leverancierId, $productId]))->first();
    }

    /**
     * Werkt de houdbaarheidsdatum bij via stored procedure.
     * Procedure retourneert statusinformatie (IsGewijzigd/Bericht) voor gebruikersfeedback.
     */
    public static function updateProductHoudbaarheidsdatum(int $leverancierId, int $productId, string $nieuweDatum): ?object
    {
        return collect(DB::select('CALL sp_updateProductHoudbaarheidsdatum(?, ?, ?)', [
            $leverancierId,
            $productId,
            $nieuweDatum,
        ]))->first();
    }

    /**
        * Werkt leverancier en contactgegevens bij via stored procedure.
        * Deze methode heeft geen return: errors worden als DB-exceptie naar controller doorgegeven.
     */
    public static function updateLeverancier(int $leverancierId, array $data): void
    {
        DB::statement('CALL sp_updateLeverancier(?, ?, ?, ?, ?, ?, ?)', [
            $leverancierId,
            $data['Naam'],
            $data['Contactpersoon'],
            $data['LeverancierNummer'],
            $data['LeverancierType'],
            $data['Email'] ?? null,
            $data['Mobiel'] ?? null,
        ]);
    }
}
