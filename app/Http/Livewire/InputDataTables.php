<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\JenisDokumenKerjasama;
use App\Models\JenisKerjasama;
use App\Models\Lapkerma;
use App\Models\Region;
use App\Models\Prodi;
use App\Models\Fakultas;
use App\Models\KegiatanKerjasama;
use App\Models\ReferensiSumberDanaLapkerma;
use App\Models\PenggiatKerjasama;
use App\Models\StatusKerjasama;
use Illuminate\Database\QueryException as ERROR;
use DB;
use Hamcrest\Type\IsNumeric;
use phpDocumentor\Reflection\Types\This;

class InputDataTables extends Component
{
    use WithFileUploads;
    public $arrayProdi=[], $arrayNamaProdi = [], $name = [], $showLoadFiles = false;
    public $ottPlatform, $files = [], $arrayJawaban = 1, $pin, $status = [1], $inputs = [0,1,2,3,4,5,6,7,8];

    public $tanggal_ttd, $jenis_kerjasama, $negara, $region, $kegiatan_kerjasama, $tempat_pelaksanaan, $status_kerjasama;
    public $tanggal_awal, $tanggal_berakhir, $jangka_waktu, $jenis_dokumen_kerjasama, $dasar_dokumen_kerjasama; 
    public $nomor_unhas, $nomor_mitra, $judul_kerjasama, $deskripsi, $anggaran, $sumber_dana;

    public $nama_pihak = ['Universitas Hasanuddin'], $fakultas_pihak = [], $alamat_pihak = [];
    public $nama_pejabat_pihak = [], $jabatan_pejabat_pihak = [], $pj_pihak = [], $jabatan_pj_pihak = []; 
    public $email_pj_pihak = [], $hp_pj_pihak = [];
    public $jenisKerjasama, $regionKerjasama, $kegiatanKerjasama, $statusKerjasama;
    public $stat1, $stat2, $stat3, $stat4, $stat5, $stat6, $stat7, $stat8, $fakultas, $prodiAll, $dasarDokKerjasama, $sumberDana;
    
    protected $listeners = ['successMe' => 'takeSuccess',
                            'errorMe' => 'takeError'
                            ];

    public function mount()
    {
        
        $this->fakultas = Fakultas::get();
        $this->sumberDana = ReferensiSumberDanaLapkerma::get();
        $this->jenisKerjasama = JenisKerjasama::get();
        $this->regionKerjasama = Region::get();
        $this->kegiatanKerjasama = KegiatanKerjasama::get();
        $this->statusKerjasama = StatusKerjasama::get();
        $this->jenisDokKerjasama = JenisDokumenKerjasama::get();

        if (auth()->user()->role_id == 1) {
          $this->dasarDokKerjasama = Lapkerma::where('jenis_dokumen',1)->get();
          $this->dasarDokKerjasama2 = Lapkerma::whereIn('jenis_dokumen',[1,2])->get();
          $this->prodiAll = Prodi::get();
        } else {
          $this->prodiAll = Prodi::where('id_fakultas',auth()->user()->fakultas_id)->get();
          $this->fakultas_pihak = [auth()->user()->fakultas_id];
          $this->arrayProdi = [[auth()->user()->prodi_id]];
          $this->dasarDokKerjasama = Lapkerma::where('jenis_dokumen',1)->where('fakultas_pihak',auth()->user()->fakultas_id)->get();
          $this->dasarDokKerjasama2 = Lapkerma::whereIn('jenis_dokumen',[1,2])->where('fakultas_pihak',auth()->user()->fakultas_id)->get();
        }
    }

    public function render()
    {
      return view('livewire.input-data-tables');
    }

    public function takeArray()
    {
        if ($this->arrayJawaban < 8) {
            $this->arrayJawaban++;
        }
    }

    public function takeSuccess()
    {
      $this->showLoadFiles = true;
    }
    
    public function takeError()
    {
      $this->reset('files');
    }

    public function updatedFiles()
    {
      $this->validate([
        'files.*' => 'mimetypes:application/pdf|max:1024'
    ]);
    }

    public function minArrayPihak()
    {
      if ($this->arrayJawaban > 1) {
        foreach (range(2,$this->arrayJawaban) as $key => $value) {
          if ($value == $this->arrayJawaban) {
            $this->dispatchBrowserEvent('clearselect'.$value);
            $this->status[$value] = null;
            $this->nama_pihak[$value] = null;
            $this->fakultas_pihak[$value] = null;
            $this->alamat_pihak[$value] = null;
            $this->nama_pejabat_pihak[$value] = null;
            $this->jabatan_pejabat_pihak[$value] = null;
            $this->pj_pihak[$value] = null;
            $this->jabatan_pj_pihak[$value] = null; 
            $this->email_pj_pihak[$value] = null;
            $this->hp_pj_pihak[$value] = null;
            $this->arrayProdi[$value] = null;
          }
        }
        $this->arrayJawaban--;
      }
    }

    public function error1()
    {
        $this->files = null;
        $this->resetErrorBag();
    }

    public function updatedStatus()
    {
      foreach (range(0,$this->arrayJawaban) as $key => $value) {
          if (isset($this->status[$key])) {
            if ($this->status[$key] == 3) {
              $this->dispatchBrowserEvent('disableSelect'.$value);
              $this->fakultas_pihak[$value] = null;
              $this->arrayProdi[$value] = null;
            }else{
              $this->dispatchBrowserEvent('enableSelect'.$value);
            }
          }
      }
    }

    public function create()
    {
      $this->validate([
        'tanggal_ttd'=> 'required', 'jenis_kerjasama'=> 'required', 'kegiatan_kerjasama'=> 'required',
        'tempat_pelaksanaan'=> 'required', 'status_kerjasama'=> 'required', 'tanggal_awal'=> 'required',
        'tanggal_berakhir'=> 'required', 'jangka_waktu'=> 'required', 'jenis_dokumen_kerjasama'=> 'required',
        'nomor_unhas'=> 'required', 'nomor_mitra'=> 'required', 'judul_kerjasama'=> 'required',
        'deskripsi'=> 'required', 'files' => 'max:1000', 
      ]);

      // memberi inputan default pihak1 
      $this->status[0] = 1; $alamatPihak1 = $this->alamat_pihak[0];
      $namaPihak1 = $this->nama_pihak[0]; $namaPejabat1 = $this->nama_pejabat_pihak[0];
      $jabatanPejabat1 = $this->jabatan_pejabat_pihak[0]??null; $pj1 = $this->pj_pihak[0];
      $jabatanPj1 = $this->jabatan_pj_pihak[0]??null; $emailPj1 = $this->email_pj_pihak[0]??null;
      $hpPj1 = $this->hp_pj_pihak[0]??null;
      
      if ($this->jenis_kerjasama == 1) {
        $this->negara = 'Indonesia';
        $this->region = 1;
      }

      // memberi inputan default pihak1 dengan jenis kerjasama selain MoU
      if ($this->jenis_dokumen_kerjasama != 1) {
        $getProdiPihak1 = json_encode($this->arrayProdi[0]);
        $getNamaProdi = Prodi::whereIn('id',$this->arrayProdi[0])->get();
        foreach ($getNamaProdi as $key => $valuez) {
          array_push($this->arrayNamaProdi, $valuez->nama_resmi);
        }
      }else{
        $this->arrayNamaProdi = null;
      }

      // membuat kode sistem dokumen
      $uuid = Lapkerma::max('id');
      $uuid = str_pad($uuid+1, 3, '0', STR_PAD_LEFT);
      $uuid = date('y').$uuid;

      $find = Lapkerma::where('uuid',$uuid)->count('id');
      
      if ($find) {
        $this->emit('alert', ['pesan' => 'Data Duplikat', 'icon'=>'error'] );
      }else{
          if ($this->files) {
            DB::beginTransaction();
            try {
              $store = Lapkerma::firstOrCreate([
                'uuid' => $uuid,
              ],[
                'tanggal_ttd' => $this->tanggal_ttd, 'jenis_kerjasama' => $this->jenis_kerjasama,
                'negara' => $this->negara, 'region' => $this->region,
                'jenis_kegiatan' => $this->kegiatan_kerjasama, 'tempat_pelaksanaan' => $this->tempat_pelaksanaan,
                'status' => $this->status_kerjasama, 'tanggal_awal' => $this->tanggal_awal,
                'tanggal_berakhir' => $this->tanggal_berakhir, 'jangka_waktu' => $this->jangka_waktu,
                'dasar_dokumen' => $this->dasar_dokumen_kerjasama, 'jenis_dokumen' => $this->jenis_dokumen_kerjasama,
                'nomor_dok_unhas' => $this->nomor_unhas, 'nomor_dok_mitra' => $this->nomor_mitra,
                'judul' => $this->judul_kerjasama, 'fakultas_pihak' => $this->fakultas_pihak[0],
                'deskripsi' => $this->deskripsi, 'anggaran' => $this->anggaran, 'sumber_dana' => $this->sumber_dana,
                'nama_pihak' => $namaPihak1, 'alamat_pihak' => $alamatPihak1,
                'nama_pejabat_pihak' => $namaPejabat1, 'jabatan_pejabat_pihak' => $jabatanPejabat1,
                'pj_pihak' => $pj1, 'jabatan_pj_pihak' => $jabatanPj1,
                'email_pj_pihak' => $emailPj1, 'hp_pj_pihak' => $hpPj1,
                'prodi' => $getProdiPihak1??null, 'nama_prodi' => $this->arrayNamaProdi == true ? json_encode($this->arrayNamaProdi):null,
                'uploaded_by' => auth()->user()->id,
              ]);
              foreach ($this->files as $file) {
                $code = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $random = substr(str_shuffle($code),0,3);
                $namaDokumen = 'dokumen'.$uuid.$random.'.'.$file->extension();
                $file->storeAs('public/DokumenLapkerma',$namaDokumen);
                $store->dokumenKerjasama()->create([
                    'url' => $namaDokumen,
                    'kerjasama_id' => $store->id
                ]);
              }
              if ($this->jenis_dokumen_kerjasama != 1) {
                foreach (range(0,$this->arrayJawaban) as $key => $value) {
                  $storePenggiatKerjasama = PenggiatKerjasama::create([
                    'id_lapkerma' => $store->id, 'pihak' => $value+1, 'status_pihak' => $this->status[$key],
                    'nama_pihak' => $this->nama_pihak[$key], 'fakultas_pihak' => $this->fakultas_pihak[$key]??'', 'alamat_pihak' => $this->alamat_pihak[$key],
                    'nama_pejabat_pihak' => $this->nama_pejabat_pihak[$key], 'jabatan_pejabat_pihak' => $this->jabatan_pejabat_pihak[$key]??'', 'pj_pihak' => $this->pj_pihak[$key],
                    'jabatan_pj_pihak' => $this->jabatan_pj_pihak[$key]??'', 'email_pj_pihak' => $this->email_pj_pihak[$key]??'', 'hp_pj_pihak' => $this->hp_pj_pihak[$key]??'',
                    'prodi' => $this->arrayProdi == true ? json_encode($this->arrayProdi[$key]):null, 'uploaded_by' => auth()->user()->id,
                  ]);
                }
              }else{
                foreach (range(0,$this->arrayJawaban) as $key => $value) {
                  $storePenggiatKerjasama = PenggiatKerjasama::create([
                    'id_lapkerma' => $store->id, 'pihak' => $value+1, 'status_pihak' => $this->status[$key],
                    'nama_pihak' => $this->nama_pihak[$key], 'fakultas_pihak' => $this->fakultas_pihak[$key]??'', 'alamat_pihak' => $this->alamat_pihak[$key],
                    'nama_pejabat_pihak' => $this->nama_pejabat_pihak[$key], 'jabatan_pejabat_pihak' => $this->jabatan_pejabat_pihak[$key]??'', 'pj_pihak' => $this->pj_pihak[$key],
                    'jabatan_pj_pihak' => $this->jabatan_pj_pihak[$key]??'', 'email_pj_pihak' => $this->email_pj_pihak[$key]??'', 'hp_pj_pihak' => $this->hp_pj_pihak[$key]??'',
                    'uploaded_by' => auth()->user()->id,
                  ]);
                }
              }
              DB::commit();
              $this->dispatchBrowserEvent('bersih');
              $this->emit('alerts', ['pesan' => 'Data Berhasil Ditambahkan', 'icon'=>'success'] );

            } catch (ERROR $th) {
              dd($th);
                DB::rollback();
                $this->emit('alert', ['pesan' => 'Invalid Proses, Gagal Ditambahkan', 'icon'=>'error'] );
            }
          }else{
            if (empty($file)) {
              $this->emit('alert', ['pesan' => 'Tidak Ada File Pendukung, Data Gagal Ditambahkan', 'icon'=>'error'] );
            } else {
              $this->emit('alert', ['pesan' => 'Harap Periksa Data Anda, Gagal Ditambahkan', 'icon'=>'error'] );
            }
          }
      }
    }
}
