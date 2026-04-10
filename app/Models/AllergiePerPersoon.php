<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllergiePerPersoon extends Model
{
    protected $table = 'AllergiePerPersoon';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = [
        'PersoonId',
        'AllergieId',
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

    public function persoon()
    {
        return $this->belongsTo(Persoon::class, 'PersoonId');
    }

    public function allergie()
    {
        return $this->belongsTo(Allergie::class, 'AllergieId');
    }
}
