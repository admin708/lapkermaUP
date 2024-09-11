<?php

namespace App\Http\Livewire\Input;

use Livewire\Component;
use App\Models\DataIa;
use App\Models\DataMoa;
use App\Models\NonProdiDataIa;
use App\Models\NonProdiDataMoa;
use Livewire\WithFileUploads;
Use File;

class Laporan extends Component
{
    use WithFileUploads;

    public $val, $ids, $file, $lapor;

    public function mount($id, $val)
    {
        $this->val = $val;
        $this->ids = $id;
        if ($this->val == "MOA") {
            if (auth()->user()->role_id == 5) {
                $kerjasama = NonProdiDataMoa::find($this->ids);
            }else{
                $kerjasama = DataMoa::find($this->ids);
            }
        } elseif ($this->val == "IA") {
            if (auth()->user()->role_id == 5) {
                $kerjasama = NonProdiDataIa::find($this->ids);
            }else{
                $kerjasama = DataIa::find($this->ids);
            }
        }
        
        $this->lapor = $kerjasama->laporan;
        
    }

    public function render()
    {
        if ($this->val == "MOA") {
            if (auth()->user()->role_id == 5) {
                $kerjasama = NonProdiDataMoa::find($this->ids);
            }else{
                $kerjasama = DataMoa::find($this->ids);
            }
        } elseif ($this->val == "IA") {
            if (auth()->user()->role_id == 5) {
                $kerjasama = NonProdiDataIa::find($this->ids);
            }else{
                $kerjasama = DataIa::find($this->ids);
            }
        }
        
        $data = [
            'kerjasama' => $kerjasama,
            'lapor' =>$this->lapor
        ];
        return view('livewire.input.laporan', $data);
    }

    public function download()
    {
        $file_path = public_path('storage/FormatLaporan/format.docx');

        return response()->download($file_path, 'format-laporan-kerjasama.docx');
    }

    public function ubah()
    {
        $this->lapor = null;
    }

    public function uploadFile()
    {
        $this->validate([
            'file' => 'required|max:3072'
        ]);
        if ($this->val == 'MOA') {
            if (auth()->user()->role_id == 5) {
                $find = NonProdiDataMoa::find($this->ids);
            }else{
                $find = DataMoa::find($this->ids);
            }

        } elseif ($this->val == 'IA') {
            if (auth()->user()->role_id == 5) {
                $find = NonProdiDataIa::find($this->ids);
            }else{
                $find = DataIa::find($this->ids);
            }

        }
        if ($find->laporan) {
            File::delete('storage/Laporan/'.$this->val.'/'.$find->laporan);
        }
        
        $code = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random = substr(str_shuffle($code),0,3);
        $namaDokumen = 'Laporan'.$this->val.$random.'.'.$this->file->extension();
        $this->file->storeAs('public/Laporan/'.$this->val, $namaDokumen);
        $find->update([
            'laporan' => $namaDokumen
        ]);
        $this->lapor = $find->laporan;
        $this->emit('alerts', ['pesan' => 'Laporan Berhasil Ditambahkan', 'icon'=>'success'] );
    }
}
