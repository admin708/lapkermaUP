<?php

namespace App\Http\Livewire\Edit;

use Livewire\Component;
use App\Models\DataMoaDokumen;
use App\Models\NonProdiDataIaDokumen;
use App\Models\DataMoaPenggiat;
use App\Models\NonProdiDataIaPenggiat;
use App\Models\DataMoaBentukKegiatanKerjasama;
use App\Models\NonProdiDataIaBentukKegiatanKerjasama;
use App\Models\DataMoa;
use App\Models\NonProdiDataIa;
use App\Models\DataMou;
use Livewire\WithFileUploads;
use App\Models\JenisDokumenKerjasama;
use App\Models\JenisKerjasama;
use App\Models\LapkermaRefBentukKegiatan;
use App\Models\LapkermaRefSasaranKegiatan;
use App\Models\LapkermaRefIndikatorKinerja;
use App\Models\Lapkerma;
use App\Models\Region;
use App\Models\Negara;
use App\Models\Prodi;
use App\Models\Intansi;
use App\Models\Fakultas;
use App\Models\KegiatanKerjasama;
use App\Models\ReferensiSumberDanaLapkerma;
use App\Models\PenggiatKerjasama;
use App\Models\StatusKerjasama;
use Illuminate\Database\QueryException as ERROR;use App\Models\ProdiMitra;
use App\Models\FakultasPihak;
use App\Models\NonProdiDataMoa;
use App\Models\NonProdiDataMoaBentukKegiatanKerjasama;
use App\Models\NonProdiDataMoaDokumen;
use App\Models\NonProdiDataMoaPenggiat;
use App\Models\Sdgs;
use DB;
use Illuminate\Support\Str;

class Nonprodi extends Component
{
    use WithFileUploads;
    public $lockInstansi = [], $lockFakultas =[], $arrayMitra =[], $nama_fakultas = [], $searchProdiMitra = [], $prodiPihak = [];
    public $bentukKegiatan, $renderSwitch , $badanKemitraan = [], $lainnya = [], $ptqs = [], $idEdit, $findDokumen;
    public $arrayProdi=[], $arrayNamaProdi = [], $name = [], $showLoadFiles = false, $jenisKerjasamaField, $loadingSave = false;
    public $ottPlatform, $files = [], $arrayJawaban = 1, $pin, $status = [], $inputs = [0,1,2,3,4,5,6,7,8];
    public $arrayBentukKegiatan = [], $arraySasaran = [], $arrayKinerja = [], $arraySdgs = [], $keterangan, $volume_luaran, $volume_satuan, $nilai_kontrak;

    public $tanggal_ttd, $jenis_kerjasama, $tingkat, $negara, $region, $kegiatan_kerjasama, $tempat_pelaksanaan, $status_kerjasama;
    public $tanggal_awal, $tanggal_berakhir, $jangka_waktu, $jenis_dokumen_kerjasama, $dasar_dokumen_kerjasama;
    public $nomor_unhas, $nomor_mitra, $judul_kerjasama, $deskripsi, $anggaran, $sumber_dana;

    public $nama_pihak = [], $fakultas_pihak = [], $alamat_pihak = [], $valz, $upBy, $editBy;
    public $nama_pejabat_pihak = [], $jabatan_pejabat_pihak = [], $pj_pihak = [], $jabatan_pj_pihak = [];
    public $email_pj_pihak = [], $hp_pj_pihak = [];
    public $jenisKerjasama, $regionKerjasama, $kegiatanKerjasama, $statusKerjasama;
    public $negaraKerjasama, $stat1, $stat2, $stat3, $stat4, $stat5, $stat6, $stat7, $stat8, $fakultas, $prodiAll, $dasarDokKerjasama, $sumberDana;
    public $prodiEx, $prodiExNama, $getIndikatorKinerja, $getSasaranKegiatan, $jenisDokKerjasama, $dasarDokKerjasama2;
    public $uuid;
    public $getBentukKegiatan, $getSdgs, $sdgs;

    protected $listeners = ['successMe' => 'takeSuccess',
                            'errorMe' => 'takeError',
                            'getEditData' => 'showEditData',
                            'addProdiMitra' => 'addProdiMitra',
                            'addInstansi' => 'addInstansi',
                            'addFakultasMitra' => 'addFakultasMitra'
                            ];

    public function mount($id,$val)
    {
        $this->valz = $val;
        $this->negaraKerjasama = Negara::get();
        $this->fakultas = Fakultas::get();
        $this->getBentukKegiatan = LapkermaRefBentukKegiatan::get();
        $this->getIndikatorKinerja = LapkermaRefIndikatorKinerja::get();
        $this->getSasaranKegiatan = LapkermaRefSasaranKegiatan::get();
        $this->sumberDana = ReferensiSumberDanaLapkerma::get();
        $this->jenisKerjasama = JenisKerjasama::get();
        $this->regionKerjasama = Region::get();
        $this->kegiatanKerjasama = KegiatanKerjasama::get();
        $this->statusKerjasama = StatusKerjasama::get();
        $this->jenisDokKerjasama = JenisDokumenKerjasama::get();
        $this->getSdgs = Sdgs::get();

        $this->jenisKerjasamaField = 1;
        $this->updatedJenisKerjasamaField();
        if ($val == 'MoA') {
            $this->findDokumen = NonProdiDataMoaDokumen::where('kerjasama_id',$id)->get();
            $findMe = NonProdiDataMoa::find($id);
            $findMeTo = NonProdiDataMoaPenggiat::where('id_lapkerma',$id);
            $findKegiatan = NonProdiDataMoaBentukKegiatanKerjasama::where('id_moa',$id)->get();
            $this->jenis_dokumen_kerjasama = 2;
        } else {
            $this->findDokumen = NonProdiDataIaDokumen::where('kerjasama_id',$id)->get();
            $findMe = NonProdiDataIa::find($id);
            $findMeTo = NonProdiDataIaPenggiat::where('id_lapkerma',$id);
            $findKegiatan = NonProdiDataIaBentukKegiatanKerjasama::where('id_ia',$id)->get();
            $this->jenis_dokumen_kerjasama = 3;
        }
// dd(auth()->user());
        if (auth()->user()->role_id == 1) {
            $this->dasarDokKerjasama = DataMou::get();
            $this->dasarDokKerjasama2 = NonProdiDataMoa::get();
            $this->prodiAll = Prodi::get();
        } else {
            $this->prodiAll = Prodi::where('id_fakultas',auth()->user()->fakultas_id)->get();
            $this->fakultas_pihak = [auth()->user()->fakultas_id];
            // $this->arrayProdi = [[auth()->user()->prodi_id]];
            $this->dasarDokKerjasama = DataMou::whereIn('fakultas_pihak',[auth()->user()->fakultas_id,1000])->orderBy('id', 'desc')->get();
            $this->dasarDokKerjasama2 = NonProdiDataMoa::where('fakultas_pihak',auth()->user()->fakultas_id)->orderBy('id', 'desc')->get();
        }

        $this->idEdit = $id;
        $this->uuid = $findMe->uuid;
        $this->tanggal_ttd = $findMe->tanggal_ttd;
        $this->jenisKerjasamaField = $findMe->jenis_kerjasama;
        $this->negara = $findMe->negara;
        $this->region = $findMe->region;
        $this->tempat_pelaksanaan = $findMe->tempat_pelaksanaan;
        $this->status_kerjasama = $findMe->status;
        $this->anggaran = $findMe->anggaran;
        $this->dasar_dokumen_kerjasama = $findMe->dasar_dokumen;
        $this->sumber_dana = $findMe->sumber_dana;
        $this->tanggal_awal = $findMe->tanggal_awal;
        $this->tanggal_berakhir = $findMe->tanggal_berakhir;
        $this->jangka_waktu = $findMe->jangka_waktu;
        $this->nomor_unhas = $findMe->nomor_dok_unhas;
        $this->nomor_mitra = $findMe->nomor_dok_mitra;
        $this->judul_kerjasama = $findMe->judul;
        $this->deskripsi = $findMe->deskripsi;
        $this->prodiEx = $findMe->prodi_id;
        $this->tingkat = $findMe->tingkat;
        if ($findMe->sdgs) {
            foreach (json_decode($findMe->sdgs) as $key => $value) {
                array_push($this->arraySdgs ,$value);
            }
        }
        
// dd($this->arraySdgs);
        $getnamaprodi = Prodi::find($this->prodiEx);
        // dd($findMe->prodi_id);
        $this->prodiExNama = $getnamaprodi->nama_resmi;

        $this->upBy = $findMe->uploaded_by.' - '.$findMe->created_at;
        if ($findMe->edited_by) {
            $this->editBy = $findMe->edited_by.' - '.$findMe->updated_at;
        };

        $this->arrayJawaban = $findMeTo->count('id');
        $this->inputs = [];

        foreach ($findMeTo->get() as $key => $value) {
            array_push($this->inputs ,$key);
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
            $this->ptqs[$key] = $value->ptqs ;
            $this->arrayProdi[$key] = json_decode($value->prodi);
            $this->lockFakultas[$key] = 1;
            $this->lockInstansi[$key] = 1;
            if ($value->nama_pihak == $findMe->nama_pihak) {
                // $this->arrayNamaProdi[$key] = json_decode($findMe->nama_prodi);
                $this->arrayNamaProdi[$key] = [$findMe->nama_prodi];
            }else{
                $this->arrayNamaProdi[$key] = [];
            }

            if ($value->status_pihak == 3) {
                if (is_numeric($value->badan_kemitraan)){
                    $this->badanKemitraan[$key] = $value->badan_kemitraan ;
                }else{
                    $this->badanKemitraan[$key] = 99 ;
                    $this->lainnya[$key] = $value->badan_kemitraan ;
                }
            }else{
                $this->pushNamaInstansiStart($key,$value->id,$value->nama_pihak,$value->status_pihak,$value->fakultas_pihak, json_decode($value->prodi));
            }

        }

        $this->arrayBentukKegiatan = [];
        foreach ($findKegiatan as $key => $value) {
            array_push($this->arrayBentukKegiatan ,$value->id_ref_bentuk_kegiatan);
            $this->nilai_kontrak[$key] = $value->nilai_kontrak;
            $this->volume_satuan[$key] = $value->volume_satuan;
            $this->volume_luaran[$key] = $value->volume_luaran;
            $this->keterangan[$key] = $value->keterangan;
            $this->arrayKinerja[$key] = $value->id_ref_indikator_kinerja;
            $this->arraySasaran[$key] = $value->id_ref_sasaran_kegiatan;
            // $this->arraySdgs[$key] = $value->id_sdgs;
        }


    }

    public function addProdiMitra($value)
    {
        $create = ProdiMitra::firstOrCreate([
            'nama_resmi' => $value
        ]);
        if ($create->wasRecentlyCreated)
        {
        $this->emit('alerts', ['pesan' => 'Berhasil ditambahkan', 'icon'=>'success'] );
        }else{
        $this->emit('alerts', ['pesan' => 'Data Duplikat', 'icon'=>'error'] );
        };
    }

    public function addFakultasMitra($value)
    {
        $create = FakultasPihak::firstOrCreate([
            'nama_fakultas' => $value
        ]);
        if ($create->wasRecentlyCreated)
        {
        $this->emit('alerts', ['pesan' => 'Berhasil ditambahkan', 'icon'=>'success'] );
        }else{
        $this->emit('alerts', ['pesan' => 'Data Duplikat', 'icon'=>'error'] );
        };
    }

    public function addInstansi($value,$status)
    {
        $create = Intansi::firstOrCreate([
            'nama_instansi' => $value
        ],[
            'status' => $status
        ]);
        if ($create->wasRecentlyCreated)
        {
        $this->emit('alerts', ['pesan' => 'Berhasil ditambahkan', 'icon'=>'success'] );
        }else{
        $this->emit('alerts', ['pesan' => 'Data Duplikat', 'icon'=>'error'] );
        };
    }

    public function unsetFakultas($key, $id)
    {
        $results=array_search($id,$this->prodiPihak[$key],true);
        if($results !== false) {
            unset($this->prodiPihak[$key][$results]);
        }
    }

    public function pushNamaInstansi($key,$id,$nama,$status)
    {
        $this->nama_pihak[$key] = $nama;
        $this->arrayMitra[$key] = $id;
        $this->lockInstansi[$key] = 1;
        $this->status[$key] = $status;
        if ($id == 1) {
           $this->fakultas_pihak[$key] = auth()->user()->fakultas_id;
           $this->prodiPihak[$key] = [auth()->user()->prodi_id];
           $this->arrayNamaProdi[$key] = [auth()->user()->prodi->nama_resmi];
        }
    }

    public function clearLockInstansi($key)
    {
        $this->nama_pihak[$key] = null;
        $this->arrayMitra[$key] = null;
        $this->lockInstansi[$key] = null;
        $this->status[$key] = null;
    }

    public function clearLockFakultas($key)
    {
        $this->nama_fakultas[$key] = null;
        $this->fakultas_pihak[$key] = null;
        $this->lockFakultas[$key] = null;
    }

    public function pushProdiMitra($key,$id,$nama)
    {
        if (isset($this->prodiPihak[$key])) {
            $results=array_search($id,$this->prodiPihak[$key],true);
            if($results !== false) {
                unset($this->prodiPihak[$key][$results]);

            }else{
                array_push($this->prodiPihak[$key],$id);
                array_push($this->arrayNamaProdi[$key],$nama);
            }
            $this->reset('searchProdiMitra');
        }else{
            $this->prodiPihak[$key] = [];
            $this->arrayNamaProdi[$key] = [];
            array_push($this->arrayNamaProdi[$key],$nama);
            array_push($this->prodiPihak[$key],$id);
            $this->reset('searchProdiMitra');
        }
    }

    public function pushNamaInstansiStart($key,$id,$nama,$status,$idFk,$arrPro)
    {
        $this->fakultas_pihak[$key] = $idFk;
        $this->prodiPihak[$key] = $arrPro;
        $get = FakultasPihak::find($idFk);
        $this->nama_fakultas[$key] = $get->nama_fakultas;
    }

    public function pushNamaFakultas($key,$id,$nama)
    {
        $this->nama_fakultas[$key] = $nama;
        $this->fakultas_pihak[$key] = $id;
        $this->lockFakultas[$key] = 1;
    }

    public function render()
    {

        $this->getProdiMitras = ProdiMitra::get();
        $this->getFakultasMitras = FakultasPihak::get();
            return view('livewire.edit.nonprodi');
    }

    public function updatedJenisKerjasamaField()
    {
        if ($this->jenisKerjasamaField == 1) {
            $this->region = 1;
            $this->negara = 'Indonesia';
        } else {
            $this->reset('region','negara');
        }
    }
    public function updatedSdgs()
    {
        if ($this->sdgs != 0) {
            array_push($this->arraySdgs, $this->sdgs);
        }
        $this->reset('sdgs');
    }
    public function minArraySdgs($i)
    {
        unset($this->arraySdgs[$i]);
    }
    public function updatedNegara()
    {
        $this->dispatchBrowserEvent('contentChanged');
    }

    public function updatedBentukKegiatan()
    {
        if ($this->bentukKegiatan != 0) {
            array_push($this->arrayBentukKegiatan, $this->bentukKegiatan);
        }
        $this->reset('bentukKegiatan');
    }

    public function takeArray($add)
    {
        array_push($this->inputs, $add);
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

    public function minArrayPihak($key)
    {
        unset($this->inputs[$key]);
        unset($this->status[$key]);
        unset($this->nama_pihak[$key]);
        unset($this->fakultas_pihak[$key]);
        unset($this->alamat_pihak[$key]);
        unset($this->nama_pejabat_pihak[$key]);
        unset($this->jabatan_pejabat_pihak[$key]);
        unset($this->pj_pihak[$key]);
        unset($this->jabatan_pj_pihak[$key]);
        unset($this->email_pj_pihak[$key]);
        unset($this->hp_pj_pihak[$key]);
        unset($this->prodiPihak[$key]);
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

    public function validateFilter()
    {
        if ($this->jenisKerjasamaField == 2) {

            $this->validate([
                'region' => 'required',
                'negara' => 'required',
                'tempat_pelaksanaan' => 'required',
                'nomor_unhas' => 'required',
                'judul_kerjasama' => 'required',
                'deskripsi' => 'required',
                'tanggal_ttd' => 'required',
                'tanggal_awal' => 'required',
                'tanggal_berakhir' => 'required',
                'status_kerjasama' => 'required',
                'jangka_waktu' => 'required',
            ]);
        }else {
            $this->validate([
                'tempat_pelaksanaan' => 'required',
                'nomor_unhas' => 'required',
                'nomor_mitra' => 'required',
                'judul_kerjasama' => 'required',
                'deskripsi' => 'required',
                'tanggal_ttd' => 'required',
                'tanggal_awal' => 'required',
                'tanggal_berakhir' => 'required',
                'status_kerjasama' => 'required',
                'jangka_waktu' => 'required',
            ]);
        }

        foreach ($this->inputs as $key => $value) {
            $this->validate([
                'status.'.$value => 'required',
            ]);
            if ($this->status[$value] == 1) {
                $this->validate([
                    'nama_pihak.'.$value => 'required',
                    'ptqs.'.$value => 'required',
                    'fakultas_pihak.'.$value => 'required',
                    'arrayProdi.'.$value => 'required',
                    'alamat_pihak.'.$value => 'required',
                    'nama_pejabat_pihak.'.$value => 'required',
                    // 'pj_pihak.'.$value => 'required',
                    // 'email_pj_pihak.'.$value => 'email',
                    // 'hp_pj_pihak.'.$value => 'required',
                ]);
            }
            if ($this->status[$value] == 4) {
                $this->validate([
                    'nama_pihak.'.$value => 'required',
                    'ptqs.'.$value => 'required',
                    'fakultas_pihak.'.$value => 'required',
                    'arrayProdi.'.$value => 'required',
                    'alamat_pihak.'.$value => 'required',
                    'nama_pejabat_pihak.'.$value => 'required',
                    // 'pj_pihak.'.$value => 'required',
                    // 'email_pj_pihak.'.$value => 'email',
                    // 'hp_pj_pihak.'.$value => 'required',
                ]);
            }
            if ($this->status[$value] == 2) {
                $this->validate([
                    'nama_pihak.'.$value => 'required',
                    'fakultas_pihak.'.$value => 'required',
                    'arrayProdi.'.$value => 'required',
                    'alamat_pihak.'.$value => 'required',
                    'nama_pejabat_pihak.'.$value => 'required',
                    // 'pj_pihak.'.$value => 'required',
                    // 'email_pj_pihak.'.$value => 'email',
                    // 'hp_pj_pihak.'.$value => 'required',
                ]);
            }
            if ($this->status[$value] == 3) {
                  $this->validate([
                          'nama_pihak.'.$value => 'required',
                          'badanKemitraan.'.$value => 'required',
                  ]);

                  if ($this->badanKemitraan[$value] == 99) {
                      $this->validate([
                          'lainnya.'.$value => 'required',
                          'nama_pihak.'.$value => 'required',
                          'badanKemitraan.'.$value => 'required',
                          'alamat_pihak.'.$value => 'required',
                          'nama_pejabat_pihak.'.$value => 'required',
                        //   'pj_pihak.'.$value => 'required',
                        //   'email_pj_pihak.'.$value => 'email',
                        //   'hp_pj_pihak.'.$value => 'required',
                      ]);
                  }else{
                      $this->validate([
                          'nama_pihak.'.$value => 'required',
                          'badanKemitraan.'.$value => 'required',
                          'alamat_pihak.'.$value => 'required',
                          'nama_pejabat_pihak.'.$value => 'required',
                        //   'pj_pihak.'.$value => 'required',
                        //   'email_pj_pihak.'.$value => 'email',
                        //   'hp_pj_pihak.'.$value => 'required',
                      ]);
                  }
            }
        }

        $this->validate([
            'arrayBentukKegiatan' => 'required',
        ]);

        // validate bentuk kegiatan
        foreach ($this->arrayBentukKegiatan as $key => $value) {
            $this->validate([
                'arrayKinerja.'.$key => 'required',
                'arraySasaran.'.$key => 'required',
                // 'arraySdgs.'.$key => 'required',
            ]);
        }
    }

    public function validasiSave()
    {
        if ($this->jenisKerjasamaField == 2) {
            $this->validate([
                  'region' => 'required',
                  'negara' => 'required',
                  'tempat_pelaksanaan' => 'required',
                  'nomor_unhas' => 'required',
                  'judul_kerjasama' => 'required',
                  'deskripsi' => 'required',
                  'tanggal_ttd' => 'required',
                  'tanggal_awal' => 'required',
                  'tanggal_berakhir' => 'required',
                  'status_kerjasama' => 'required',
                  'jangka_waktu' => 'required',
            ]);
        }else {
            $this->validate([
                  'tingkat' => 'required',
                  'tempat_pelaksanaan' => 'required',
                  'nomor_unhas' => 'required',
                  'nomor_mitra' => 'required',
                  'judul_kerjasama' => 'required',
                  'deskripsi' => 'required',
                  'tanggal_ttd' => 'required',
                  'tanggal_awal' => 'required',
                  'tanggal_berakhir' => 'required',
                  'status_kerjasama' => 'required',
                  'jangka_waktu' => 'required',
            ]);
        }
        // validate penggiat kerjasama
        foreach ($this->inputs as $key => $value) {

            $this->validate([
                'nama_pihak.'.$key => 'required',
            ]);

            if ($this->status[$value] == 3) {
                  $this->validate([
                          'badanKemitraan.'.$value => 'required',
                  ]);

                  if ($this->badanKemitraan[$value] == 99) {
                      $this->validate([
                          'lainnya.'.$value => 'required',
                          'badanKemitraan.'.$value => 'required',
                          'alamat_pihak.'.$value => 'required',
                          'nama_pejabat_pihak.'.$value => 'required',
                        //   'pj_pihak.'.$value => 'required',
                        //   'email_pj_pihak.'.$value => 'required',
                        //   'hp_pj_pihak.'.$value => 'required',
                      ]);
                  }else{
                      $this->validate([
                          'badanKemitraan.'.$value => 'required',
                          'alamat_pihak.'.$value => 'required',
                          'nama_pejabat_pihak.'.$value => 'required',
                        //   'pj_pihak.'.$value => 'required',
                        //   'email_pj_pihak.'.$value => 'required',
                        //   'hp_pj_pihak.'.$value => 'required',
                      ]);
                  }
            }elseif ($this->status[$value] == 2)
            {

                $this->validate([
                        //   'ptqs.'.$value => 'required',
                          'fakultas_pihak.'.$value => 'required',
                          'prodiPihak.'.$value => 'required',
                          'alamat_pihak.'.$value => 'required',
                          'nama_pejabat_pihak.'.$value => 'required',
                        ]);

            }else
            {
                $namanama = Str::lower($this->nama_pihak[$key]);
    
                if ($namanama == 'universitas hasanuddin')
                {
                    $this->validate([
                        'ptqs.'.$value => 'required',
                        'fakultas_pihak.'.$value => 'required',
                        'alamat_pihak.'.$value => 'required',
                        'nama_pejabat_pihak.'.$value => 'required',
                    ]);
                }else{
                    $this->validate([
                        'ptqs.'.$value => 'required',
                        'fakultas_pihak.'.$value => 'required',
                        'prodiPihak.'.$value => 'required',
                        'alamat_pihak.'.$value => 'required',
                        'nama_pejabat_pihak.'.$value => 'required',
                    ]);
                }
            }
        }

        $this->validate([
            'arrayBentukKegiatan' => 'required'
        ]);

        // validate bentuk kegiatan
        foreach ($this->arrayBentukKegiatan as $key => $value) {
            $this->validate([
                'arrayKinerja.'.$key => 'required',
                'arraySasaran.'.$key => 'required',
                // 'arraySdgs.'.$key => 'required',
            ]);
        }

        $this->validate([
            'arraySdgs' => 'required'
        ]);
    }

    public function update($id)
    {
        $this->validasiSave();
        $getAll = NonProdiDataMoa::where('nomor_dok_unhas', $this->nomor_unhas)->get();
        

        $hitung=0;
        foreach ($this->inputs as $key => $value) {
            $namanama = Str::lower($this->nama_pihak[$key]);
            $arrayNamaPenggiat[$key] = $this->nama_pihak[$key];
            // array_push($arrayNamaPenggiat, $this->nama_pihak[$key]);
            if ($namanama == 'universitas hasanuddin')
            {
                $arrayNamaProdiUH = $this->arrayNamaProdi[$key];
                $status = $this->status[$key]; $alamatPihak1 = $this->alamat_pihak[$key];
                $namaPihak1 = 'Universitas Hasanuddin'; $namaPejabat1 = $this->nama_pejabat_pihak[$key];
                $jabatanPejabat1 = $this->jabatan_pejabat_pihak[$key]??null; $pj1 = $this->pj_pihak[$key]??null;
                $jabatanPj1 = $this->jabatan_pj_pihak[$key]??null; $emailPj1 = $this->email_pj_pihak[$key]??null;
                $fakultas_pihak = $this->fakultas_pihak[$key]; $hpPj1 = $this->hp_pj_pihak[$key]??null;
                $prodi_pihak = $this->prodiPihak[$key]??null;
                $hitung++;
            }

        }

        if ($hitung == 0) {
            $this->emit('alerts', ['pesan' => 'Gagal ditambahkan, Unhas tidak disertakan dalam penggiat kerjasama', 'icon'=>'error'] );
        } else {
            $prodiFromDb = $getAll->pluck('prodi_id');
            $array_database_array = $prodiFromDb->toArray();

            $array_not_in_database = array_diff($prodi_pihak, $array_database_array);
            $array_not_in_prodi = array_diff($array_database_array, $prodi_pihak);
            // dd(json_encode($this->arraySdgs));
            DB::beginTransaction();
            try {
                    if (!empty($array_not_in_database)) {
                        foreach ($array_not_in_database as $key => $value) {
                            $store = NonProdiDataMoa::firstOrCreate([
                                'nomor_dok_unhas' => $this->nomor_unhas,
                                'prodi_id' => $value,
                            ],[
                                'tanggal_ttd' => $this->tanggal_ttd, 'jenis_kerjasama' => $this->jenisKerjasamaField,
                                'tingkat' => $this->jenisKerjasamaField == 2 ? '4':$this->tingkat,
                                'negara' => $this->negara, 'region' => $this->region, 'uuid' => $getAll->first()->uuid,
                                'tempat_pelaksanaan' => $this->tempat_pelaksanaan,
                                'status' => $this->status_kerjasama, 'tanggal_awal' => $this->tanggal_awal,
                                'tanggal_berakhir' => $this->tanggal_berakhir, 'jangka_waktu' => $this->jangka_waktu,
                                'level' => 1 , 'nomor_dok_mitra' => $this->nomor_mitra,
                                'judul' => $this->judul_kerjasama, 'fakultas_pihak' => $fakultas_pihak,
                                'anggaran' => $this->anggaran,
                                'dasar_dokumen' => $this->dasar_dokumen_kerjasama,
                                'sumber_dana' => $this->sumber_dana,
                                'nama_prodi' => Prodi::find($value)->nama_resmi,
                                'deskripsi' => $this->deskripsi,
                                'nama_pihak' => $namaPihak1, 'alamat_pihak' => $alamatPihak1,
                                'nama_pejabat_pihak' => $namaPejabat1, 'jabatan_pejabat_pihak' => $jabatanPejabat1,
                                'pj_pihak' => $pj1, 'jabatan_pj_pihak' => $jabatanPj1,
                                'email_pj_pihak' => $emailPj1, 'hp_pj_pihak' => $hpPj1,
                                'penggiat' => json_encode($arrayNamaPenggiat),
                                'sdgs' => json_encode($this->arraySdgs),
                                'uploaded_by' => auth()->user()->name,
                            ]);

                            if ($store->wasRecentlyCreated)
                            {
                                $code = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                foreach ($this->files as $file) {
                                $random = substr(str_shuffle($code),0,3);
                                $namaDokumen = 'NP-MoA'.$uuid.$random.'.'.$file->extension();
                                $file->storeAs('public/DokumenMoA',$namaDokumen);
                                $store->dokumenMoA()->firstOrCreate([
                                    'url' => $namaDokumen,
                                    'kerjasama_id' => $store->id
                                ]);
                                }
                                foreach ($this->inputs as $key => $value) {
                                    $storePenggiatKerjasama = NonProdiDataMoaPenggiat::create([
                                        'id_lapkerma' => $store->id, 'pihak' => $value+1, 'status_pihak' => $this->status[$key],
                                        'nama_pihak' => $this->nama_pihak[$key], 'fakultas_pihak' => $this->fakultas_pihak[$key]??'', 'alamat_pihak' => $this->alamat_pihak[$key],
                                        'nama_pejabat_pihak' => $this->nama_pejabat_pihak[$key], 'jabatan_pejabat_pihak' => $this->jabatan_pejabat_pihak[$key]??'', 'pj_pihak' => $this->pj_pihak[$key]??null,
                                        'jabatan_pj_pihak' => $this->jabatan_pj_pihak[$key]??'', 'email_pj_pihak' => $this->email_pj_pihak[$key]??null, 'hp_pj_pihak' => $this->hp_pj_pihak[$key]??null,
                                        'ptqs' => $this->ptqs[$key]??null, 'badan_kemitraan' => $this->badanKemitraan[$key]??'', 'uploaded_by' => auth()->user()->name,
                                        'prodi' => json_encode($this->prodiPihak[$key]??null)
                                    ]);
                                    if (optional($this->badanKemitraan)[$key] == 99) {
                                        $storePenggiatKerjasama->update([
                                            'badan_kemitraan' => $this->lainnya[$key]
                                        ]);
                                    }
                                }
                                foreach ($this->arrayBentukKegiatan as $key => $value) {
                                    $storeBentukKegiatanKerjasama = NonProdiDataMoaBentukKegiatanKerjasama::create([
                                        'id_moa' => $store->id,
                                        'nilai_kontrak' => $this->nilai_kontrak[$key]??null,
                                        'volume_satuan' => $this->volume_satuan[$key]??null,
                                        'volume_luaran' => $this->volume_luaran[$key]??null,
                                        'keterangan' => $this->keterangan[$key]??null,
                                        'id_ref_bentuk_kegiatan' => $value,
                                        'id_ref_indikator_kinerja' => $this->arrayKinerja[$key]??null,
                                        'id_ref_sasaran_kegiatan' => $this->arraySasaran[$key]??null,
                                        // 'id_sdgs' => $this->arraySdgs[$key]??null,
                                        // 'id_sdgs' => $this->sdgs??null,
                                ]);
                                }

                            }
                        }
                    }

                    if (!empty($array_not_in_prodi)) {
                        foreach ($array_not_in_prodi as $key => $value) {
                            $delete = NonProdiDataMoa::where('nomor_dok_unhas', $this->nomor_unhas)->where('prodi_id', $value)->first();
                            $deletePenggiatKerjasama = NonProdiDataMoaPenggiat::where('id_lapkerma', $delete->id)->delete();
                            $deleteBentukKegiatanKerjasama = NonProdiDataMoaBentukKegiatanKerjasama::where('id_moa', $delete->id)->delete();
                            $delete->delete();
                        }
                    }

                    $getUpdate = NonProdiDataMoa::where('nomor_dok_unhas', $this->nomor_unhas)->get();
            
                    // $find = NonProdiDataMoa::find($id);
                    foreach ($getUpdate as $key => $find) {
                        $find->update([
                            'nomor_dok_unhas' => $this->nomor_unhas,
                            'tanggal_ttd' => $this->tanggal_ttd, 'jenis_kerjasama' => $this->jenisKerjasamaField,
                            'tingkat' => $this->jenisKerjasamaField == 2 ? '4':$this->tingkat,
                            'negara' => $this->negara, 'region' => $this->region,
                                'tempat_pelaksanaan' => $this->tempat_pelaksanaan,
                                'status' => $this->status_kerjasama, 'tanggal_awal' => $this->tanggal_awal,
                                'tanggal_berakhir' => $this->tanggal_berakhir, 'jangka_waktu' => $this->jangka_waktu,
                                'level' => 1 , 'nomor_dok_mitra' => $this->nomor_mitra,
                                'judul' => $this->judul_kerjasama, 'fakultas_pihak' => $fakultas_pihak,
                                'prodi_id' => $find->prodi_id,
                                // 'prodi_id' => $this->prodiEx,
                                'dasar_dokumen' => $this->dasar_dokumen_kerjasama,
                                'anggaran' => $this->anggaran,
                                'sumber_dana' => $this->sumber_dana,
                                // 'prodi' => json_encode($prodi_pihak),
                                'nama_prodi' => $find->nama_prodi,
                                // 'nama_prodi' => $this->prodiExNama,
                                // 'nama_prodi' => auth()->user()->prodi->nama_resmi,
                                // 'nama_prodi' => json_encode($arrayNamaProdiUH),
                                'deskripsi' => $this->deskripsi,
                                'nama_pihak' => $namaPihak1, 'alamat_pihak' => $alamatPihak1,
                                'nama_pejabat_pihak' => $namaPejabat1, 'jabatan_pejabat_pihak' => $jabatanPejabat1,
                                'pj_pihak' => $pj1, 'jabatan_pj_pihak' => $jabatanPj1,
                                'email_pj_pihak' => $emailPj1, 'hp_pj_pihak' => $hpPj1,
                                'penggiat' => json_encode($arrayNamaPenggiat),
                                'sdgs' => json_encode($this->arraySdgs),
                                'edited_by' => auth()->user()->name,
                        ]);

                        $findMeTo = NonProdiDataMoaPenggiat::where('id_lapkerma',$id)->delete();

                        if ($this->files) {
                            // membuat kode sistem dokumen
                            $uuid = NonProdiDataMoa::max('id');
                            $uuid = str_pad($uuid+1, 3, '0', STR_PAD_LEFT);
                            $uuid = date('y').$uuid;

                            $code = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                            foreach ($this->files as $file) {
                            $random = substr(str_shuffle($code),0,3);
                            $namaDokumen = 'NP-MoA'.$uuid.$random.'.'.$file->extension();
                            $file->storeAs('public/DokumenMoA',$namaDokumen);
                            $find->dokumenMoA()->firstOrCreate([
                                'url' => $namaDokumen,
                                'kerjasama_id' => $id
                            ]);
                            }
                        }

                        foreach ($this->inputs as $key => $value) {
                            // dd(optional($this->alamat_pihak)[$key]);
                            $storePenggiatKerjasama = NonProdiDataMoaPenggiat::create([
                                'id_lapkerma' => $id, 'pihak' => $value+1, 'status_pihak' => $this->status[$key],
                                'nama_pihak' => $this->nama_pihak[$key],
                                'fakultas_pihak' => $this->fakultas_pihak[$key]??'',
                                 'alamat_pihak' => $this->alamat_pihak[$key],
                                'nama_pejabat_pihak' => $this->nama_pejabat_pihak[$key],
                                 'jabatan_pejabat_pihak' => $this->jabatan_pejabat_pihak[$key]??'',
                                 'pj_pihak' => $this->pj_pihak[$key]??null,
                                'jabatan_pj_pihak' => $this->jabatan_pj_pihak[$key]??null, 'email_pj_pihak' => $this->email_pj_pihak[$key]??null, 'hp_pj_pihak' => $this->hp_pj_pihak[$key]??null,
                                'ptqs' => $this->ptqs[$key]??null, 'badan_kemitraan' => $this->badanKemitraan[$key]??'', 'uploaded_by' => auth()->user()->id,
                                'prodi' => json_encode(optional($this->prodiPihak)[$key])??null
                            ]);
                            if (optional($this->badanKemitraan)[$key] == 99) {
                                $storePenggiatKerjasama->update([
                                    'badan_kemitraan' => $this->lainnya[$key]
                                ]);
                            }
                        }

                        $findMeTo = NonProdiDataMoaBentukKegiatanKerjasama::where('id_moa',$id)->delete();

                        foreach ($this->arrayBentukKegiatan as $key => $value) {
                            $storeBentukKegiatanKerjasama = NonProdiDataMoaBentukKegiatanKerjasama::create([
                                'id_moa' => $id,
                                'nilai_kontrak' => $this->nilai_kontrak[$key]??null,
                                'volume_satuan' => $this->volume_satuan[$key]??null,
                                'volume_luaran' => $this->volume_luaran[$key]??null,
                                'keterangan' => $this->keterangan[$key]??null,
                                'id_ref_bentuk_kegiatan' => $value,
                                'id_ref_indikator_kinerja' => $this->arrayKinerja[$key],
                                'id_ref_sasaran_kegiatan' => $this->arraySasaran[$key],
                                // 'id_sdgs' => $this->arraySdgs[$key],
                                // 'id_sdgs' => $this->sdgs,
                            ]);
                        }

                    }
                        DB::commit();
                        $this->emit('alerts2', ['pesan' => 'Data Berhasil Diupdate', 'icon'=>'success'] );
                        return redirect()->back();
                } catch (ERROR $th)
                {
                    DB::rollback();
                    dd($th);
                    $this->emit('alerts', ['pesan' => 'Invalid Proses, Gagal Diupdate', 'icon'=>'error'] );
                }

        }
    }

    public function updates($id)
    {
        $this->validasiSave();
        $getAll = NonProdiDataIa::where('nomor_dok_unhas', $this->nomor_unhas)->get();
        // dd($getAll->pluck('prodi_id'));
        // dd($this->prodiPihak);

        $hitung=0;
        foreach ($this->inputs as $key => $value) {
            $namanama = Str::lower($this->nama_pihak[$key]);
            $arrayNamaPenggiat[$key] = $this->nama_pihak[$key];
            // array_push($arrayNamaPenggiat, $this->nama_pihak[$key]);
            if ($namanama == 'universitas hasanuddin')
            {
                $arrayNamaProdiUH = $this->arrayNamaProdi[$key];
                $status = $this->status[$key]; $alamatPihak1 = $this->alamat_pihak[$key];
                $namaPihak1 = 'Universitas Hasanuddin'; $namaPejabat1 = $this->nama_pejabat_pihak[$key];
                $jabatanPejabat1 = $this->jabatan_pejabat_pihak[$key]??null; $pj1 = $this->pj_pihak[$key]??null;
                $jabatanPj1 = $this->jabatan_pj_pihak[$key]??null; $emailPj1 = $this->email_pj_pihak[$key]??null;
                $fakultas_pihak = $this->fakultas_pihak[$key]; $hpPj1 = $this->hp_pj_pihak[$key]??null;
                $prodi_pihak = $this->prodiPihak[$key]??null;
                $hitung++;
            }

        }

        if ($hitung == 0) {
            $this->emit('alerts', ['pesan' => 'Gagal ditambahkan, Unhas tidak disertakan dalam penggiat kerjasama', 'icon'=>'error'] );
        } else {
            $prodiFromDb = $getAll->pluck('prodi_id');
            $array_database_array = $prodiFromDb->toArray();

            $array_not_in_database = array_diff($prodi_pihak, $array_database_array);
            $array_not_in_prodi = array_diff($array_database_array, $prodi_pihak);
            // dd($array_not_in_database);
            DB::beginTransaction();
            try {
                    if (!empty($array_not_in_database)) {
                        foreach ($array_not_in_database as $key => $value) {
                            $store = NonProdiDataIa::firstOrCreate([
                                'nomor_dok_unhas' => $this->nomor_unhas,
                                'prodi_id' => $value,
                            ],[
                                'tanggal_ttd' => $this->tanggal_ttd, 'jenis_kerjasama' => $this->jenisKerjasamaField,
                                'tingkat' => $this->jenisKerjasamaField == 2 ? '4':$this->tingkat,
                                'negara' => $this->negara, 'region' => $this->region, 'uuid' => $getAll->first()->uuid,
                                'tempat_pelaksanaan' => $this->tempat_pelaksanaan,
                                'status' => $this->status_kerjasama, 'tanggal_awal' => $this->tanggal_awal,
                                'tanggal_berakhir' => $this->tanggal_berakhir, 'jangka_waktu' => $this->jangka_waktu,
                                'level' => 1 , 'nomor_dok_mitra' => $this->nomor_mitra,
                                'judul' => $this->judul_kerjasama, 'fakultas_pihak' => $fakultas_pihak,
                                'anggaran' => $this->anggaran,
                                'dasar_dokumen' => $this->dasar_dokumen_kerjasama,
                                'sumber_dana' => $this->sumber_dana,
                                'nama_prodi' => Prodi::find($value)->nama_resmi,
                                'deskripsi' => $this->deskripsi,
                                'nama_pihak' => $namaPihak1, 'alamat_pihak' => $alamatPihak1,
                                'nama_pejabat_pihak' => $namaPejabat1, 'jabatan_pejabat_pihak' => $jabatanPejabat1,
                                'pj_pihak' => $pj1, 'jabatan_pj_pihak' => $jabatanPj1,
                                'email_pj_pihak' => $emailPj1, 'hp_pj_pihak' => $hpPj1,
                                'penggiat' => json_encode($arrayNamaPenggiat),
                                'sdgs' => json_encode($this->arraySdgs),
                                'uploaded_by' => auth()->user()->name,
                            ]);

                            if ($store->wasRecentlyCreated)
                            {
                                $code = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                foreach ($this->files as $file) {
                                $random = substr(str_shuffle($code),0,3);
                                $namaDokumen = 'NP-IA'.$uuid.$random.'.'.$file->extension();
                                $file->storeAs('public/DokumenIA',$namaDokumen);
                                $store->dokumenMoA()->firstOrCreate([
                                    'url' => $namaDokumen,
                                    'kerjasama_id' => $store->id
                                ]);
                                }
                                foreach ($this->inputs as $key => $value) {
                                    $storePenggiatKerjasama = NonProdiDataIaPenggiat::create([
                                        'id_lapkerma' => $store->id, 'pihak' => $value+1, 'status_pihak' => $this->status[$key],
                                        'nama_pihak' => $this->nama_pihak[$key], 'fakultas_pihak' => $this->fakultas_pihak[$key]??'', 'alamat_pihak' => $this->alamat_pihak[$key],
                                        'nama_pejabat_pihak' => $this->nama_pejabat_pihak[$key], 'jabatan_pejabat_pihak' => $this->jabatan_pejabat_pihak[$key]??'', 'pj_pihak' => $this->pj_pihak[$key]??null,
                                        'jabatan_pj_pihak' => $this->jabatan_pj_pihak[$key]??'', 'email_pj_pihak' => $this->email_pj_pihak[$key]??null, 'hp_pj_pihak' => $this->hp_pj_pihak[$key]??null,
                                        'ptqs' => $this->ptqs[$key]??null, 'badan_kemitraan' => $this->badanKemitraan[$key]??'', 'uploaded_by' => auth()->user()->name,
                                        'prodi' => json_encode($this->prodiPihak[$key]??null)
                                    ]);
                                    if (optional($this->badanKemitraan)[$key] == 99) {
                                        $storePenggiatKerjasama->update([
                                            'badan_kemitraan' => $this->lainnya[$key]
                                        ]);
                                    }
                                }
                                foreach ($this->arrayBentukKegiatan as $key => $value) {
                                    $storeBentukKegiatanKerjasama = NonProdiDataIaBentukKegiatanKerjasama::create([
                                        'id_ia' => $store->id,
                                        'nilai_kontrak' => $this->nilai_kontrak[$key]??null,
                                        'volume_satuan' => $this->volume_satuan[$key]??null,
                                        'volume_luaran' => $this->volume_luaran[$key]??null,
                                        'keterangan' => $this->keterangan[$key]??null,
                                        'id_ref_bentuk_kegiatan' => $value,
                                        'id_ref_indikator_kinerja' => $this->arrayKinerja[$key]??null,
                                        'id_ref_sasaran_kegiatan' => $this->arraySasaran[$key]??null,
                                        // 'id_sdgs' => $this->arraySdgs[$key]??null,
                                        // 'id_sdgs' => $this->sdgs??null,
                                ]);
                                }

                            }
                        }
                    }

                    if (!empty($array_not_in_prodi)) {
                        foreach ($array_not_in_prodi as $key => $value) {
                            $delete = NonProdiDataIa::where('nomor_dok_unhas', $this->nomor_unhas)->where('prodi_id', $value)->first();
                            $deletePenggiatKerjasama = NonProdiDataIaPenggiat::where('id_lapkerma', $delete->id)->delete();
                            $deleteBentukKegiatanKerjasama = NonProdiDataIaBentukKegiatanKerjasama::where('id_ia', $delete->id)->delete();
                            $delete->delete();
                        }
                    }

                    $getUpdate = NonProdiDataIa::where('nomor_dok_unhas', $this->nomor_unhas)->get();
            
                    // $find = NonProdiDataMoa::find($id);
                    foreach ($getUpdate as $key => $find) {
                        $find->update([
                            'nomor_dok_unhas' => $this->nomor_unhas,
                            'tanggal_ttd' => $this->tanggal_ttd, 'jenis_kerjasama' => $this->jenisKerjasamaField,
                            'tingkat' => $this->jenisKerjasamaField == 2 ? '4':$this->tingkat,
                            'negara' => $this->negara, 'region' => $this->region,
                                'tempat_pelaksanaan' => $this->tempat_pelaksanaan,
                                'status' => $this->status_kerjasama, 'tanggal_awal' => $this->tanggal_awal,
                                'tanggal_berakhir' => $this->tanggal_berakhir, 'jangka_waktu' => $this->jangka_waktu,
                                'level' => 1 , 'nomor_dok_mitra' => $this->nomor_mitra,
                                'judul' => $this->judul_kerjasama, 'fakultas_pihak' => $fakultas_pihak,
                                'prodi_id' => $find->prodi_id,
                                // 'prodi_id' => $this->prodiEx,
                                'dasar_dokumen' => $this->dasar_dokumen_kerjasama,
                                'anggaran' => $this->anggaran,
                                'sumber_dana' => $this->sumber_dana,
                                // 'prodi' => json_encode($prodi_pihak),
                                'nama_prodi' => $find->nama_prodi,
                                // 'nama_prodi' => $this->prodiExNama,
                                // 'nama_prodi' => auth()->user()->prodi->nama_resmi,
                                // 'nama_prodi' => json_encode($arrayNamaProdiUH),
                                'deskripsi' => $this->deskripsi,
                                'nama_pihak' => $namaPihak1, 'alamat_pihak' => $alamatPihak1,
                                'nama_pejabat_pihak' => $namaPejabat1, 'jabatan_pejabat_pihak' => $jabatanPejabat1,
                                'pj_pihak' => $pj1, 'jabatan_pj_pihak' => $jabatanPj1,
                                'email_pj_pihak' => $emailPj1, 'hp_pj_pihak' => $hpPj1,
                                'penggiat' => json_encode($arrayNamaPenggiat),
                                'sdgs' => json_encode($this->arraySdgs),
                                'edited_by' => auth()->user()->name,
                        ]);

                        $findMeTo = NonProdiDataIaPenggiat::where('id_lapkerma',$id)->delete();

                        if ($this->files) {
                            // membuat kode sistem dokumen
                            $uuid = NonProdiDataIa::max('id');
                            $uuid = str_pad($uuid+1, 3, '0', STR_PAD_LEFT);
                            $uuid = date('y').$uuid;

                            $code = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                            foreach ($this->files as $file) {
                            $random = substr(str_shuffle($code),0,3);
                            $namaDokumen = 'NP-IA'.$uuid.$random.'.'.$file->extension();
                            $file->storeAs('public/DokumenIA',$namaDokumen);
                            $find->dokumenMoA()->firstOrCreate([
                                'url' => $namaDokumen,
                                'kerjasama_id' => $id
                            ]);
                            }
                        }

                        foreach ($this->inputs as $key => $value) {
                            // dd(optional($this->alamat_pihak)[$key]);
                            $storePenggiatKerjasama = NonProdiDataIaPenggiat::create([
                                'id_lapkerma' => $id, 'pihak' => $value+1, 'status_pihak' => $this->status[$key],
                                'nama_pihak' => $this->nama_pihak[$key],
                                'fakultas_pihak' => $this->fakultas_pihak[$key]??'',
                                 'alamat_pihak' => $this->alamat_pihak[$key],
                                'nama_pejabat_pihak' => $this->nama_pejabat_pihak[$key],
                                 'jabatan_pejabat_pihak' => $this->jabatan_pejabat_pihak[$key]??'',
                                 'pj_pihak' => $this->pj_pihak[$key]??null,
                                'jabatan_pj_pihak' => $this->jabatan_pj_pihak[$key]??null, 'email_pj_pihak' => $this->email_pj_pihak[$key]??null, 'hp_pj_pihak' => $this->hp_pj_pihak[$key]??null,
                                'ptqs' => $this->ptqs[$key]??null, 'badan_kemitraan' => $this->badanKemitraan[$key]??'', 'uploaded_by' => auth()->user()->id,
                                'prodi' => json_encode(optional($this->prodiPihak)[$key])??null
                            ]);
                            if (optional($this->badanKemitraan)[$key] == 99) {
                                $storePenggiatKerjasama->update([
                                    'badan_kemitraan' => $this->lainnya[$key]
                                ]);
                            }
                        }

                        $findMeTo = NonProdiDataIaBentukKegiatanKerjasama::where('id_ia',$id)->delete();

                        foreach ($this->arrayBentukKegiatan as $key => $value) {
                            $storeBentukKegiatanKerjasama = NonProdiDataIaBentukKegiatanKerjasama::create([
                                'id_ia' => $id,
                                'nilai_kontrak' => $this->nilai_kontrak[$key]??null,
                                'volume_satuan' => $this->volume_satuan[$key]??null,
                                'volume_luaran' => $this->volume_luaran[$key]??null,
                                'keterangan' => $this->keterangan[$key]??null,
                                'id_ref_bentuk_kegiatan' => $value,
                                'id_ref_indikator_kinerja' => $this->arrayKinerja[$key],
                                'id_ref_sasaran_kegiatan' => $this->arraySasaran[$key],
                                // 'id_sdgs' => $this->arraySdgs[$key],
                                'id_sdgs' => $this->sdgs,
                            ]);
                        }

                    }
                        DB::commit();
                        $this->emit('alerts2', ['pesan' => 'Data Berhasil Diupdate', 'icon'=>'success'] );
                        return redirect()->back();
                } catch (ERROR $th)
                {
                    DB::rollback();
                    dd($th);
                    $this->emit('alerts', ['pesan' => 'Invalid Proses, Gagal Diupdate', 'icon'=>'error'] );
                }

        }
    }


}
