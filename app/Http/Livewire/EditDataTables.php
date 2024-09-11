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
use App\Models\PenggiatKerjasama;
use App\Models\StatusKerjasama;
use App\Models\DokumenLapkerma;
use App\Models\ReferensiSumberDanaLapkerma;
use Illuminate\Database\QueryException as ERROR;
use DB;
use Hamcrest\Type\IsNumeric;
use phpDocumentor\Reflection\Types\This;

class EditDataTables extends Component
{
    use WithFileUploads;
    public $arrayProdi=[], $arrayNamaProdi = [], $showLoadFiles;
    public $ottPlatform, $files = [], $arrayJawaban = 1, $pin, $status = [], $inputs = [0,1,2,3,4,5,6,7,8];

    public $tanggal_ttd, $jenis_kerjasama, $negara, $region, $kegiatan_kerjasama, $tempat_pelaksanaan, $status_kerjasama;
    public $tanggal_awal, $tanggal_berakhir, $jangka_waktu, $jenis_dokumen_kerjasama, $dasar_dokumen_kerjasama; 
    public $nomor_unhas, $nomor_mitra, $judul_kerjasama, $deskripsi, $anggaran, $sumber_dana;

    public $nama_pihak = [], $fakultas_pihak = [], $alamat_pihak = [];
    public $nama_pejabat_pihak = [], $jabatan_pejabat_pihak = [], $pj_pihak = [], $jabatan_pj_pihak = []; 
    public $email_pj_pihak = [], $hp_pj_pihak = [];

    public $uuid, $stat1, $stat2, $stat3, $stat4, $stat5, $stat6, $stat7, $stat8, $data, $idEdit, $count, $hapus2= false;
    public $fakultas, $sumberDana, $prodiAll, $dasarDokKerjasama2, $dasarDokKerjasama1;

    public function mount($id)
    {
        $this->idEdit = $id;
        $this->fakultas = Fakultas::get();
        $this->sumberDana = ReferensiSumberDanaLapkerma::get();
        $this->jenisKerjasama = JenisKerjasama::get();
        $this->regionKerjasama = Region::get();
        $this->kegiatanKerjasama = KegiatanKerjasama::get();
        $this->statusKerjasama = StatusKerjasama::get();
        $this->jenisDokKerjasama = JenisDokumenKerjasama::get();
       
        if (auth()->user()->role_id == 1) {
            $this->dasarDokKerjasama1 = Lapkerma::where('jenis_dokumen',1)->get();
            $this->dasarDokKerjasama2 = Lapkerma::whereIn('jenis_dokumen',[1,2])->get();
            $this->prodiAll = Prodi::get();
          } else {
            $this->prodiAll = Prodi::where('id_fakultas',auth()->user()->fakultas_id)->get();
            $this->fakultas_pihak = [auth()->user()->fakultas_id];
            $this->arrayProdi = [[auth()->user()->prodi_id]];
            $this->dasarDokKerjasama1 = Lapkerma::where('jenis_dokumen',1)->where('fakultas_pihak',auth()->user()->fakultas_id)->get();
            $this->dasarDokKerjasama2 = Lapkerma::whereIn('jenis_dokumen',[1,2])->where('fakultas_pihak',auth()->user()->fakultas_id)->get();
          }

        $findMe = Lapkerma::find($this->idEdit);

        $this->uuid = $findMe->uuid;
        $this->tanggal_ttd = $findMe->tanggal_ttd;
        $this->jenis_kerjasama = $findMe->jenis_kerjasama; 
        $this->negara = $findMe->negara; 
        $this->region = $findMe->region; 
        $this->kegiatan_kerjasama = $findMe->jenis_kegiatan;
        $this->tempat_pelaksanaan = $findMe->tempat_pelaksanaan;
        $this->status_kerjasama = $findMe->status; 
        $this->tanggal_awal = $findMe->tanggal_awal; 
        $this->tanggal_berakhir = $findMe->tanggal_berakhir;
        $this->jangka_waktu = $findMe->jangka_waktu;
        $this->dasar_dokumen_kerjasama = $findMe->dasar_dokumen; 
        $this->jenis_dokumen_kerjasama = $findMe->jenis_dokumen;
        $this->nomor_unhas = $findMe->nomor_dok_unhas; 
        $this->nomor_mitra = $findMe->nomor_dok_mitra; 
        $this->judul_kerjasama = $findMe->judul; 
        $this->deskripsi = $findMe->deskripsi;
        $this->anggaran = $findMe->anggaran;
        $this->sumber_dana = $findMe->sumber_dana;

        if ($this->jenis_dokumen_kerjasama == 3) {
        $this->dasarDokKerjasama = $this->dasarDokKerjasama2;
        } else {
        $this->dasarDokKerjasama = $this->dasarDokKerjasama1;
        }

        $findMeTo = PenggiatKerjasama::where('id_lapkerma',$this->idEdit);
        $this->arrayJawaban = $findMeTo->count('id')-1;
        foreach ($findMeTo->get() as $key => $value) {
            $this->status[$key] = $value->status_pihak;
            $this->fakultas_pihak[$key] = $value->fakultas_pihak;
            $this->nama_pihak[$key] = $value->nama_pihak; 
            $this->alamat_pihak[$key] = $value->alamat_pihak ;
            $this->nama_pejabat_pihak[$key] = $value->nama_pejabat_pihak ; 
            $this->jabatan_pejabat_pihak[$key] = $value->jabatan_pejabat_pihak ;
            $this->pj_pihak[$key] = $value->pj_pihak ;
            $this->jabatan_pj_pihak[$key] = $value->jabatan_pj_pihak ; 
            $this->email_pj_pihak[$key] = $value->email_pj_pihak ; 
            $this->hp_pj_pihak[$key] = $value->hp_pj_pihak ;
            $this->arrayProdi[$key] = json_decode($value->prodi);
        }
    }

    public function render()
    {
        $data = [
        'getDokumen' => DokumenLapkerma::where('kerjasama_id',$this->idEdit)->get()
        ];
        return view('livewire.edit-data-tables', $data);
    }

  public function backTo()
  {
    return redirect()->route('menu','InputDataTables');
  }

    public function takeArray()
    {
        if ($this->arrayJawaban < 8) {
            $this->arrayJawaban++;

        }
    }

    public function minArrayPihak()
    {
      // dd($this->arrayJawaban);
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

    public function takeSuccess()
    {
      $this->showLoadFiles = true;
    }

    public function hapusdokumen($id)
    {
     $this->hapus2 = $id;
    }

    public function deletedokumen($id)
    {
      $getData = DokumenLapkerma::find($id);
      $cek = DokumenLapkerma::where('kerjasama_id',$getData->kerjasama_id)->count('id');
      if ($cek == 1) {
        $this->emit('alerts', ['pesan' => 'Dokumen Gagal dihapus', 'icon'=>'error'] );
      } else {
        $getData->delete();
        $this->emit('alerts', ['pesan' => 'Dokumen Berhasil dihapus', 'icon'=>'success'] );
      }
      
      $this->hapus2 = false;

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
        'deskripsi'=> 'required',
      ]);

      $this->status[0] = 1;
      if ($this->jenis_kerjasama == 1) {
        $this->negara = 'Indonesia';
        $this->region = 1;
      }
      
    //   if ($this->jenis_dokumen_kerjasama != 1) {
    //     $getProdiPihak1 = json_encode($this->arrayProdi[0]);
    //     $getNamaProdi = Prodi::whereIn('id',$this->arrayProdi[0])->get();
    //     foreach ($getNamaProdi as $key => $valuez) {
    //       array_push($this->arrayNamaProdi, $valuez->nama_resmi);
    //     }
    //   }
    $getProdiPihak1 = null;
      if ($this->jenis_dokumen_kerjasama != 1) {
        $getProdiPihak1 = json_encode($this->arrayProdi[0]);
        $getNamaProdi = Prodi::whereIn('id',$this->arrayProdi[0])->get();
        foreach ($getNamaProdi as $key => $valuez) {
          array_push($this->arrayNamaProdi, $valuez->nama_resmi);
        }
      }else{
        $this->arrayNamaProdi = null;
      }
      
      $find = Lapkerma::find($this->idEdit);
          DB::beginTransaction();
          try {
            $find->update([
              'tanggal_ttd' => $this->tanggal_ttd,
              'jenis_kerjasama' => $this->jenis_kerjasama,
              'negara' => $this->negara,
              'region' => $this->region,
              'jenis_kegiatan' => $this->kegiatan_kerjasama,
              'tempat_pelaksanaan' => $this->tempat_pelaksanaan,
              'status' => $this->status_kerjasama,
              'tanggal_awal' => $this->tanggal_awal,
              'tanggal_berakhir' => $this->tanggal_berakhir,
              'jangka_waktu' => $this->jangka_waktu,
              'dasar_dokumen' => $this->dasar_dokumen_kerjasama,
              'jenis_dokumen' => $this->jenis_dokumen_kerjasama,
              'nomor_dok_unhas' => $this->nomor_unhas,
              'nomor_dok_mitra' => $this->nomor_mitra,
              'judul' => $this->judul_kerjasama,
              'fakultas_pihak' => $this->fakultas_pihak[0],
              'deskripsi' => $this->deskripsi,
              'anggaran' => $this->anggaran,
              'sumber_dana' => $this->sumber_dana,
              'nama_pihak' => $this->nama_pihak[0],
              'alamat_pihak' => $this->alamat_pihak[0],
              'nama_pejabat_pihak' => $this->nama_pejabat_pihak[0],
              'jabatan_pejabat_pihak' => $this->jabatan_pejabat_pihak[0],
              'pj_pihak' => $this->pj_pihak[0],
              'jabatan_pj_pihak' => $this->jabatan_pj_pihak[0],
              'email_pj_pihak' => $this->email_pj_pihak[0],
              'hp_pj_pihak' => $this->hp_pj_pihak[0],
              'prodi' => $getProdiPihak1,
              'nama_prodi' => json_encode($this->arrayNamaProdi),
              'uploaded_by' => auth()->user()->id,
            ]);

           
          if ($this->files) {
            foreach ($this->files as $file) {
              $code = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
              $random = substr(str_shuffle($code),0,3);
              $namaDokumen = 'dokumen'.$this->uuid.$random.'.'.$file->extension();
              $file->storeAs('public/DokumenLapkerma',$namaDokumen);

              DokumenLapkerma::create([
                  'url' => $namaDokumen,
                  'kerjasama_id' => $this->idEdit,
              ]);
            }
          }
            $findMeTo = PenggiatKerjasama::where('id_lapkerma',$this->idEdit)->delete();

              foreach (range(0,$this->arrayJawaban) as $key => $value) {
                      $storePenggiatKerjasama = PenggiatKerjasama::create([
                      'id_lapkerma' => $this->idEdit, 'pihak' => $value+1, 'status_pihak' => $this->status[$key],
                      'nama_pihak' => $this->nama_pihak[$key]??'', 'fakultas_pihak' => $this->fakultas_pihak[$key]??'', 'alamat_pihak' => $this->alamat_pihak[$key]??'',
                      'nama_pejabat_pihak' => $this->nama_pejabat_pihak[$key], 'jabatan_pejabat_pihak' => $this->jabatan_pejabat_pihak[$key], 'pj_pihak' => $this->pj_pihak[$key],
                      'jabatan_pj_pihak' => $this->jabatan_pj_pihak[$key], 'email_pj_pihak' => $this->email_pj_pihak[$key], 'hp_pj_pihak' => $this->hp_pj_pihak[$key],
                      'prodi' => json_encode($this->arrayProdi[$key])??'', 'uploaded_by' => auth()->user()->id,
                    ]);
              }

            DB::commit();
            $this->dispatchBrowserEvent('bersih');
            $this->reset('files');
            $this->emit('alerts', ['pesan' => 'Data Berhasil Diubah', 'icon'=>'success'] );
        } catch (ERROR $th) {
          dd($th);
            DB::rollback();
        $this->idEdit = $id;
        $this->idEdit = $id;
            $this->emit('alert', ['pesan' => 'Invalid Proses, Gagal Ditambahkan', 'icon'=>'error'] );
        }
      }
    
}

//after emit multiple select2
// $this->emit('productStore');