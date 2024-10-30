<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MouRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_instansi',
        'tipe_kerjasama',
        'negara',
        'tanggal_ttd',
        'durasi',
        'nama_pejabat_pihak',
        'jabatan_pejabat_pihak',
        'pj_pihak',
        'jabatan_pj_pihak',
        'email_pj_pihak',
        'hp_pj_pihak',
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
}
