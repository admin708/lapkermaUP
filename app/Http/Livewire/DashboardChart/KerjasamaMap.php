<?php

namespace App\Http\Livewire\DashboardChart;

use Livewire\Component;
use App\Models\Instansi;
use App\Models\Negara;

class KerjasamaMap extends Component
{


    public $negaraName;
    public $dataKerjaSamaNegara;
    public $mapVisibility;

    protected $listeners = ['setNegaraName'];

    public function mount()
    {
        $this->mapVisibility = true;
        $this->fetchAllNegaraData(); // Memanggil fungsi untuk ambil data semua negara
    }

    public function fetchAllNegaraData()
    {
        // Ambil data Instansi dari database tanpa filter negara
        $this->dataKerjaSamaNegara = Instansi::all(['name', 'coordinates']); // Ambil nama dan koordinat instansi

        return $this->dataKerjaSamaNegara;

        // // Kirim data ke frontend
        // $this->emit('dataKerjaSamaNegaraUpdate', $this->dataKerjaSamaNegara);
    }




    public function setNegaraName($name)
    {
        $this->negaraName = $name;
        $this->fetchNegaraData();
    }

    public function fetchNegaraData()
    {
        $name = $this->negaraName;

        $idNegara = Negara::where('name', '=', $name)->first();
        
        // Ambil data Instansi berdasarkan negara
        $this->dataKerjaSamaNegara = Instansi::where('negara_id', '=', $idNegara->id)->get(['name', 'coordinates']);
        
        
        // Emit data ke frontend
        $this->emit('dataKerjaSamaNegaraUpdate', $this->dataKerjaSamaNegara);
    }

    public function render()
    {
        //$negaraData = $this->fetchAllNegaraData();
        $negaraData = [];
        return view('livewire.dashboard-chart.kerjasama-map', ['dataKerjaSamaNegaraUpdate' => $negaraData]);
    }
}

