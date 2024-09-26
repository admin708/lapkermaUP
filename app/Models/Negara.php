<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class Negara extends Model
{
    use HasFactory;
    protected $table = 'negaras';

    public function Instansi(): HasMany
    {
        return $this->hasMany(Instansi::class, 'negara_id', 'id');
    }

    public function getNegaraWithInstansiByName($countryName)
    {
        return Instansi::whereHas('getNegara', function ($query) use ($countryName) {
            $query->where('name',strval($countryName));
        })->get();
    }
}
