<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataIa extends Model
{
    protected $table = 'data_ia';
    protected $guarded = [];

    use HasFactory;

    public function uploadedby()
    {
        return $this->belongsTo('App\Models\User', 'uploaded_by');
    }

    public function editedby()
    {
        return $this->belongsTo('App\Models\User', 'edited_by');
    }

    public function dokumenIA()
    {
        return $this->belongsTo('App\Models\DataIaDokumen', 'kerjasama_id');
    }

    public function getFakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_pihak');
    }

    public function getJenisKerjasama()
    {
        return $this->belongsTo(JenisKerjasama::class, 'jenis_kerjasama');
    }

    public function getStatusKerjasama()
    {
        return $this->belongsTo(StatusKerjasama::class, 'status');
    }

    public function getPihak($pihak)
    {
        $data = self::whereHas('getmeOut', function ($query) use ($pihak) {
                        $query->when($pihak, function ($query) use ($pihak) {
                            $query->where('pihak', $pihak);
                        });
                    })
                    ->first();
        return $data;
    }

    public static function searchBy($tahun=null, $fakultas=null, $noDokumen=null, $judul=null, $status=null, $jenis=null, $namaProdi=null,
                                    $negara=null, $mitra=null, $prodi=null, $tingkat=null, $sortData=null)
    {
        if ($sortData == 1) {
            $sortData = "tanggal_ttd";
        } else {
            $sortData = "id";
        }

        $data = self::when($tahun, function ($query) use ($tahun) {
            $query->whereYear('tanggal_ttd', $tahun);
        })->when($fakultas, function ($query) use ($fakultas) {
            $query->where('fakultas_pihak', $fakultas);
        })->when($noDokumen, function ($query) use ($noDokumen) {
            $query->where('nomor_dok_unhas', 'LIKE', '%'.$noDokumen.'%');
        })->when($judul, function ($query) use ($judul) {
            $query->where('judul', 'LIKE', '%'.$judul.'%');
        })->when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })->when($jenis, function ($query) use ($jenis) {
            $query->where('jenis_kerjasama', $jenis);
        })->when($namaProdi, function ($query) use ($namaProdi) {
            $query->where('nama_prodi', 'LIKE', $namaProdi);
        })->when($negara, function ($query) use ($negara) {
            $query->where('negara', 'LIKE', '%'.$negara.'%');
        })->when($mitra, function ($query) use ($mitra) {
            $query->where('penggiat', 'LIKE', '%'.$mitra.'%');
        })->when($prodi, function ($query) use ($prodi) {
            $query->where('prodi_id', $prodi);
        })->when($tingkat, function ($query) use ($tingkat) {
            $query->where('tingkat', $tingkat);
        })->orderBy($sortData, "desc");

        return $data;
    }

    public static function countStatus($val)
    {
       $data = self::where('status',$val)->count('id');
       return $data;
    }

    public static function countBy($month=null,$year=null,$fakultas=null,$prodi=null)
    {
        // $data = self::whereYear('tanggal_awal', '=', $year)->whereMonth('tanggal_awal','=', $month)
        $data = self::when($month, function ($query) use ($month) {
            $query->whereMonth('tanggal_awal', $month);
        })->when($year, function ($query) use ($year) {
            $query->whereYear('tanggal_ttd', $year);
        })->when($fakultas, function ($query) use ($fakultas) {
            $query->where('fakultas_pihak', $fakultas);
        })->when($prodi, function ($query) use ($prodi) {
            $query->where('prodi_id', $prodi);
        })->count();
        // dd($data);
        return $data;
    }

    public function getBentukKegiatan()
    {
        return $this->hasMany('App\Models\DataIaBentukKegiatanKerjasama', 'id_ia', 'id');
    }

    public static function countBentukKegiatan($kegiatan=null,$year=null,$fakultas=null,$prodi=null)
    {
        $data = self::whereHas('getBentukKegiatan', function ($query) use ($kegiatan) {
            $query->when($kegiatan, function ($query) use ($kegiatan) {
                $query->where('id_ref_bentuk_kegiatan', $kegiatan);
            });
        })->when($year, function ($query) use ($year) {
            $query->whereYear('tanggal_awal', $year);
        })->when($fakultas, function ($query) use ($fakultas) {
            $query->where('fakultas_pihak', $fakultas);
        })->when($prodi, function ($query) use ($prodi) {
            $query->where('prodi_id', $prodi);
        })->count();
        // dd($data);
        return $data;
    }

    public static function countNegara($negara=null,$year=null,$fakultas=null,$prodi=null)
    {
        $data = self::where('status',1)
        ->when($negara, function ($query) use ($negara) {
            $query->where('negara', $negara);
        })->when($year, function ($query) use ($year) {
            $query->whereYear('tanggal_awal', $year);
        })->when($fakultas, function ($query) use ($fakultas) {
            $query->where('fakultas_pihak', $fakultas);
        })->when($prodi, function ($query) use ($prodi) {
            $query->where('prodi_id', $prodi);
        })->count();
        // dd($data);
        return $data;
    }

    public function getPenggiatKerjasama()
    {
        return $this->hasMany('App\Models\DataIaPenggiat', 'id_lapkerma', 'id');
    }

    public static function countBadanKemitraan($kemitraan=null,$year=null,$fakultas=null,$prodi=null)
    {
        $data = self::whereHas('getPenggiatKerjasama', function ($query) use ($kemitraan) {
            $query->when($kemitraan, function ($query) use ($kemitraan) {
                $query->where('badan_kemitraan', $kemitraan);
            });
        })->when($year, function ($query) use ($year) {
            $query->whereYear('tanggal_awal', $year);
        })->when($fakultas, function ($query) use ($fakultas) {
            $query->where('fakultas_pihak', $fakultas);
        })->when($prodi, function ($query) use ($prodi) {
            $query->where('prodi_id', $prodi);
        })->count();
        // dd($data);
        return $data;
    }

    public static function countPtqs($ptqs=null,$year=null,$fakultas=null,$prodi=null)
    {
        $data = self::whereHas('getPenggiatKerjasama', function ($query) use ($ptqs) {
            $query->when($ptqs, function ($query) use ($ptqs) {
                $query->where('ptqs', $ptqs);
            });
        })->when($year, function ($query) use ($year) {
            $query->whereYear('tanggal_awal', $year);
        })->when($fakultas, function ($query) use ($fakultas) {
            $query->where('fakultas_pihak', $fakultas);
        })->when($prodi, function ($query) use ($prodi) {
            $query->where('prodi_id', $prodi);
        })->count();
        // dd($data);
        return $data;
    }

    public static function countPerguruanTinggi($pt=null,$year=null,$fakultas=null,$prodi=null)
    {
        $data = self::whereHas('getPenggiatKerjasama', function ($query) use ($pt) {
            $query->when($pt, function ($query) use ($pt) {
                $query->whereIn('status_pihak', $pt);
            });
        })->when($year, function ($query) use ($year) {
            $query->whereYear('tanggal_awal', $year);
        })->when($fakultas, function ($query) use ($fakultas) {
            $query->where('fakultas_pihak', $fakultas);
        })->when($prodi, function ($query) use ($prodi) {
            $query->where('prodi_id', $prodi);
        })->count();
        // dd($data);
        return $data;
    }

}
