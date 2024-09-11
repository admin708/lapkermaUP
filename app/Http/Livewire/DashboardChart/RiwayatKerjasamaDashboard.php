<?php

namespace App\Http\Livewire\DashboardChart;

use Livewire\Component;
use App\Models\{Lapkerma, DataMou, DataMoa, DataIa};
use Carbon\Carbon;

class RiwayatKerjasamaDashboard extends Component
{
    public $searchYear, $data;
    public $reRenderChart = false;

    protected $listeners = ['searchBy' => 'searchBy',];


    public function mount()
    {
        // $this->searchYear = Carbon::now()->format('Y');
        $this->data= [
            'countMOUByJenisPerMonth' =>json_encode(array(
                DataMou::countBy(1, $this->searchYear),
                DataMou::countBy(2, $this->searchYear),
                DataMou::countBy(3, $this->searchYear),
                DataMou::countBy(4, $this->searchYear),
                DataMou::countBy(5, $this->searchYear),
                DataMou::countBy(6, $this->searchYear),
                DataMou::countBy(7, $this->searchYear),
                DataMou::countBy(8, $this->searchYear),
                DataMou::countBy(9, $this->searchYear),
                DataMou::countBy(10, $this->searchYear),
                DataMou::countBy(11, $this->searchYear),
                DataMou::countBy(12, $this->searchYear))),

            'countMOAByJenisPerMonth' =>json_encode(array(
                DataMoa::countBy(1, $this->searchYear),
                DataMoa::countBy(2, $this->searchYear),
                DataMoa::countBy(3, $this->searchYear),
                DataMoa::countBy(4, $this->searchYear),
                DataMoa::countBy(5, $this->searchYear),
                DataMoa::countBy(6, $this->searchYear),
                DataMoa::countBy(7, $this->searchYear),
                DataMoa::countBy(8, $this->searchYear),
                DataMoa::countBy(9, $this->searchYear),
                DataMoa::countBy(10, $this->searchYear),
                DataMoa::countBy(11, $this->searchYear),
                DataMoa::countBy(12, $this->searchYear))),

            'countIAByJenisPerMonth' =>json_encode(array(
                DataIa::countBy(1, $this->searchYear),
                DataIa::countBy(2, $this->searchYear),
                DataIa::countBy(3, $this->searchYear),
                DataIa::countBy(4, $this->searchYear),
                DataIa::countBy(5, $this->searchYear),
                DataIa::countBy(6, $this->searchYear),
                DataIa::countBy(7, $this->searchYear),
                DataIa::countBy(8, $this->searchYear),
                DataIa::countBy(9, $this->searchYear),
                DataIa::countBy(10, $this->searchYear),
                DataIa::countBy(11, $this->searchYear),
                DataIa::countBy(12, $this->searchYear))),
            ];
    }

    public function render()
    {
        return view('livewire.dashboard-chart.riwayat-kerjasama-dashboard',$this->data);
    }

    public function searchBy($year, $fakultas, $prodi)
    {
        $this->reRenderChart = true;

        $countMOUByJenisPerMonth = json_encode(array(
            DataMou::countBy(1, $year, $fakultas),
            DataMou::countBy(2, $year, $fakultas),
            DataMou::countBy(3, $year, $fakultas),
            DataMou::countBy(4, $year, $fakultas),
            DataMou::countBy(5, $year, $fakultas),
            DataMou::countBy(6, $year, $fakultas),
            DataMou::countBy(7, $year, $fakultas),
            DataMou::countBy(8, $year, $fakultas),
            DataMou::countBy(9, $year, $fakultas),
            DataMou::countBy(10, $year, $fakultas),
            DataMou::countBy(11, $year, $fakultas),
            DataMou::countBy(12, $year, $fakultas)));

        $countMOAByJenisPerMonth = json_encode(array(
            DataMoa::countBy(1, $year, $fakultas, $prodi),
            DataMoa::countBy(2, $year, $fakultas, $prodi),
            DataMoa::countBy(3, $year, $fakultas, $prodi),
            DataMoa::countBy(4, $year, $fakultas, $prodi),
            DataMoa::countBy(5, $year, $fakultas, $prodi),
            DataMoa::countBy(6, $year, $fakultas, $prodi),
            DataMoa::countBy(7, $year, $fakultas, $prodi),
            DataMoa::countBy(8, $year, $fakultas, $prodi),
            DataMoa::countBy(9, $year, $fakultas, $prodi),
            DataMoa::countBy(10, $year, $fakultas, $prodi),
            DataMoa::countBy(11, $year, $fakultas, $prodi),
            DataMoa::countBy(12, $year, $fakultas, $prodi)));

        $countIAByJenisPerMonth = json_encode(array(
            DataIa::countBy(1, $year, $fakultas, $prodi),
            DataIa::countBy(2, $year, $fakultas, $prodi),
            DataIa::countBy(3, $year, $fakultas, $prodi),
            DataIa::countBy(4, $year, $fakultas, $prodi),
            DataIa::countBy(5, $year, $fakultas, $prodi),
            DataIa::countBy(6, $year, $fakultas, $prodi),
            DataIa::countBy(7, $year, $fakultas, $prodi),
            DataIa::countBy(8, $year, $fakultas, $prodi),
            DataIa::countBy(9, $year, $fakultas, $prodi),
            DataIa::countBy(10, $year, $fakultas, $prodi),
            DataIa::countBy(11, $year, $fakultas, $prodi),
            DataIa::countBy(12, $year, $fakultas, $prodi)));

       $this->dispatchBrowserEvent('contentChanged',  ['mou'=> $countMOUByJenisPerMonth,
                                                        'moa' => $countMOAByJenisPerMonth,
                                                        'ia' => $countIAByJenisPerMonth]);
    }
}
