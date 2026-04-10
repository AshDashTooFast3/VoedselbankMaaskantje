<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gezin extends Model
{
    //
    protected $table = 'Gezin';

    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Naam',
        'Code',
        'Omschrijving',
        'AantalVolwassenen',
        'AantalKinderen',
        'AantalBabys',
        'TotaalAantalPersonen',
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

    public function personen()
    {
        return $this->hasMany(Persoon::class, 'GezinId');
    }
}
