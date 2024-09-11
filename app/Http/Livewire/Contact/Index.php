<?php

namespace App\Http\Livewire\Contact;

use App\Models\ContactInfo;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['sendValueCreat'=>'sendValueCreat', 'hapusKontak' => 'hapusKontak'];

    public function render()
    {
        $data = [
            'getContact' => ContactInfo::orderBy('orders', 'asc')->get()
        ];
        return view('livewire.contact.index', $data);
    }

    public function sendValueCreat($val)
    {
        $createContact = ContactInfo::firstOrCreate([
            'no_hp' => $val[1]
        ],[
            'nama' => $val[0],
            'status' => 1
        ]);

        if ($createContact->wasRecentlyCreated)
        {
            $this->emit('alerts', ['pesan' => 'Data Berhasil Ditambahkan', 'icon'=>'success'] );
        }else{
            $this->emit('alerts', ['pesan' => 'Data Duplikat', 'icon'=>'error'] );
        }
    }

    public function updateTaskOrder($value)
    {
        foreach ($value as $item) {
            ContactInfo::where('id',$item['value'])->update(['orders' => $item['order']]);
        }
    }

    public function hapusKontak($val)
    {
       $del = ContactInfo::find($val);
       if ($del) {
            $del->delete();
            $this->emit('alerts', ['pesan' => 'Data Berhasil Dihapus', 'icon'=>'success']);
        }else{
            $this->emit('alerts', ['pesan' => 'Data Gagal Dihapus', 'icon'=>'error']);
        }
    }
}
