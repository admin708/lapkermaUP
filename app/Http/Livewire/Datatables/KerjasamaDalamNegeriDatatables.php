<?php

namespace App\Http\Livewire\Datatables;

use Livewire\Component;
use App\Models\Prodi;

class KerjasamaDalamNegeriDatatables extends Component
{

    public $referenceCounts;

    public function mount()
    {
        $this->referenceCounts = Prodi::getReferenceCounts();
    }

    public function render()
    {
        return view('livewire.datatables.kerjasama-dalam-negeri-datatables');
    }
}
