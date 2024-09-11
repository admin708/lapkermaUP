<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonProdiDataMoaBentukKegiatanKerjasama extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'np_data_moa_bentuk_kegiatan_kerjasamas';

    public function kegiatan()
    {
        return $this->belongsTo( LapkermaRefBentukKegiatan::class, 'id_ref_bentuk_kegiatan');
    }
}
