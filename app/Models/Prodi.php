<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_resmi', 'id_fakultas', 'is_eksakta'
    ];

    public function fakultas()
    {
        return $this->belongsTo('App\Models\Fakultas', 'id_fakultas');
    }

    public function getMoa()
    {
        return $this->hasMany('App\Models\DataMoa', 'prodi_id', 'id');
    }

    public function getIa()
    {
        return $this->hasMany('App\Models\DataIa', 'prodi_id', 'id');
    }

    //Mendapatkan data MoU

    public function getMou()
    {
        return $this->hasMany('App\Models\DataMou', 'prodi_id', 'id');
    }

    public static function getReferenceCounts($kerjasama_id = null)
{
    $moaCounts = DataMoa::select('prodi_id')
        ->when($kerjasama_id, function ($query) use ($kerjasama_id) {
            return $query->where('jenis_kerjasama', $kerjasama_id);
        })
        ->selectRaw('COUNT(*) AS moa_reference_count')
        ->groupBy('prodi_id');
    
    $mouCounts = DataMou::select('prodi_id')
    ->when($kerjasama_id, function ($query) use ($kerjasama_id) {
        return $query->where('jenis_kerjasama', $kerjasama_id);
    })
    ->selectRaw('COUNT(*) AS mou_reference_count')
    ->groupBy('prodi_id');

    $iaCounts = DataIa::select('prodi_id')
    ->when($kerjasama_id, function ($query) use ($kerjasama_id) {
        return $query->where('jenis_kerjasama', $kerjasama_id);
    })
    ->selectRaw('COUNT(*) AS ia_reference_count')
    ->groupBy('prodi_id');

    return self::leftJoinSub($moaCounts, 'moa_counts', function ($join) {
        $join->on('prodis.id', '=', 'moa_counts.prodi_id');
    })
    ->leftJoinSub($mouCounts, 'mou_counts', function ($join) {
        $join->on('prodis.id', '=', 'mou_counts.prodi_id');
    })
    ->leftJoinSub($iaCounts, 'ia_counts', function ($join) {
        $join->on('prodis.id', '=', 'ia_counts.prodi_id');
    })
    ->select(
        'prodis.id AS prodi_id',
        'prodis.nama_resmi AS prodi_name',
        'moa_counts.moa_reference_count',
        'mou_counts.mou_reference_count',
        'ia_counts.ia_reference_count',
        DB::raw('(COALESCE(moa_counts.moa_reference_count, 0) + 
                  COALESCE(mou_counts.mou_reference_count, 0) + 
                  COALESCE(ia_counts.ia_reference_count, 0)) AS total_reference_count')
    )
    ->orderBy('total_reference_count', 'desc')
    ->get();
}

}