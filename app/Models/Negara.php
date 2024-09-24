<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class Negara extends Model
{
    use HasFactory;
    protected $table = 'negaras';
    public $dataKerjaSamaNegara;

    public function Instansi(): HasMany
    {
        return $this->hasMany(Instansi::class, 'negara_id', 'id');
    }

    function getNegaraWithInstansiByName($countryName)
{
    $negara = Negara::where('name', $countryName)->with('instansis')->first();

    if ($negara) {
        $instansiList = $negara->instansis;
        $this->dataKerjaSamaNegara = [
            'negara' => $negara,
            'instansi' => $instansiList
        ];
    } else {
        $this-> dataKerjaSamaNegara = null;
    }
}
}
