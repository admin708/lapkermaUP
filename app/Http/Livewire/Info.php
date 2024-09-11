<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Info extends Component
{
    public function render()
    {
        $infouser = \App\Models\User::where('request',1)->whereNotNull('fakultas_id')->whereNotNull('prodi_id')->whereNull('role_id')->count('id');
        return view('livewire.info', ['infouser' => $infouser]);
    }
}
