<?php

namespace App\Http\Livewire\DashboardChart;

use Livewire\Component;
use App\Models\{LapkermaRefBentukKegiatan, DataMouPenggiat, DataMoaPenggiat, DataIaPenggiat,
    DataMouBentukKegiatanKerjasama, DataMou, DataMoa, DataIa, Negara, ReferensiBadanKemitraan};
    use Carbon\Carbon;

class Map extends Component
{
    public $data2 = [], $refNegara, $year, $fakultas, $prodi, $reRenderChart = false;

    protected $listeners = ['searchBy' => 'searchBy',];

    public function mount()
    {
        // $this->year = Carbon::now()->format('Y');
        $this->refNegara = Negara::get();
    }

    public function render()
    {
        foreach ($this->refNegara as $key => $item)
        {
            $cek = DataMou::countNegara($item->name, $this->year, $this->fakultas, $this->prodi) +
                                        DataMoa::countNegara($item->name, $this->year, $this->fakultas, $this->prodi) +
                                        DataIa::countNegara($item->name, $this->year, $this->fakultas, $this->prodi);
            if ($cek <= 10) {
                $color = '#4d71a8';
            } elseif ($cek <= 50) {
                $color = '#324460';
            } elseif ($cek <= 1000) {
                $color = '#ea8d48';
            } elseif ($cek <= 10000) {
                $color = '#a93138';
            }
            
            if ($cek > 0) {
                // $this->data2[$item->code2]['link'] = 'https://lapkerma.unhas.ac.id';
                $this->data2[$item->code2]['link'] = '';
                $this->data2[$item->code2]['color'] = $color;
                $this->data2[$item->code2]['total'] = $cek;
            }
        }
        
        return view('livewire.dashboard-chart.map');
    }

    public function searchBy($year, $fakultas, $prodi)
    {
        $this->reRenderChart = true;
        $data2 = [];
        foreach ($this->refNegara as $key => $item)
        {
            $cek = DataMou::countNegara($item->name, $year, $fakultas, $prodi) +
                                        DataMoa::countNegara($item->name, $year, $fakultas, $prodi) +
                                        DataIa::countNegara($item->name, $year, $fakultas, $prodi);
            if ($cek <= 10) {
                $color = '#4d71a8';
            } elseif ($cek <= 50) {
                $color = '#324460';
            } elseif ($cek <= 300) {
                $color = '#ea8d48';
            } elseif ($cek <= 1000) {
                $color = '#a93138';
            }
            
            if ($cek > 0) {
                // $data2[$item->code2]['link'] = 'https://lapkerma.unhas.ac.id';
                $data2[$item->code2]['link'] = '';
                $data2[$item->code2]['color'] = $color;
                $data2[$item->code2]['total'] = $cek;
            }
        }
        $this->dispatchBrowserEvent('contentChanged2',  ['data2'=>$data2]);
    }
}
