<?php

namespace App\Http\Livewire\Sdgs;

use App\Models\Sdgs;
use Livewire\Component;

class Index extends Component
{
    public $nama, $show;

    public function render()
    {
        $data = [
            'dataSdgs' => Sdgs::get()
        ];
        return view('livewire.sdgs.index', $data);
    }

    public function simpan()
    {
        $create = Sdgs::firstOrCreate([
            'nama' => $this->nama
        ]);

        if ($create->wasRecentlyCreated)
        {
            $this->reset();
            $this->emit('alerts', ['pesan' => 'Data Berhasil Ditambahkan', 'icon'=>'success'] );
        }else{
            $this->reset('show');
            $this->emit('alerts', ['pesan' => 'Data Duplikat', 'icon'=>'error'] );
        }
    }
}
