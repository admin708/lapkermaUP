<?php

namespace App\Http\Livewire\DashboardChart;

use Livewire\Component;
use App\Models\Instansi;

class KerjasamaMap extends Component
{
    public $negaraName;
    public $dataKerjaSamaNegara;
    public $mapVisibility;

    protected $listeners = ['setNegaraName'];

    public function mount()
    {
        $this->negaraName = 'Japan'; // Set default negara
        $this->mapVisibility = true;
        $this->fetchNegaraData();
    }

    public function setNegaraName($name)
    {
        $this->negaraName = $name;
        $this->fetchNegaraData();
    }

    public function fetchNegaraData()
    {
        $name = $this->negaraName;

        // Ambil data Instansi berdasarkan negara
        $this->dataKerjaSamaNegara = Instansi::whereHas('getNegara', function ($query) use ($name) {
            $query->where('name', strval($name));
        })->get(['name', 'coordinates']); // Ambil nama dan koordinat instansi

        // Emit data ke frontend
        $this->emit('dataKerjaSamaNegaraUpdate', $this->dataKerjaSamaNegara);
    }

    public function render()
    {
        return view('livewire.dashboard-chart.kerjasama-map', [
            'negaraName' => $this->negaraName,
            'dataKerjaSamaNegara' => $this->dataKerjaSamaNegara,
        ]);
    }
}
