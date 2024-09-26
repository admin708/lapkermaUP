<?php

namespace App\Http\Livewire\DashboardChart;

use Livewire\Component;
use App\Models\Negara;

class KerjasamaMap extends Component
{
    public $negaraName;
    public $dataKerjaSamaNegara;

    // Listen to the negaraName event
    protected $listeners = ['negaraName' => 'setNegaraName'];

    public function mount()
    {
        // Set default country to Indonesia
        $this->negaraName = 'japan';
        $this->fetchNegaraData(); // Fetch data for the default country
    }

    public function setNegaraName($name)
    {
        $this->negaraName = $name;
        $this->fetchNegaraData(); // Fetch data when the country name is changed
    }

    public function fetchNegaraData()
    {
        // Fetch the data related to the selected country
        $negaraModel = new Negara();
        $this->dataKerjaSamaNegara = $negaraModel->getNegaraWithInstansiByName($this->negaraName); // Fetch data and store it
    }

    public function render()
    {
        return view('livewire.dashboard-chart.kerjasama-map', [
            'negaraName' => $this->negaraName,
            'dataKerjaSamaNegara' => $this->dataKerjaSamaNegara
        ]);
    }
}
