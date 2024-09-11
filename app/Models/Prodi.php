<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_resmi', 'id_fakultas', 'is_eksakta'
    ];

    public function fakultas()
    {
        return $this->belongsTo('App\Models\Fakultas', 'id_fakultas');
    }

    public function getMoa()
    {
        return $this->hasMany('App\Models\DataMoa', 'prodi_id', 'id');
    }

    public function getIa()
    {
        return $this->hasMany('App\Models\DataIa', 'prodi_id', 'id');
    }


}
