<?php

namespace App\Http\Livewire\Datatables;

use Livewire\Component;
use Livewire\WithPagination; 
use App\Models\Prodi;

class IkuDatatables extends Component
{
    use WithPagination; 
    protected $paginationTheme = 'bootstrap'; 

    public $kerjasamaId, $orderBy, $orderDirection, $perPage, $tahun;
    public $orderByText, $orderDirectionText, $kerjaSamaText, $tahunText;
    public $availableYears = [];

    public function mount()
    {
        $this->orderBy = "prodi_id";
        $this->orderDirection = "asc";
        $this->orderByText = 'Urut Berdasarkan';
        $this->kerjaSamaText = 'Semua Kerja Sama';
        $this->tahunText = 'Semua Tahun';
        $this->perPage = 10;
        $this->availableYears = $this->getAvailableYears(); // Dapatkan daftar tahun yang tersedia
    }

    public function updated()
    {
        $this->resetPage(); 
    }

    public function render()
    {
        // Dapatkan data dengan pagination, tambahkan filter tahun jika ada
        $referenceCounts = Prodi::getReferenceCounts($this->kerjasamaId, $this->orderBy, $this->orderDirection, $this->tahun)
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
            'availableYears' => $this->availableYears
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
