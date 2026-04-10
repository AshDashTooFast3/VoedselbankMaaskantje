<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Leverancier
{
    /**
     * Haalt leveranciers op via stored procedure, optioneel gefilterd op type.
     */
    public static function getLeveranciersOverzicht(?string $leverancierType = null): Collection
    {
        $typeFilter = $leverancierType ?: null;

        return collect(DB::select('CALL sp_getAllLeveranciers(?)', [$typeFilter]));
    }

    /**
     * Haalt unieke leveranciertypes op voor de filter.
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
     * Werkt leverancier en contactgegevens bij via stored procedure.
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
