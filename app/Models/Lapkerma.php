<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapkerma extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function dokumenKerjasama()
    {
        return $this->belongsTo('App\Models\DokumenLapkerma', 'kerjasama_id');
    }

    public function getJenisKerjasama()
    {
        return $this->belongsTo('App\Models\JenisKerjasama', 'jenis_kerjasama');
    }

    public function getRegionKerjasama()
    {
        return $this->belongsTo('App\Models\Region', 'region');
    }

    public function getKegiatanKerjasama()
    {
        return $this->belongsTo('App\Models\KegiatanKerjasama', 'jenis_kegiatan');
    }

    public function getStatusKerjasama()
    {
        return $this->belongsTo('App\Models\StatusKerjasama', 'status');
    }

    public function getJenisDokumenKerjasama()
    {
        return $this->belongsTo('App\Models\JenisDokumenKerjasama', 'jenis_dokumen');
    }

    public function getUploaded()
    {
        return $this->belongsTo('App\Models\User','uploaded_by');
    }

    public function getEdited()
    {
        return $this->belongsTo('App\Models\User','edited_by');
    }

    public function getSumberDana()
    {
        return $this->belongsTo('App\Models\ReferensiSumberDanaLapkerma','sumber_dana');
    }

    public function getFakultas()
    {
        return $this->belongsTo('App\Models\Fakultas','fakultas_pihak');
    }

    public function getProdi()
    {
        return $this->belongsToMany(Prodi::class, 'lapkerma_prodis', 'lapkerma_id', 'prodi_id');
    }

    public function getPihak()
    {
        return $this->hasMany('App\Models\PenggiatKerjasama','id_lapkerma','id');
    }

    // return this->hasMany

    public static function countProdi($id)
    {
       $data = self::whereNotNull('prodi')->pluck('prodi')->map(function($item, $key){
        return json_decode($item);
       });
       return $data->collapse()->countBy()[$id]??0;
    }

    public static function countJenis($id)
    {
       $data = self::where('jenis_dokumen',$id)->count('id');
       return $data;
    }

    public static function countJumlahFakultas()
    {
       $data = self::pluck('fakultas_pihak')->map(function($item, $key){
        return json_decode($item);
       });
    //    dd($data->unique());
       return $data->unique()->count();
    }

    public static function groupByTahun($val)
    {
       $data = self::where('jenis_dokumen', 1)->get()->groupBy(function($val){
           return Carbon::parse($val->tanggal_berakhir)->format('Y');
       });
       return $data;
    }

    public static function countKerjasamaByStatusAktif($status)
    {
        $data = self::where('status', $status)->count();
        // dd($data);
        return $data;
    }

    public static function countMOUByMonth($month)
    {
        $data = self::where('jenis_dokumen',1)->whereMonth('tanggal_awal','=', $month)->count();
        // dd($data);
        return $data;
    }

    public static function countMOAByMonth($month)
    {
        $data = self::where('jenis_dokumen',2)->whereMonth('tanggal_awal','=', $month)->count();
        // dd($data);
        return $data;
    }
    
    public static function countIAByMonth($month)
    {
        $data = self::where('jenis_dokumen',3)->whereMonth('tanggal_awal','=', $month)->count();
        // dd($data);
        return $data;
    }
}
