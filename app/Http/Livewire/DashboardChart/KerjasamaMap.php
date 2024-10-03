<?php

namespace App\Http\Livewire\DashboardChart;

use Livewire\Component;
use App\Models\Negara;

class KerjasamaMap extends Component
{
    public $negaraName;
    public $dataKerjaSamaNegara;

    protected $listeners = ['setNegaraName'];

    public function mount()
    {
        $this->negaraName = 'Japan';
        $this->fetchNegaraData();
    }

    public function setNegaraName($name)
    {
        $this->negaraName = $name;
        $this->fetchNegaraData();
    }

    public function fetchNegaraData()
    {
        $negaraModel = new Negara();
        $this->dataKerjaSamaNegara = $negaraModel->getNegaraWithInstansiByName($this->negaraName);
        $this->render();

        $this->emit('dataKerjaSamaNegaraUpdate', $this->dataKerjaSamaNegara);
    }

    public function render()
    {
        return view('livewire.dashboard-chart.kerjasama-map', [
            'negaraName' => $this->negaraName,
            'dataKerjaSamaNegara' => $this->dataKerjaSamaNegara
        ]);
    }
}
