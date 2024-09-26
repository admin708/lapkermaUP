<?php

namespace App\Http\Livewire\DashboardChart;

use Livewire\Component;
use App\Models\Negara;

class KerjasamaMap extends Component
{
    public $negaraName;
    public $dataKerjaSamaNegara; 

    protected $listeners = ['negaraName' => 'setNegaraName'];

    public function mount(){
        $this->dataKerjaSamaNegara = null;
    }

    public function setNegaraName($name)
    {
        $this->negaraName = $name;
    }

    public function fetchNegaraData()
    {
        $negaraModel = new Negara(); // Create an instance of the Negara model
        $negaraModel->getNegaraWithInstansiByName($this->negaraName); // Call the model method
        $this->dataKerjaSamaNegara = $negaraModel->dataKerjaSamaNegara; // Store the result
    }

    public function render()
    {
        return view('livewire.dashboard-chart.kerjasama-map', [
            'negaraName' => $this->negaraName,
            'dataKerjaSamaNegara' => $this->dataKerjaSamaNegara
        ]);
    }
}
