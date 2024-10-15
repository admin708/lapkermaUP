<?php

namespace App\Http\Livewire\DashboardChart;

use Livewire\Component;
use App\Models\Negara;

class KerjasamaMap extends Component
{
    public $negaraName;
    public $dataKerjaSamaNegara;
    public $mapVisibility;

    protected $listeners = ['setNegaraName', 'setMapVisibility'];

    public function mount()
    {
        $this->negaraName = 'Japan';
        $this->mapVisibility = true;
        $this->fetchNegaraData();
    }

    public function setNegaraName($name)
    {
        $this->negaraName = $name;
        $this->fetchNegaraData();
    }

    public function setMapVisibility(){
        if(!$this->mapVisibility){
            $this->mapVisibility = true;
        } else {
            $this->mapVisibility = !$this->mapVisibility;
        }
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
