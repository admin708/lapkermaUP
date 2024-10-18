<?php

namespace App\Http\Livewire\Datatables;

use App\Models\DataIaPenggiat;
use Livewire\Component;
use Livewire\WithPagination;

class IkuScores extends Component
{
    use WithPagination; 

    protected $paginationTheme = 'bootstrap'; 

    // Change this property to protected or private
    protected $DataIa;

    public function render()
    {
        $this->DataIa = $this->getDataIa(); 
        return view('livewire.datatables.iku-scores', [
            'DataIa' => $this->DataIa, // Pass the data to the view
        ]);
    }

    public function getDataIa()
    {
        
        return DataIaPenggiat::getDataWithJoin('sarjana')->paginate(10);
    }

    
    public function getDataIaProperty()
    {
        return $this->DataIa;
    }
}
