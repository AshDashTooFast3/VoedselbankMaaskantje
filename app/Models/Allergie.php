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
        return DB::select('CALL GetAllFamilies()');
    }

    public function getAllFamiliesBySelectedAllergy($allergieId)
    {
        return DB::select('CALL GetAllFamiliesBySelectedAllergy(?)', [$allergieId]);
    }
}
