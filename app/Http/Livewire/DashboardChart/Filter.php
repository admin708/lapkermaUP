<?php

namespace App\Http\Livewire\DashboardChart;
use App\Models\Fakultas;
use App\Models\Prodi;
use Livewire\Component;

class Filter extends Component
{
    public $searchYear, $searchFakultas, $searchProdi, $getSelectFakultas, $getSelectProdi;
    public function mount()
    {
        // $this->searchYear = Carbon::now()->format('Y');
        $this->getSelectFakultas = Fakultas::get();
        $this->getSelectProdi = [];
    }
    public function render()
    {
        return view('livewire.dashboard-chart.filter');
    }
    public function updatedSearchYear()
    {
        $this->emit('searchBy', $this->searchYear, $this->searchFakultas, $this->searchProdi);
    }

    public function updatedSearchFakultas()
    {
        $this->reset('searchProdi');
        $this->emit('searchBy', $this->searchYear, $this->searchFakultas, $this->searchProdi);
        $this->getSelectProdi = Prodi::where('id_fakultas', $this->searchFakultas)->orderBy('nama_resmi', 'asc')->get();
    }

    public function updatedSearchProdi()
    {
        $this->emit('searchBy', $this->searchYear, $this->searchFakultas, $this->searchProdi);
    }
}
