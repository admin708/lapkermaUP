<?php

namespace App\Http\Livewire;
use App\Models\User;
use App\Models\Fakultas;

use Livewire\Component;

class ManagemenUser extends Component
{
    public $pin;
    public $idU;
    public $role;
    public $set;
    public $example;

    protected $listeners = ['postAdded' => 'setset'];

    public function setset()
    {
        if ($this->example) {
            $setset = User::find(1);
            $setset->update(['request' => 1]);
        } else {
            $setset = User::find(1);
            $setset->update(['request' => null]);
        }
        
    }

    public function set()
    {
        if ($this->example == null) {
            $this->example = 1;
        } else {
            $this->example = null;
        }
    }

    public function render()
    {
        $user = User::where('request', 1)->whereNull('role_id')->get();
        $userTable = User::get();
        $fakultasTable = Fakultas::get();
        $setset = User::where('id',1)->get();
        $this->example = $setset[0]->request;
        $data = [
            'user'=>$user, 'userTable' => $userTable, 'fakultasTable' => $fakultasTable
        ];
        return view('livewire.managemen-user', $data);
    }

    public function konf($idU)
    {
        // dd($idU);
        $this->idU = $idU;
    }

    public function del($idU)
    {
        $this->idU = $idU;
    }

    public function konf2()
    {
        $upup = User::find($this->idU);
        
        if ($upup) {
           $upup->update([
               'role_id' => $this->role
           ]);
            $this->emit('alert', ['pesan' => 'Data Berhasil Dikonfirmasi', 'icon'=>'success'] );
            $this->role = null;
        } else {
            # code...
        }

    }

    public function del2()
    {
        $upup = User::find($this->idU);
        if ($upup) {
            $upup->delete();
             $this->emit('alert', ['pesan' => 'Data Berhasil Dikonfirmasi', 'icon'=>'success'] );
         } else {
                $this->emit('alert', ['pesan' => 'Data Tidak Dapat dihapus', 'icon'=>'error'] );
         }
    }
}
