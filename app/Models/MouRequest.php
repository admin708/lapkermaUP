<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MouRequest extends Model
{
    use HasFactory;
    protected $table = 'data_mou_request';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'uuid',
        'this',
        'uploaded_by',
        'edited_by',
        'level',
        'tingkat',
        'sdgs',
        'jenis_kerjasama',
        'negara',
        'region',
        'tempat_pelaksanaan',
        'nomor_dok_unhas',
        'nomor_dok_mitra',
        'judul',
        'deskripsi',
        'tanggal_ttd',
        'tanggal_awal',
        'tanggal_berakhir',
        'status',
        'jangka_waktu',
        'nama_pihak',
        'alamat_pihak',
        'nama_pejabat_pihak',
        'jabatan_pejabat_pihak',
        'pj_pihak',
        'jabatan_pj_pihak',
        'email_pj_pihak',
        'hp_pj_pihak',
        'fakultas_pihak',
        'prodi_id',
        'prodi',
        'nama_prodi',
        'penggiat',
        'created_at',
        'updated_at',
    ];


    // Relasi ke tabel Negara
    public function negara()
    {
        return $this->belongsTo(Negara::class, 'negara', 'id'); // 'negara' pada mou_request mereferensikan id pada tabel negara
    }

    // Relasi ke tabel TipeKerjasama
    public function tipeKerjasama()
    {
        return $this->belongsTo(JenisKerjasama::class, 'tipe_kerjasama', 'id'); // 'tipe_kerjasama' pada mou_request mereferensikan id pada tabel tipe_kerjasama
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function dokumenMoURequest()
    {
        return $this->belongsTo(MouRequestDokumen::class, 'kerjasama_id');
    }

    // public function getpenggiat()
    // {
    //     return $this->belongsTo(penggiat::class, 'penggiat_pihak');
    // }

    public function getJenisKerjasama()
    {
        return $this->belongsTo(JenisKerjasama::class, 'jenis_kerjasama');
    }

    public function getStatusKerjasama()
    {
        return $this->belongsTo(StatusKerjasama::class, 'status');
    }

    public function getmeOut()
    {
        return $this->hasMany(MouRequestPenggiat::class, 'id_lapkerma', 'id');
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

    public static function searchBy(
        $tahun = null,
        $penggiat = null,
        $noDokumen = null,
        $judul = null,
        $status = null,
        $jenis = null,
        $negara = null,
        $fakultas = null,
        $prodi = null,
        $univ = null,
        $sortData
    ) {
        if ($sortData == 1) {
            $sortData = "tanggal_ttd";
        } else {
            $sortData = "id";
        }

        $data = self::when($tahun, function ($query) use ($tahun) {
            $query->whereYear('tanggal_ttd', $tahun);
        })->when($penggiat, function ($query) use ($penggiat) {
            $query->where('penggiat', 'LIKE', '%' . $penggiat . '%');
        })->when($noDokumen, function ($query) use ($noDokumen) {
            $query->where('nomor_dok_unhas', 'LIKE', '%' . $noDokumen . '%');
        })->when($judul, function ($query) use ($judul) {
            $query->where('judul', 'LIKE', '%' . $judul . '%');
        })->when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })->when($jenis, function ($query) use ($jenis) {
            $query->where('jenis_kerjasama', $jenis);
        })->when($negara, function ($query) use ($negara) {
            $query->where('negara', 'LIKE', '%' . $negara . '%');
        })->when($fakultas, function ($query) use ($fakultas, $univ) {
            $query->whereIn('fakultas_pihak', [$fakultas, $univ]);
        })->orderBy($sortData, "desc");
        // })->orderBy("id", "desc");

        return $data;
    }

    public static function countStatus($val)
    {
        $data = self::where('status', $val)->count('id');
        return $data;
    }

    public static function countBy($month = null, $year = null, $fakultas = null, $prodi = null)
    {
        // $data = self::whereYear('tanggal_awal', '=', $year)->whereMonth('tanggal_awal','=', $month)
        $data = self::when($month, function ($query) use ($month) {
            $query->whereMonth('tanggal_awal', $month);
        })->when($year, function ($query) use ($year) {
            $query->whereYear('tanggal_awal', $year);
        })->when($fakultas, function ($query) use ($fakultas) {
            $query->whereIn('fakultas_pihak', [$fakultas, 1000]);
        })->count();
        // dd($data);
        return $data;
    }

    public function getBentukKegiatan()
    {
        return $this->hasMany(MouRequestBentukKegiatanKerjasama::class, 'id_mou', 'id');
    }

    public static function countBentukKegiatan($kegiatan = null, $year = null, $fakultas = null, $prodi = null)
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
            $query->where('prodi', $prodi);
        })->count();
        // dd($data);
        return $data;
    }

    public static function countNegara($negara = null, $year = null, $fakultas = null, $prodi = null)
    {
        $data = self::where('status', 1)
            ->when($negara, function ($query) use ($negara) {
                $query->where('negara', $negara);
            })->when($year, function ($query) use ($year) {
                $query->whereYear('tanggal_awal', $year);
            })->when($fakultas, function ($query) use ($fakultas) {
                $query->where('fakultas_pihak', $fakultas);
            })->when($prodi, function ($query) use ($prodi) {
                $query->where('prodi', $prodi);
            })->count();
        // dd($data);
        return $data;
    }

    public function getPenggiatKerjasama()
    {
        return $this->hasMany(MouRequestPenggiat::class, 'id_lapkerma', 'id');
    }

    public static function countBadanKemitraan($kemitraan = null, $year = null, $fakultas = null, $prodi = null)
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
            $query->where('prodi', $prodi);
        })->count();
        // dd($data);
        return $data;
    }

    public static function countPtqs($ptqs = null, $year = null, $fakultas = null, $prodi = null)
    {
        $data = self::whereHas('getPenggiatKerjasama', function ($query) use ($ptqs) {
            $query->when($ptqs, function ($query) use ($ptqs) {
                $query->where('ptqs', $ptqs);
            })->groupBy('nama_pihak');
        })->when($year, function ($query) use ($year) {
            $query->whereYear('tanggal_awal', $year);
        })->when($fakultas, function ($query) use ($fakultas) {
            $query->where('fakultas_pihak', $fakultas);
        })->when($prodi, function ($query) use ($prodi) {
            $query->where('prodi', $prodi);
        })->count();
        // dd($data);
        return $data;
    }

    public static function countPerguruanTinggi($pt = null, $year = null, $fakultas = null, $prodi = null)
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
            $query->where('prodi', $prodi);
        })->count();
        // dd($data);
        return $data;
    }
}
