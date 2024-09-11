<?php

namespace App\Http\Livewire\DashboardChart;

use Livewire\Component;
use App\Models\{LapkermaRefBentukKegiatan, DataMouPenggiat, DataMoaPenggiat, DataIaPenggiat,
     DataMouBentukKegiatanKerjasama, DataMou, DataMoa, DataIa, Negara, Prodi, ReferensiBadanKemitraan};

class Table2Dashboard extends Component
{
    public $year, $fakultas, $prodi;
    public $getProdi;
    protected $listeners = ['searchBy' => 'searchBy',];

    
    public function render()
    {
        return view('livewire.dashboard-chart.table2-dashboard');
    }

    public function searchBy($year, $fakultas, $prodi)
    {
        $this->year = $year;
        $this->fakultas = $fakultas;
        $this->prodi = $prodi;
        $this->getProdi = Prodi::where('id_fakultas', $fakultas)->orderBy('nama_resmi', 'asc')->get();
    }
}
