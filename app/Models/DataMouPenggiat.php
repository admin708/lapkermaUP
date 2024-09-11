<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMouPenggiat extends Model
{
    protected $table = 'data_mou_penggiat';
    protected $guarded = [];

    use HasFactory;

    public function cekid()
    {
        return $this->belongsTo(DataMou::class, 'id_lapkerma');
    }

    public static function getPihak($idMou,$pihak)
    {
        $data = self::when($idMou, function ($query) use ($idMou) {
                        $query->where('id_lapkerma', $idMou);
                    })
                    ->when($pihak, function ($query) use ($pihak) {
                        $query->where('pihak', $pihak);
                    })
                    ->get();
        return $data;
    }

    public function getDataMou()
    {
            return $this->hasOne(DataMou::class, 'id', 'id_lapkerma');
    }

    public static function countBadanKemitraan($kemitraan=null,$year=null,$fakultas=null,$prodi=null)
    {
        $data = self::when($kemitraan, function ($query) use ($kemitraan) {
            $query->where('badan_kemitraan', $kemitraan);
        })->whereHas('getDataMou', function ($query) use ($year,$fakultas,$prodi) {
            $query->when($year, function ($query) use ($year) {
                $query->whereYear('tanggal_awal', $year);
            });
            $query->when($fakultas, function ($query) use ($fakultas) {
                $query->where('fakultas_pihak', $fakultas);
            });
            $query->when($prodi, function ($query) use ($prodi) {
                $query->where('prodi', $prodi);
            });
        })
        ->select('nama_pihak')
        ->groupBy('nama_pihak')
        ->get();
        // dd($data);

        return $data;
    }

    public static function countPerguruanTinggi($pt=null,$year=null,$fakultas=null,$prodi=null)
    {
        $data = self::when($pt, function ($query) use ($pt) {
            $query->whereIn('status_pihak', $pt);
        })->whereHas('getDataMou', function ($query) use ($year,$fakultas,$prodi) {
            $query->when($year, function ($query) use ($year) {
                $query->whereYear('tanggal_awal', $year);
            });
            $query->when($fakultas, function ($query) use ($fakultas) {
                $query->where('fakultas_pihak', $fakultas);
            });
            $query->when($prodi, function ($query) use ($prodi) {
                $query->where('prodi', $prodi);
            });
        })
        ->select('nama_pihak')
        ->groupBy('nama_pihak')
        ->get();
        // dd($data);
        return $data;
    }

    public static function countPtqs($ptqs=null,$year=null,$fakultas=null,$prodi=null)
    {
        $data = self::when($ptqs, function ($query) use ($ptqs) {
            $query->where('ptqs', $ptqs);
        })->whereHas('getDataMou', function ($query) use ($year,$fakultas,$prodi) {
            $query->when($year, function ($query) use ($year) {
                $query->whereYear('tanggal_awal', $year);
            });
            $query->when($fakultas, function ($query) use ($fakultas) {
                $query->where('fakultas_pihak', $fakultas);
            });
            $query->when($prodi, function ($query) use ($prodi) {
                $query->where('prodi', $prodi);
            });
        })->select('nama_pihak')
        ->groupBy('nama_pihak')
        ->get();
        // dd($data);
        return $data;
    }

}
