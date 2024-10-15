<?php

namespace App\Http\Livewire\DashboardChart;

use Livewire\Component;
use App\Models\Negara;

class KerjasamaMap extends Component
{
    public $negaraName;
    public $dataKerjaSamaNegara;
    public $mapVisible; // Menambahkan properti untuk visibilitas peta

    protected $listeners = ['setNegaraName'];

    public function mount()
    {
        $this->negaraName = 'Japan';
        $this->mapVisible = true; // Set default visibility to true
        $this->fetchNegaraData();
    }

    public function setNegaraName($name)
    {
        $this->negaraName = $name;
        $this->fetchNegaraData();
    }

    public function toggleMapVisibility()
    {
        $this->mapVisible = !$this->mapVisible; // Toggle the visibility state
        $this->emit('mapVisibilityChanged', $this->mapVisible); // Emit event to notify frontend
    }

    public function fetchNegaraData()
    {
        $negaraModel = new Negara();
        $this->dataKerjaSamaNegara = $negaraModel->getNegaraWithInstansiByName($this->negaraName);
        $this->emit('dataKerjaSamaNegaraUpdate', $this->dataKerjaSamaNegara);
    }

    public function render()
    {
        return view('livewire.dashboard-chart.kerjasama-map', [
            'negaraName' => $this->negaraName,
            'dataKerjaSamaNegara' => $this->dataKerjaSamaNegara,
            'mapVisible' => $this->mapVisible // Pass the visibility state to the view
        ]);
    }
}
