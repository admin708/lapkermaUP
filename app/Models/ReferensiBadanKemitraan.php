<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferensiBadanKemitraan extends Model
{
    use HasFactory;

    public function getDataIaPenggiat()
    {
        return $this->hasMany('App\Models\DataIaPenggiat', 'badan_kemitraan', 'id');
    }

    public function getDataMoaPenggiat()
    {
        return $this->hasMany('App\Models\DataMoaPenggiat', 'badan_kemitraan', 'id');
    }

}


