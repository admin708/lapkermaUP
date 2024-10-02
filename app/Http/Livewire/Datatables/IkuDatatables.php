<?php

namespace App\Http\Livewire\Datatables;

use Livewire\Component;
use Livewire\WithPagination; // Tambahkan trait WithPagination
use App\Models\Prodi;

class IkuDatatables extends Component
{
    use WithPagination; // Gunakan WithPagination untuk mengaktifkan pagination

    protected $paginationTheme = 'bootstrap'; // Opsional: Gunakan tema Bootstrap untuk pagination (sesuaikan dengan CSS yang digunakan)

    public $kerjasamaId, $orderBy, $orderDirection, $perPage;
    public $orderByText, $orderDirectionText, $kerjaSamaText;

    public function mount()
    {
        $this->orderBy = "prodi_id";
        $this->orderDirection = "asc";
        $this->orderByText = 'Urut Berdasarkan';
        $this->kerjaSamaText = 'All';
        $this->perPage = 10;
    }

    public function updated()
    {
        $this->resetPage(); // Reset pagination setiap kali filter diubah
    }

    public function render()
    {
        // Dapatkan data dengan pagination
        $referenceCounts = Prodi::getReferenceCounts($this->kerjasamaId, $this->orderBy, $this->orderDirection)
            ->paginate($this->perPage); // 10 item per halaman

        return view('livewire.datatables.iku-datatables', [
            'referenceCounts' => $referenceCounts,
            'orderBy' => $this->orderBy,
            'orderByText' => $this->orderByText,
            'kerjasamaId' => $this->kerjasamaId,
            'kerjaSamaText' => $this->kerjaSamaText,
            'orderDirection' => $this->orderDirection,
            'orderDirectionText' => $this->orderDirectionText
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
}
