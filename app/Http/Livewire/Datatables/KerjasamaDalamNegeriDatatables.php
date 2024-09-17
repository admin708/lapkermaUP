<?php

namespace App\Http\Livewire\Datatables;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Prodi;

class KerjasamaDalamNegeriDatatables extends Component
{
    use WithPagination;

    public $kerjasamaId = null;
    public $orderBy = 'prodi_id';
    public $orderDirection = 'asc';
    public $orderByText = 'Urut Berdasarkan';
    public $kerjaSamaText = 'All';
    public $perPage = 10;
    public $referenceCounts;

    protected $paginationTheme = 'bootstrap';

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['kerjasamaId', 'orderBy', 'orderDirection'])) {
            $this->fetchData();
        }
    }

    public function render()
{
    return view('livewire.datatables.kerjasama-dalam-negeri-datatables', [
        'referenceCounts' => $this->getPaginatedData(),
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
        $this->orderDirection = $this->orderDirection === 'asc' ? 'desc' : 'asc';
    }

    protected function fetchData()
    {
        $this->referenceCounts = Prodi::getReferenceCounts($this->kerjasamaId, $this->orderBy, $this->orderDirection);
    }

    public function referenceCounts()
    {
        return $this->referenceCounts;
    }

    private function getPaginatedData()
{
    return Prodi::query()
        ->when($this->kerjasamaId, function($query) {
            $query->where('kerjasama_id', $this->kerjasamaId);
        })
        ->orderBy($this->orderBy, $this->orderDirection)
        ->paginate($this->perPage);
}
}

