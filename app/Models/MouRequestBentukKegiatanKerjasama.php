<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MouRequestBentukKegiatanKerjasama extends Model
{
    protected $table = 'data_mou_request_bentuk_kegiatan_kerjasamas';
    protected $guarded = [];
    use HasFactory;

    public function kegiatan()
    {
        return $this->belongsTo(LapkermaRefBentukKegiatan::class, 'id_ref_bentuk_kegiatan');
    }
}
