<?php

namespace App\Http\Livewire\Datatables;

use App\Models\DataIa;
use Livewire\Component;
use App\Models\DataIaPenggiat;

class IkuScores extends Component
{
    public $DataIa;
    
    public function render()
    {
        $this->DataIa=$this->getDataIa();

        dd($this->DataIa[0]);


        return view('livewire.datatables.iku-scores',[
            'DataIa' => $this->DataIa,
        ]);


    }

    public function getDataIa(){
        $data = DataIaPenggiat::getDataWithJoin('sarjana');

        return $data;
    }


}
