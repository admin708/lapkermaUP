<?php

namespace App\Http\Livewire\Datatables;

use Livewire\Component;
use App\Models\Prodi;

class KerjasamaDalamNegeriDatatables extends Component
{

    public $referenceCounts;
    public $filterType = 1; // Default to Dalam Negeri

    public function mount()
    {
        $this->updateReferenceCounts();
    }

    public function updateFilter($filterType)
    {
        $this->filterType = $filterType;
        $this->updateReferenceCounts();
    }

    private function updateReferenceCounts()
    {
        $this->referenceCounts = Prodi::getReferenceCounts($this->filterType);
    }


    public function render()
    {
        return view('livewire.datatables.kerjasama-dalam-negeri-datatables');
    }
}
