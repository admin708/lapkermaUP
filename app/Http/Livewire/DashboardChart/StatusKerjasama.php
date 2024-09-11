<?php

namespace App\Http\Livewire\DashboardChart;

use Livewire\Component;
use App\models\{Lapkerma, DataMou, DataMoa, DataIa};

class StatusKerjasama extends Component
{
    public function render()
    {
        $aktif = DataMou::countStatus(1)+DataMoa::countStatus(1)+Dataia::countStatus(1);
        $perpanjangan = DataMou::countStatus(2)+DataMoa::countStatus(2)+Dataia::countStatus(2);
        $kadaluarsa = DataMou::countStatus(3)+DataMoa::countStatus(3)+Dataia::countStatus(3);
        $tidak_aktif = DataMou::countStatus(4)+DataMoa::countStatus(4)+Dataia::countStatus(4);
        $data= [
            'countStatus' =>json_encode(array(
                $aktif, $perpanjangan, $kadaluarsa, $tidak_aktif))
            ];
        // dd($this->countStatus);
        return view('livewire.dashboard-chart.status-kerjasama', $data);
    }
}
