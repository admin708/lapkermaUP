<?php

namespace App\Http\Livewire\Datatables;

use Livewire\Component;
use App\Models\Fakultas;
use App\Models\StatusKerjasama;
use App\Models\JenisKerjasama;
use App\Models\DataMou;
use App\Models\DataMouBentukKegiatanKerjasama;
use App\Models\DataMouDokumen;
use App\Models\DataMouPenggiat;
use App\Models\DataMoa;
use App\Models\DataIa;
use Livewire\WithPagination;
use Carbon\Carbon;
use App\Exports\DatatablesExport3;
use File;

class MouDatatables extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;

    public $getFakultas, $getProdi, $getPermohonan, $filess, $getStatus, $getJenis, $cariKerjasama;
    public $cariPenggiat, $cariJudul, $cariNegara, $cariFakultas, $cariProdi, $dataExel;
    public $cariTahun, $cariNomorDokumen, $cariStatus, $cariUniv = 1000;
    public $cek, $showModalsEdit = false, $idDelete, $showModalsEdit2 = false ;
    public $goEdit, $sortData;
    protected $listeners = ['yakinHapus' => 'hapus',];

    protected $queryString = [
        'cariPenggiat' => ['except' => '', 'as' => 'f'],
        'cariJudul' => ['except' => '', 'as' => 'j'],
        'cariTahun' => ['except' => '', 'as' => 't'],
        'cariNomorDokumen' => ['except' => '', 'as' => 'nd'],
        'cariStatus' => ['except' => '', 'as' => 'st'],
        'cariKerjasama' => ['except' => '', 'as' => 'ks'],
        'cariNegara' => ['except' => '', 'as' => 'lv'],
        'page' => ['except' => 1],
    ];

    public function rezet()
    {
        // if (auth()->user()->role_id == 1 || auth()->user()->role_id == 99) {
        //     $this->reset(['cariPenggiat','cariJudul','cariTahun','cariNomorDokumen','cariStatus','cariKerjasama','cariNegara']);
        // } else {
            $this->reset(['cariPenggiat','cariJudul','cariTahun','cariNomorDokumen','cariStatus','cariKerjasama','cariNegara']);
        // }
    }
    public function download()
    {
        return (new DatatablesExport3($this->dataExel))->download('DatatablesMoU.xlsx');
    }
    public function mount()
    {
        $this->getJenis = JenisKerjasama::get();
        $this->getStatus = StatusKerjasama::get();
        // $this->getFakultas = Fakultas::get();
        if (auth()->user()->role_id == 2) {
            $this->cariFakultas = auth()->user()->fakultas_id;
            $this->cariProdi = auth()->user()->prodi_id;
        }
    }
    public function emitEdit()
    {
        $this->emit('updateData',$this->cek);
    }
    public function render()
    {
        $data = [];
        $this->dataExel = DataMou::searchBy($this->cariTahun,$this->cariPenggiat,$this->cariNomorDokumen,
                                            $this->cariJudul, $this->cariStatus, $this->cariKerjasama, $this->cariNegara,
                                            $this->cariFakultas, $this->cariProdi, $this->cariUniv,$this->sortData)->get();
        if ($this->showModalsEdit == false) {
            $data = [
                'DataMou' => DataMou::searchBy($this->cariTahun,$this->cariPenggiat,$this->cariNomorDokumen,
                                                $this->cariJudul, $this->cariStatus, $this->cariKerjasama, $this->cariNegara,
                                                $this->cariFakultas, $this->cariProdi, $this->cariUniv,$this->sortData)->paginate(10),
                'getTahun' => DataMou::select('tanggal_ttd')->orderBy('tanggal_ttd','asc')
                                    ->pluck('tanggal_ttd')->groupBy(function($val) {
                                    return Carbon::parse($val)->format('Y');
                        })
            ];
        }

        return view('livewire.datatables.mou-datatables', $data);
    }

    // public function updatedcariPenggiat()
    // {
    //     $this->resetPage();
    //     if ($this->cariPenggiat == 'all') {
    //         $this->cariPenggiat = null;
    //     } else {
    //     }
    // }

    public function toInput($id)
    {
        if (auth()->user()->role_id == 5) {
            return redirect()->route('nonprodi-moa-in', $id);
        } else {
            return redirect()->route('moa-in', $id);
        }
        
    }

    public function updatedFiless()
    {
        $this->validate([
            'filess' => 'mimes:pdf|max:1500'
        ]);
    }

    public function getEdit($id)
    {
        $this->showModalsEdit = true;
        $this->cek = $id;
        $this->emit('getEditData',$id);
    }

    public function getEdit2($id)
    {
        $this->showModalsEdit2 = true;
        $this->cek = $id;
        $this->emit('getEditData2',$id);
    }

    public function closeEdit()
    {
        $this->showModalsEdit = false;
        $this->showModalsEdit2 = false;
    }

    public function updatedCariNomorDokumen()
    {
        $this->resetPage();
    }

    public function updatedCariStatus()
    {
        $this->resetPage();
    }

    public function updatedCariJudul()
    {
        $this->resetPage();
    }

    public function updatedCariTahun()
    {
        $this->resetPage();
    }

    public function updatedCariNegara()
    {
        $this->resetPage();
    }

    public function updatedCariPenggiat()
    {
        $this->resetPage();    
    }

    public function updateMe()
    {
        $this->showModalsEdit = false;
        $this->goEdit = false;
        $this->emit('updateInovasi');
    }

    public function delete($id)
    {
        $this->idDelete = $id;
        $this->emit('delete');
    }

    public function hapus()
    {
        $find = DataMou::find($this->idDelete);
        $cek = DataMoa::where('dasar_dokumen',$find->uuid)->count('uuid');
        $cek2 = DataIa::where('dasar_dokumen',$find->uuid)->count('uuid');
        if ($cek != 0) {
            $this->emit('alerts', ['pesan' => 'Data terkait dengan data lainnya', 'icon'=>'error'] );
        } else {
            if ($cek2 != 0) {
                $this->emit('alerts', ['pesan' => 'Data terkait dengan data lainnya', 'icon'=>'error'] );
            } else {
                $findMe = DataMouBentukKegiatanKerjasama::where('id_mou', $find->id);
                $findMeTo = DataMouDokumen::where('kerjasama_id', $find->id);
                $findMeLagi = DataMouPenggiat::where('id_lapkerma', $find->id);
                foreach ($findMeTo->get() as $key => $value) {
                    $gambar = $value->url;
                    File::delete('storage/DokumenMoU/'.$gambar);
                }
                $findMe->delete();
                $findMeTo->delete();
                $findMeLagi->delete();
                $find->delete();
                $this->emit('alerts', ['pesan' => 'Data Berhasil Dihapus', 'icon'=>'success'] );
            }
        }
    }
}
