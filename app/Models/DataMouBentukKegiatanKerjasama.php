<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMouBentukKegiatanKerjasama extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function kegiatan()
    {
        return $this->belongsTo( LapkermaRefBentukKegiatan::class, 'id_ref_bentuk_kegiatan');
    }

    // public static function countBentukKegiatan($kegiatan=null,$year=null,$fakultas=null,$prodi=null)
    // {
    //     // $data = self::whereYear('tanggal_awal', '=', $year)->whereMonth('tanggal_awal','=', $month)
    //     $data = self::when($kegiatan, function ($query) use ($kegiatan) {
    //         $query->where('id_ref_bentuk_kegiatan', $kegiatan);
    //     })->when($year, function ($query) use ($year) {
    //         $query->whereYear('tanggal_awal', $year);
    //     })->when($fakultas, function ($query) use ($fakultas) {
    //         $query->where('fakultas_pihak', $fakultas);
    //     })->when($prodi, function ($query) use ($prodi) {
    //         $query->where('prodi_id', $prodi);
    //     })->count();
    //     // dd($data);
    //     return $data;
    // }
}


