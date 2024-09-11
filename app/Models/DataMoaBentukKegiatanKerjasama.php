<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMoaBentukKegiatanKerjasama extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function kegiatan()
    {
        return $this->belongsTo( LapkermaRefBentukKegiatan::class, 'id_ref_bentuk_kegiatan');
    }
}
