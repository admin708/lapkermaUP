<?php

namespace App\Http\Livewire\Datatables;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Prodi;
use App\Models\DataMoa;
use App\Models\DataIa;
use App\Models\DataIaPenggiat;
use App\Models\DataMoaPenggiat;
use Illuminate\Support\Facades\DB;

class IkuDatatables extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $kerjasamaId, $orderBy, $orderDirection, $perPage, $tahun, $jenjang, $searchProdi;
    public $orderByText, $orderDirectionText, $kerjaSamaText, $tahunText, $jenjangText;
    public $availableYears = [];

    public function mount()
    {
        $this->orderBy = "prodi_id";
        $this->orderDirection = "asc";
        $this->orderByText = 'Urut Berdasarkan';
        $this->kerjaSamaText = 'Semua Kerja Sama';
        $this->tahunText = 'Semua Tahun';
        $this->jenjangText = 'Jenjang';
        $this->perPage = 10;
        $this->availableYears = $this->getAvailableYears(); // Dapatkan daftar tahun yang tersedia
    }

    public function updated()
    {
        $this->resetPage();
    }

    public static function getReferenceCounts(
        $kerjasama_id = null,
        $orderBy = 'total_reference_count',
        $orderDirection = 'asc',
        $tahun = null,
        $jenjang = null,
        $searchProdi = null // Add the searchProdi parameter
    ) {
        $prodiQuery = Prodi::query()
            ->select('prodis.id AS prodi_id', 'prodis.nama_resmi AS prodi_name')
            ->when($searchProdi, function ($query) use ($searchProdi) {
                return $query->where('prodis.nama_resmi', 'like', '%' . $searchProdi . '%'); // Filter by searchProdi
            });

        // MoA count subquery
        $moaCounts = DataMoa::select('prodi_id')
            ->when($kerjasama_id, function ($query) use ($kerjasama_id) {
                return $query->where('jenis_kerjasama', $kerjasama_id);
            })
            ->when($tahun, function ($query) use ($tahun) {
                return $query->whereYear('tanggal_ttd', $tahun);
            })
            ->selectRaw('COUNT(prodi_id) AS moa_reference_count')
            ->groupBy('prodi_id');

        // IA count subquery
        $iaCounts = DataIa::select('prodi_id')
            ->when($kerjasama_id, function ($query) use ($kerjasama_id) {
                return $query->where('jenis_kerjasama', $kerjasama_id);
            })
            ->when($tahun, function ($query) use ($tahun) {
                return $query->whereYear('tanggal_ttd', $tahun);
            })
            ->selectRaw('COUNT(prodi_id) AS ia_reference_count')
            ->groupBy('prodi_id');

        // IA Penggiat count subquery
        $iaPenggiatCounts = DataIaPenggiat::select('data_ia.prodi_id')
            ->join('data_ia', 'data_ia.id', '=', 'data_ia_penggiat.id_lapkerma')
            ->join('referensi_badan_kemitraans', 'referensi_badan_kemitraans.id', '=', 'data_ia_penggiat.badan_kemitraan')
            ->when($kerjasama_id, function ($query) use ($kerjasama_id) {
                return $query->where('data_ia.jenis_kerjasama', $kerjasama_id);
            })
            ->when($tahun, function ($query) use ($tahun) {
                return $query->whereYear('data_ia.tanggal_ttd', $tahun);
            })
            ->where('data_ia_penggiat.nama_pihak', '!=', 'Universitas Hasanuddin')
            ->selectRaw('COUNT(data_ia.prodi_id) AS ia_penggiat_reference_count, SUM(referensi_badan_kemitraans.bobot) AS ia_score')
            ->groupBy('data_ia.prodi_id');

        // MoA Penggiat count subquery
        $moaPenggiatCounts = DataMoaPenggiat::select('data_moa.prodi_id')
            ->join('data_moa', 'data_moa.id', '=', 'data_moa_penggiat.id_lapkerma')
            ->join('referensi_badan_kemitraans', 'referensi_badan_kemitraans.id', '=', 'data_moa_penggiat.badan_kemitraan')
            ->when($kerjasama_id, function ($query) use ($kerjasama_id) {
                return $query->where('data_moa.jenis_kerjasama', $kerjasama_id);
            })
            ->when($tahun, function ($query) use ($tahun) {
                return $query->whereYear('data_moa.tanggal_ttd', $tahun);
            })
            ->where('data_moa_penggiat.nama_pihak', '!=', 'Universitas Hasanuddin')
            ->selectRaw('COUNT(data_moa.prodi_id) AS moa_penggiat_reference_count, SUM(referensi_badan_kemitraans.bobot) AS moa_score')
            ->groupBy('data_moa.prodi_id');

        // Combine counts and sum
        $query = $prodiQuery
            ->leftJoinSub($moaCounts, 'moa_counts', function ($join) {
                $join->on('prodis.id', '=', 'moa_counts.prodi_id');
            })
            ->leftJoinSub($iaCounts, 'ia_counts', function ($join) {
                $join->on('prodis.id', '=', 'ia_counts.prodi_id');
            })
            ->leftJoinSub($iaPenggiatCounts, 'ia_penggiat_counts', function ($join) {
                $join->on('prodis.id', '=', 'ia_penggiat_counts.prodi_id');
            })
            ->leftJoinSub($moaPenggiatCounts, 'moa_penggiat_counts', function ($join) {
                $join->on('prodis.id', '=', 'moa_penggiat_counts.prodi_id');
            })
            ->select(
                'prodis.id AS prodi_id',
                'prodis.nama_resmi AS prodi_name',
                'moa_counts.moa_reference_count',
                'ia_counts.ia_reference_count',
                'ia_penggiat_counts.ia_penggiat_reference_count',
                'moa_penggiat_counts.moa_penggiat_reference_count',
                DB::raw('(COALESCE(ia_counts.ia_reference_count, 0) + 
                  COALESCE(moa_counts.moa_reference_count, 0)) AS total_reference_count'),
                DB::raw('ROUND(((
                    COALESCE(ia_penggiat_counts.ia_score, 0) + 
                    COALESCE(moa_penggiat_counts.moa_score, 0)) / (
                    SELECT COUNT(*) 
                    FROM prodis 
                    WHERE jenjang = "sarjana"
                ) * 100), 2) AS skor_iku'),
            )
            ->when($jenjang, function ($query) use ($jenjang) {
                return $query->where('prodis.jenjang', $jenjang);
            })
            ->orderBy($orderBy, $orderDirection);

        return $query;
    }

    public function render()
    {
        // $this->check();
        // Dapatkan data dengan pagination, tambahkan filter tahun jika ada
        $referenceCounts = $this->getReferenceCounts($this->kerjasamaId, $this->orderBy, $this->orderDirection, $this->tahun, $this->jenjang, $this->searchProdi)
            ->paginate($this->perPage); // Sesuaikan jumlah item per halaman

        return view('livewire.datatables.iku-datatables', [
            'referenceCounts' => $referenceCounts,
            'orderBy' => $this->orderBy,
            'orderByText' => $this->orderByText,
            'kerjasamaId' => $this->kerjasamaId,
            'kerjaSamaText' => $this->kerjaSamaText,
            'orderDirection' => $this->orderDirection,
            'orderDirectionText' => $this->orderDirectionText,
            'tahunText' => $this->tahunText,
            'availableYears' => $this->availableYears,
            'jenjang' => $this->jenjang,
            'jenjangText' => $this->jenjangText,
        ]);
    }

    public function setKerjasamaId($id, $text)
    {
        $this->kerjasamaId = $id;
        $this->kerjaSamaText = $text;
        $this->resetPage();
    }

    public function setOrderBy($column, $text)
    {
        $this->orderBy = $column;
        $this->orderByText = $text;
        $this->resetPage();
    }

    public function setOrderDirection()
    {
        $this->orderDirection = $this->orderDirection === "asc" ? "desc" : "asc";
        $this->updated();
    }

    public function setPerPage($number)
    {
        $this->perPage = $number;
        $this->resetPage();
    }

    public function setTahun($tahun, $text)
    {
        $this->tahun = $tahun;
        $this->tahunText = $text;
        $this->resetPage();
    }

    public function setJenjang($jenjangText, $jenjang)
    {
        $this->jenjangText = $jenjangText;
        $this->jenjang = $jenjang;
        $this->resetPage();
    }

    protected function getAvailableYears()
    {
        $years = Prodi::selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        if (!in_array(2024, $years)) {
            $years[] = 2024;
        }


        rsort($years); // Urutkan kembali dari besar ke kecil
        return $years;
    }
}
