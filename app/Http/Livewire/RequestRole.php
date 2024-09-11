<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\User;
class RequestRole extends Component
{
    public $listFakultas, $listProdi, $fakultas, $prodi;
    public function mount()
    {
        $this->listFakultas = Fakultas::get();
    }
    public function render()
    {
        return view('livewire.request-role');
    }
    public function updatedFakultas()
    {
        $this->listProdi = Prodi::where('id_fakultas', $this->fakultas)->get();
    }
    public function request()
    {
        if($this->fakultas != null){
            $up = User::find(auth()->user()->id);
            if ($up) {
                if ($this->fakultas == 0) {
                    $up->update([
                        'request' => 1,
                        'fakultas_id' => $this->fakultas,
                        'prodi_id' => 0,
                    ]);
                $this->emit('alert', ['pesan' => 'Request Berhasil Dikirim', 'icon'=>'success'] );
                } else {
                    $up->update([
                        'request' => 1,
                        'fakultas_id' => $this->fakultas,
                        'prodi_id' => $this->prodi,
                    ]);
                $this->emit('alert', ['pesan' => 'Request Berhasil Dikirim', 'icon'=>'success'] );
                }
            } else {
                $this->emit('alert', ['pesan' => 'Request Gagal Dikirim, Pilih Unit Kerja Terlebih Dahulu', 'icon'=>'error'] );
            }

        }

        $this->emit('repage', ['pesan' => 'Reload dulu daeng', 'icon'=>'success'] );
    }

}
