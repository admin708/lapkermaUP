<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataIaPenggiat extends Model
{
    use HasFactory;

    protected $table = 'data_ia_penggiat';
    protected $guarded = [];

    // Define a relationship to DataIa
    public function cekid()
    {
        return $this->belongsTo(DataIa::class, 'id_lapkerma');
    }

    // Define a one-to-one relationship to DataIa
    public function getDataIa()
    {
        return $this->hasOne(DataIa::class, 'id', 'id_lapkerma');
    }

    // Count based on the 'badan_kemitraan' field with filtering options
    public static function countBadanKemitraan($kemitraan = null, $year = null, $fakultas = null, $prodi = null)
    {
        return self::when($kemitraan, function ($query) use ($kemitraan) {
                $query->where('badan_kemitraan', $kemitraan);
            })
            ->whereHas('getDataIa', function ($query) use ($year, $fakultas, $prodi) {
                $query->when($year, function ($query) use ($year) {
                    $query->whereYear('tanggal_awal', $year);
                });
                $query->when($fakultas, function ($query) use ($fakultas) {
                    $query->where('fakultas_pihak', $fakultas);
                });
                $query->when($prodi, function ($query) use ($prodi) {
                    $query->where('prodi_id', $prodi);
                });
            })
            ->select('nama_pihak')
            ->groupBy('nama_pihak')
            ->get();
    }

    // Count based on 'status_pihak' with filtering options
    public static function countPerguruanTinggi($pt = null, $year = null, $fakultas = null, $prodi = null)
    {
        return self::when($pt, function ($query) use ($pt) {
                $query->whereIn('status_pihak', $pt);
            })
            ->whereHas('getDataIa', function ($query) use ($year, $fakultas, $prodi) {
                $query->when($year, function ($query) use ($year) {
                    $query->whereYear('tanggal_awal', $year);
                });
                $query->when($fakultas, function ($query) use ($fakultas) {
                    $query->where('fakultas_pihak', $fakultas);
                });
                $query->when($prodi, function ($query) use ($prodi) {
                    $query->where('prodi_id', $prodi);
                });
            })
            ->select('nama_pihak')
            ->groupBy('nama_pihak')
            ->get();
    }

    // Count based on 'ptqs' with filtering options
    public static function countPtqs($ptqs = null, $year = null, $fakultas = null, $prodi = null)
    {
        return self::when($ptqs, function ($query) use ($ptqs) {
                $query->where('ptqs', $ptqs);
            })
            ->whereHas('getDataIa', function ($query) use ($year, $fakultas, $prodi) {
                $query->when($year, function ($query) use ($year) {
                    $query->whereYear('tanggal_awal', $year);
                });
                $query->when($fakultas, function ($query) use ($fakultas) {
                    $query->where('fakultas_pihak', $fakultas);
                });
                $query->when($prodi, function ($query) use ($prodi) {
                    $query->where('prodi_id', $prodi);
                });
            })
            ->select('nama_pihak')
            ->groupBy('nama_pihak')
            ->get();
    }

    // Get data with joins for pagination
    public static function getDataWithJoin($jenjang = 'sarjana')
    {
        return self::join('data_ia as di', 'data_ia_penggiat.id_lapkerma', '=', 'di.id')
            ->rightJoin('referensi_badan_kemitraans as rbk', 'rbk.id', '=', 'data_ia_penggiat.badan_kemitraan')
            ->leftJoin('prodis as p', 'p.id', '=', 'di.prodi_id')
            ->where('p.jenjang', $jenjang)
            ->groupBy('di.uuid', 'p.nama_resmi', 'data_ia_penggiat.nama_pihak', 'rbk.bobot')
            ->select('di.uuid', 'p.nama_resmi', 'data_ia_penggiat.nama_pihak', 'rbk.bobot');
    }
}
