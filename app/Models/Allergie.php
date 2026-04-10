<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Allergie extends Model
{
    protected $table = 'Allergie';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = [
        'Naam',
        'Omschrijving',
        'AnafylactischRisico',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    protected $casts = [
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function allergiePerPersoon()
    {
        return $this->hasMany(AllergiePerPersoon::class, 'AllergieId');
    }

    public function getAllFamilies()
    {
        return DB::select('CALL sp_getAllFamilies()');
    }

    public function getAllFamiliesBySelectedAllergy($allergieId)
    {
        return DB::select('CALL sp_getAllFamiliesBySelectedAllergy(?)', [$allergieId]);
    }

    public function getAllAllergies() 
    {
        return DB::select('CALL sp_getAllAllergies()');
    }

    public function getAllergiesInFamily($gezinId)
    {
        return DB::select('CALL sp_getAllergiesInFamily(?)', [$gezinId]);
    }

    public function getAllergyById($persoonId)
    {
        return DB::selectOne('CALL sp_getAllergyById(?)', [$persoonId]);
    }

    public function updateAllergy($persoonId, $allergieId, $gezinId)
    {
        DB::update('CALL sp_updateAllergy(?, ?, ?)', [$persoonId, $allergieId, $gezinId]);
    }
}
