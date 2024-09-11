<?php

namespace App\Http\Livewire\Datatables;

use Livewire\Component;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\StatusKerjasama;
use App\Models\JenisKerjasama;
use App\Models\DataIa;
use App\Models\DataIaBentukKegiatanKerjasama;
use App\Models\DataIaDokumen;
use App\Models\DataIaPenggiat;
use File;

use Livewire\WithPagination;
use Carbon\Carbon;
use App\Exports\DatatablesExport2;
use App\Models\NonProdiDataIa;
use App\Models\NonProdiDataIaBentukKegiatanKerjasama;
use App\Models\NonProdiDataIaDokumen;
use App\Models\NonProdiDataIaPenggiat;
use Illuminate\Support\Facades\Route;

class IaDatatables extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;

    public $getFakultas, $getProdi, $getPermohonan, $filess, $getStatus, $getJenis, $cariKerjasama;
    public $cariFakultas, $cariJudul, $cariProdi, $cariNegara, $cariMitra, $cariNamaProdi, $cariTingkat, $modeData;
    public $cariTahun, $cariNomorDokumen, $cariStatus, $dataExel, $sortData;
    public $cek, $showModalsEdit = false, $idDelete, $showModalsEdit2 = false ;

    protected $listeners = ['yakinHapus' => 'hapus',];

    protected $queryString = [
        'cariFakultas' => ['except' => '', 'as' => 'f'],
        'cariJudul' => ['except' => '', 'as' => 'j'],
        'cariTahun' => ['except' => '', 'as' => 't'],
        'cariNomorDokumen' => ['except' => '', 'as' => 'nd'],
        'cariStatus' => ['except' => '', 'as' => 'st'],
        'cariKerjasama' => ['except' => '', 'as' => 'ks'],
        'cariNamaProdi' => ['except' => '', 'as' => 'lv'],
        'cariNegara' => ['except' => '', 'as' => 'n'],
        'cariMitra' => ['except' => '', 'as' => 'm'],
        'page' => ['except' => 1],
    ];

    public function rezet()
    {
        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 99 ) {
            $this->reset(['cariFakultas','cariJudul','cariTahun','cariNomorDokumen','cariStatus','cariKerjasama','cariNamaProdi','cariNegara','cariMitra','cariTingkat']);
        } else {
            $this->reset(['cariJudul','cariTahun','cariNomorDokumen','cariStatus','cariKerjasama','cariNamaProdi','cariNegara','cariMitra','cariTingkat']);
        }
    }

    public function download()
    {
        return (new DatatablesExport2($this->dataExel))->download('DatatablesIA.xlsx');
    }

    public function mount()
    {
        $this->getJenis = JenisKerjasama::get();
        $this->getStatus = StatusKerjasama::get();
        $this->getFakultas = Fakultas::get();
        $this->getProdi = Prodi::get();

        if (Route::currentRouteName() == 'nonprodi-ia') {
            $this->modeData = true;
        } else {
            $this->modeData = false;
        }

        if (auth()->user()->role_id == 2) {
            $this->cariFakultas = auth()->user()->fakultas_id;
            $this->cariNamaProdi = auth()->user()->prodi->nama_resmi;
            $this->cariProdi = auth()->user()->prodi_id;
            $this->getProdi = Prodi::where('id_fakultas', auth()->user()->fakultas_id)->get();

        }elseif(auth()->user()->role_id == 4){
            $this->cariFakultas = auth()->user()->fakultas_id;
            $this->getProdi = Prodi::where('id_fakultas', auth()->user()->fakultas_id)->get();
        }else{
        $this->getProdi = Prodi::get();

        }
    }

    public function render()
    {
        $data = [];
        if ($this->modeData) {
            $this->dataExel = NonProdiDataIa::searchBy($this->cariTahun,$this->cariFakultas,$this->cariNomorDokumen,
                                                $this->cariJudul, $this->cariStatus, $this->cariKerjasama, $this->cariNamaProdi,
                                                $this->cariNegara, $this->cariMitra, $this->cariProdi,$this->cariTingkat,$this->sortData)->get();
        }else{
            $this->dataExel = DataIa::searchBy($this->cariTahun,$this->cariFakultas,$this->cariNomorDokumen,
                                                $this->cariJudul, $this->cariStatus, $this->cariKerjasama, $this->cariNamaProdi,
                                                $this->cariNegara, $this->cariMitra, $this->cariProdi,$this->cariTingkat,$this->sortData)->get();
        }
        if ($this->showModalsEdit == false) {
            if ($this->modeData) {
                $data = [
                    'DataIa' => NonProdiDataIa::searchBy($this->cariTahun,$this->cariFakultas,$this->cariNomorDokumen,
                                                    $this->cariJudul, $this->cariStatus, $this->cariKerjasama, $this->cariNamaProdi,
                                                    $this->cariNegara, $this->cariMitra,$this->cariProdi,$this->cariTingkat,$this->sortData)->paginate(10),
                    'getTahun' => NonProdiDataIa::select('tanggal_ttd')->orderBy('tanggal_ttd','asc')
                                        ->pluck('tanggal_ttd')->groupBy(function($val) {
                                        return Carbon::parse($val)->format('Y');
                            })
                ];
            } else {
                $data = [
                    'DataIa' => DataIa::searchBy($this->cariTahun,$this->cariFakultas,$this->cariNomorDokumen,
                                                    $this->cariJudul, $this->cariStatus, $this->cariKerjasama, $this->cariNamaProdi,
                                                    $this->cariNegara, $this->cariMitra,$this->cariProdi,$this->cariTingkat,$this->sortData)->paginate(10),
                    'getTahun' => DataIa::select('tanggal_ttd')->orderBy('tanggal_ttd','asc')
                                        ->pluck('tanggal_ttd')->groupBy(function($val) {
                                        return Carbon::parse($val)->format('Y');
                            })
                ];
            }
            
        }

        return view('livewire.datatables.ia-datatables', $data);
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

    public function updatedCariFakultas()
    {
        if (auth()->user()->role_id == 4){
            $this->cariFakultas = auth()->user()->fakultas_id;
            $this->getProdi = Prodi::where('id_fakultas', auth()->user()->fakultas_id)->get();
        }elseif (auth()->user()->role_id == 1) {
            $this->getProdi = Prodi::where('id_fakultas', $this->cariFakultas)->get();
        }
        $this->reset('cariNamaProdi');
    }

    public function updatedFiless()
    {
        $this->validate([
            'filess' => 'mimes:pdf|max:1500'
        ]);
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
        if ($this->modeData) {
            $find = NonProdiDataIa::find($this->idDelete);
            
    
                    $findMe = NonProdiDataIaBentukKegiatanKerjasama::where('id_ia', $find->id);
                    $findMeTo = NonProdiDataIaDokumen::where('kerjasama_id', $find->id);
                    $findMeLagi = NonProdiDataIaPenggiat::where('id_lapkerma', $find->id);
                    foreach ($findMeTo->get() as $key => $value) {
                        $gambar = $value->url;
                        File::delete('storage/DokumenIA/'.$gambar);
                    }
                    $findMe->delete();
                    $findMeTo->delete();
                    $findMeLagi->delete();
                    $find->delete();
                    $this->emit('alerts', ['pesan' => 'Data Berhasil Dihapus', 'icon'=>'success'] );
        }else{
            $find = DataIa::find($this->idDelete);
           
    
                    $findMe = DataIaBentukKegiatanKerjasama::where('id_ia', $find->id);
                    $findMeTo = DataIaDokumen::where('kerjasama_id', $find->id);
                    $findMeLagi = DataIaPenggiat::where('id_lapkerma', $find->id);
                    foreach ($findMeTo->get() as $key => $value) {
                        $gambar = $value->url;
                        File::delete('storage/DokumenIA/'.$gambar);
                    }
                    $findMe->delete();
                    $findMeTo->delete();
                    $findMeLagi->delete();
                    $find->delete();
                    $this->emit('alerts', ['pesan' => 'Data Berhasil Dihapus', 'icon'=>'success'] );
        }

        
    }
}
