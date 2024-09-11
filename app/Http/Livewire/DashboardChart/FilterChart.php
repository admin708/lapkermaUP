<?php

namespace App\Http\Livewire\DashboardChart;

use App\Models\{DataMou, DataMoa, DataIa};
use App\Models\Fakultas;
use App\Models\Prodi;
use Livewire\Component;
use Carbon\Carbon;

class FilterChart extends Component
{
    public $searchYear, $searchFakultas, $searchProdi, $getSelectFakultas, $getSelectProdi;
    public $countMoU, $countMoA, $countIA, $open = 1;

    public function mount()
    {
        // $this->searchYear = Carbon::now()->format('Y');
        $this->getSelectFakultas = Fakultas::get();
        $this->getSelectProdi = [];
        $this->countMoU = DataMou::countBy(null, $this->searchYear) ;
        $this->countMoA = DataMoa::countBy(null, $this->searchYear)  ;
        $this->countIA = DataIa::countBy(null, $this->searchYear)  ;
    }

    public function render()
    {
        return view('livewire.dashboard-chart.filter-chart');
    }

    public function updatedSearchYear()
    {
        if ($this->searchYear == 'all') {
            $this->searchYear = null;
        }
        $this->emit('searchBy', $this->searchYear, $this->searchFakultas, $this->searchProdi);
        $this->countMoU = DataMou::countBy(null, $this->searchYear, $this->searchFakultas);
        $this->countMoA = DataMoa::countBy(null, $this->searchYear, $this->searchFakultas, $this->searchProdi);
        $this->countIA = DataIa::countBy(null, $this->searchYear, $this->searchFakultas, $this->searchProdi);
    }

    public function updatedSearchFakultas()
    {
        if ($this->searchFakultas == 'all') {
            $this->searchFakultas = null;
        }
        $this->reset('searchProdi');
        $this->emit('searchBy', $this->searchYear, $this->searchFakultas, $this->searchProdi);
        $this->getSelectProdi = Prodi::where('id_fakultas', $this->searchFakultas)->orderBy('nama_resmi', 'asc')->get();
        $this->countMoU = DataMou::countBy(null, $this->searchYear, $this->searchFakultas) ;
        $this->countMoA = DataMoa::countBy(null, $this->searchYear, $this->searchFakultas, $this->searchProdi);
        $this->countIA = DataIa::countBy(null, $this->searchYear, $this->searchFakultas, $this->searchProdi);
    }

    public function updatedSearchProdi()
    {
        if ($this->searchProdi == 'all') {
            $this->searchProdi = null;
        }
        $this->emit('searchBy', $this->searchYear, $this->searchFakultas, $this->searchProdi);
        $this->countMoU = DataMou::countBy(null, $this->searchYear, $this->searchFakultas) ;
        $this->countMoA = DataMoa::countBy(null, $this->searchYear, $this->searchFakultas, $this->searchProdi);
        $this->countIA = DataIa::countBy(null, $this->searchYear, $this->searchFakultas, $this->searchProdi);
    }
}
