<?php

namespace App\Http\Livewire\Input;

use App\Models\Negara;
use Livewire\Component;

class GuestMouInput extends Component
{
    public $negaras; // Store the countries here
    public $country_of_origin; // The selected country

    public function mount()
    {
        // Fetch all countries when the component is initialized
        $this->negaras = Negara::all(); 
    }

    public function render()
    {
        return view('livewire.input.guest-mou-input');
    }
}
