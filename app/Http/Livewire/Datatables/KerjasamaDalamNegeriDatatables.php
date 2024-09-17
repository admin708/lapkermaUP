<?php

namespace App\Http\Livewire\Datatables;

use Livewire\Component;
use App\Models\Prodi;

class KerjasamaDalamNegeriDatatables extends Component
{

    public $referenceCounts, $kerjasamaId, $orderBy, $orderDirection;
    public $orderByText, $orderDirectionText, $kerjaSamaText ;

    public function mount()
    {
        $orderBy = "prodi_id";
        $orderDirection = "asc";
        $this->orderByText = 'Urut Berdasarkan';
        $this->kerjaSamaText = 'All';
        $this->referenceCounts = Prodi::getReferenceCounts($this->kerjasamaId, $orderBy, $orderDirection);
    }

    public function updated()
    {
        $this->referenceCounts = Prodi::getReferenceCounts($this->kerjasamaId, $this->orderBy, $this->orderDirection);
    }
    public function render()
    {
        return view('livewire.datatables.kerjasama-dalam-negeri-datatables', [
            'referenceCounts' => $this->referenceCounts,
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
        $this->updated();
    }

    public function setOrderBy($column, $text)
    {
        $this->orderBy = $column;
        $this->orderByText = $text;
        $this->updated();
    }

    public function setOrderDirection(){
        $this->orderDirection = $this->orderDirection === "asc" ? "desc" : "asc"  ;
        $this->updated();
    }
}
