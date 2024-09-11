<?php

namespace App\Http\Livewire\Datatables;

use App\Exports\DatatablesExport;
use Livewire\Component;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\StatusKerjasama;
use App\Models\JenisKerjasama;
use App\Models\DataMou;
use App\Models\DataMoa;
use App\Models\DataIa;
use App\Models\DataMoaBentukKegiatanKerjasama;
use App\Models\DataMoaDokumen;
use App\Models\DataMoaPenggiat;
use App\Models\NonProdiDataIa;
use App\Models\NonProdiDataMoa;
use App\Models\NonProdiDataMoaBentukKegiatanKerjasama;
use App\Models\NonProdiDataMoaDokumen;
use App\Models\NonProdiDataMoaPenggiat;
use File;
use Illuminate\Support\Facades\Route;

use Livewire\WithPagination;
use Carbon\Carbon;

class MoaDatatables extends Component
{
    protected $paginationTheme = 'bootstrap';
    use WithPagination;

    public $getFakultas, $getProdi, $getPermohonan, $filess, $getStatus, $getJenis, $cariKerjasama;
    public $cariFakultas, $cariJudul, $cariProdi, $cariNegara, $cariMitra, $cariNamaProdi, $cariTingkat;
    public $cariTahun, $cariNomorDokumen, $cariStatus, $modeData, $sortData;
    public $cek, $showModalsEdit = false, $idDelete, $showModalsEdit2 = false, $dataExel ;

    protected $listeners = ['yakinHapus' => 'hapus',];

    protected $queryString = [
        'page' => ['except' => 1],
        'cariFakultas' => ['except' => '', 'as' => 'f'],
        'cariJudul' => ['except' => '', 'as' => 'j'],
        'cariTahun' => ['except' => '', 'as' => 't'],
        'cariNomorDokumen' => ['except' => '', 'as' => 'nd'],
        'cariStatus' => ['except' => '', 'as' => 'st'],
        'cariKerjasama' => ['except' => '', 'as' => 'ks'],
        'cariProdi' => ['except' => '', 'as' => 'lv'],
        'cariNamaProdi' => ['except' => '', 'as' => 'np'],
        'cariNegara' => ['except' => '', 'as' => 'n'],
        'cariMitra' => ['except' => '', 'as' => 'm'],
    ];

    public function rezet()
    {
        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 99 ) {
            $this->reset(['cariFakultas','cariJudul','cariTahun','cariNomorDokumen','cariStatus','cariKerjasama','cariProdi',
                            'cariNegara','cariMitra','cariNamaProdi','cariTingkat']);
        } else {
            $this->reset(['cariJudul','cariTahun','cariNomorDokumen','cariStatus','cariKerjasama','cariNamaProdi','cariNegara','cariMitra','cariTingkat']);
        }
    }

    public function toInput($id)
    {
        $val = 3;
        if ($this->modeData) {
            return redirect()->route('nonprodi-moa-in', [$id, $val]);

        } else {
            return redirect()->route('moa-in', [$id, $val]);
        }
        
    }

    public function download()
    {
        return (new DatatablesExport($this->dataExel))->download('DatatablesMoA.xlsx');
    }

    public function mount()
    {
        $this->getJenis = JenisKerjasama::get();
        $this->getStatus = StatusKerjasama::get();
        $this->getFakultas = Fakultas::get();
        
        if (Route::currentRouteName() == 'nonprodi-moa') {
            $this->modeData = true;
        } else {
            $this->modeData = false;
        }
        
        if (auth()->user()->role_id == 2) {
            $this->cariFakultas = auth()->user()->fakultas_id;
            $this->cariProdi = auth()->user()->prodi_id;
            $this->cariNamaProdi = auth()->user()->prodi->nama_resmi;
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
            $this->dataExel = NonProdiDataMoa::searchBy($this->cariTahun,$this->cariFakultas,$this->cariNomorDokumen,
                                                $this->cariJudul, $this->cariStatus, $this->cariKerjasama, $this->cariNamaProdi,
                                                $this->cariNegara, $this->cariMitra, $this->cariProdi,$this->cariTingkat,$this->sortData)->get();
        }else{
            $this->dataExel = DataMoa::searchBy($this->cariTahun,$this->cariFakultas,$this->cariNomorDokumen,
                                                $this->cariJudul, $this->cariStatus, $this->cariKerjasama, $this->cariNamaProdi,
                                                $this->cariNegara, $this->cariMitra, $this->cariProdi,$this->cariTingkat,$this->sortData)->get();
        }
        
        if ($this->showModalsEdit == false) {
            if ($this->modeData) {
                $data = [
                    'DataMoa' => NonProdiDataMoa::searchBy($this->cariTahun,$this->cariFakultas,$this->cariNomorDokumen,
                                                    $this->cariJudul, $this->cariStatus, $this->cariKerjasama, $this->cariNamaProdi,
                                                    $this->cariNegara, $this->cariMitra,$this->cariProdi,$this->cariTingkat,$this->sortData)->paginate(10),
                    'getTahun' => NonProdiDataMoa::select('tanggal_ttd')
                                        ->orderBy('id','asc')
                                        ->pluck('tanggal_ttd')->groupBy(function($val) {
                                        return Carbon::parse($val)->format('Y');
                            })
                ];
            } else {
                $data = [
                    'DataMoa' => DataMoa::searchBy($this->cariTahun,$this->cariFakultas,$this->cariNomorDokumen,
                                                    $this->cariJudul, $this->cariStatus, $this->cariKerjasama, $this->cariNamaProdi,
                                                    $this->cariNegara, $this->cariMitra,$this->cariProdi,$this->cariTingkat,$this->sortData)->paginate(10),
                    'getTahun' => DataMoa::select('tanggal_ttd')
                                        ->orderBy('tanggal_ttd','asc')
                                        ->pluck('tanggal_ttd')->groupBy(function($val) {
                                        return Carbon::parse($val)->format('Y');
                            })
                ];
            }

        }

        return view('livewire.datatables.moa-datatables', $data);
    }

    public function updatedCariFakultas()
    {
        // $this->resetPage();
        // if ($this->cariFakultas == 'all') {
        //     $this->cariFakultas = null;
        // } else {
        // }

        if (auth()->user()->role_id == 4){
            $this->cariFakultas = auth()->user()->fakultas_id;
            $this->getProdi = Prodi::where('id_fakultas', auth()->user()->fakultas_id)->get();
        }elseif (auth()->user()->role_id == 1) {
            $this->getProdi = Prodi::where('id_fakultas', $this->cariFakultas)->get();
        }
        $this->reset('cariNamaProdi');
    }

    public function updatedCariPenggiat()
    {
        $this->resetPage();    
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
            $find = NonProdiDataMoa::find($this->idDelete);
            $cek = NonProdiDataIa::where('dasar_dokumen',$find->uuid)->count('id');
            if ($cek != 0) {
                $this->emit('alerts', ['pesan' => 'Data terkait dengan data lainnya', 'icon'=>'error'] );
            } else {
    
                    $findMe = NonProdiDataMoaBentukKegiatanKerjasama::where('id_moa', $find->id);
                    $findMeTo = NonProdiDataMoaDokumen::where('kerjasama_id', $find->id);
                    $findMeLagi = NonProdiDataMoaPenggiat::where('id_lapkerma', $find->id);
                    foreach ($findMeTo->get() as $key => $value) {
                        $gambar = $value->url;
                        File::delete('storage/DokumenMoA/'.$gambar);
                    }
                    $findMe->delete();
                    $findMeTo->delete();
                    $findMeLagi->delete();
                    $find->delete();
                    $this->emit('alerts', ['pesan' => 'Data Berhasil Dihapus', 'icon'=>'success'] );
            }
        }else{
            $find = DataMoa::find($this->idDelete);
            $cek = DataIa::where('dasar_dokumen',$find->uuid)->count('id');
            if ($cek != 0) {
                $this->emit('alerts', ['pesan' => 'Data terkait dengan data lainnya', 'icon'=>'error'] );
            } else {
    
                    $findMe = DataMoaBentukKegiatanKerjasama::where('id_moa', $find->id);
                    $findMeTo = DatamoaDokumen::where('kerjasama_id', $find->id);
                    $findMeLagi = DataMoaPenggiat::where('id_lapkerma', $find->id);
                    foreach ($findMeTo->get() as $key => $value) {
                        $gambar = $value->url;
                        File::delete('storage/DokumenMoA/'.$gambar);
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
