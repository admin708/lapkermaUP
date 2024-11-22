<?php

namespace App\Http\Livewire\Datatables;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Instansi;
use App\Models\Negara;
use Illuminate\Support\Facades\DB;

class JumlahMitra extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    

    public $kerjasamaId, $orderBy, $orderDirection, $perPage, $tahun, $jenjang, $searchProdi;
    public $orderByText, $orderDirectionText, $kerjaSamaText, $tahunText, $jenjangText;
    public $instansiTipe, $instansiTipeText, $availableYears = [];

    public function mount()
    {
        $this->orderBy = "name"; // Mengurutkan berdasarkan nama instansi
        $this->orderDirection = "asc";
        $this->orderByText = 'Urut Berdasarkan';
        $this->kerjaSamaText = 'Semua Kerja Sama';
        $this->tahunText = 'Semua Tahun';
        $this->instansiTipeText = 'Semua Instansi';
        $this->perPage = 10;
        $this->availableYears = $this->getAvailableYears(); // Dapatkan daftar tahun yang tersedia
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function getReferenceCounts()
    {
        $instansis = Instansi::query();
    
        // Join dengan tabel negara untuk mendapatkan nama negara
        $instansis->leftJoin('negaras', 'instansis.negara_id', '=', 'negaras.id')
                  ->addSelect('negaras.name as negara_name') // Menambahkan kolom negara_name
                  ->addSelect('instansis.name', 'instansis.address', 'instansis.ptqs', 'instansis.badan_kemitraan'); // Memastikan kolom lain yang diperlukan tersedia
    
        // Filter berdasarkan tipe instansi
        if ($this->instansiTipe) {
            if ($this->instansiTipe === 'dalam_negri') {
                $instansis->where('negara_id', 103);
            } else {
                $instansis->where('negara_id', '!=', 103);
            }
        }
    
        // Penerapan pencarian berdasarkan nama instansi dan alamat
        if ($this->searchProdi) {
            $instansis->where(function($query) {
                $query->where('name', 'like', '%' . $this->searchProdi . '%')
                      ->orWhere('address', 'like', '%' . $this->searchProdi . '%');
            });
        }
    
        // Filter berdasarkan tahun jika ada
        if ($this->tahun) {
            $instansis->whereYear('created_at', $this->tahun);
        }
    
        // Urutkan berdasarkan kolom dan arah yang dipilih
        if ($this->orderBy === 'name') {
            $instansis->orderBy('instansis.name', $this->orderDirection);
        } else {
            $instansis->orderBy($this->orderBy, $this->orderDirection);
        }
    
        return $instansis->paginate($this->perPage);
    }
    
    public function render()
    {
        $referenceCounts = $this->getReferenceCounts(); // Ambil data dengan filter dan urutan

        return view('livewire.datatables.jumlah-mitra', [
            'referenceCounts' => $referenceCounts,
            'orderBy' => $this->orderBy,
            'orderByText' => $this->orderByText,
            'kerjasamaId' => $this->kerjasamaId,
            'kerjaSamaText' => $this->kerjaSamaText,
            'orderDirection' => $this->orderDirection,
            'orderDirectionText' => $this->orderDirectionText,
            'tahunText' => $this->tahunText,
            'availableYears' => $this->availableYears,
            'instansiTipeText' => $this->instansiTipeText,
            'jenjang' => $this->jenjang,
            'jenjangText' => $this->jenjangText,
        ]);
    }

    public function negara()
{
    return $this->belongsTo(Negara::class, 'negara_id');
}


    // Set parameter untuk Kerjasama ID
    public function setKerjasamaId($id, $text)
    {
        $this->kerjasamaId = $id;
        $this->kerjaSamaText = $text;
        $this->resetPage();
    }

    // Set parameter untuk kolom pengurutan
    public function setOrderBy($column, $text)
    {
        $this->orderBy = $column;
        $this->orderByText = $text;
        $this->resetPage();
    }

    // Toggle urutan (asc/desc)
    public function setOrderDirection()
    {
        $this->orderDirection = $this->orderDirection === "asc" ? "desc" : "asc";
        $this->updated();
    }

    // Set jumlah item per halaman
    public function setPerPage($number)
    {
        $this->perPage = $number;
        $this->resetPage();
    }

    // Set filter untuk tahun
    public function setTahun($tahun, $text)
    {
        $this->tahun = $tahun;
        $this->tahunText = $text;
        $this->resetPage();
    }

    // Get daftar tahun yang tersedia untuk dropdown
    protected function getAvailableYears()
    {
        $years = Instansi::selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

            $years = array_filter($years, function ($year) {
                return $year != 0;
            });

        if (!in_array(2024, $years)) {
            $years[] = 2024;
        }

        rsort($years); // Urutkan dari yang terbesar ke terkecil
        return $years;
    }

    // Set filter untuk tipe instansi (dalam negri/luar negri)
    public function setInstansiTipe($type, $text)
    {
        $this->instansiTipe = $type;
        $this->instansiTipeText = $text;
        $this->resetPage();
    }
}
