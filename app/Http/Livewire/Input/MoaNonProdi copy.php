<?php

namespace App\Http\Livewire\Input;

use App\Http\Livewire\Edit\Nonprodi;
use Livewire\Component;
use App\Models\DataMoaDokumen;use App\Models\NonProdiDataIaDokumen;
use App\Models\DataMoaPenggiat;use App\Models\NonProdiDataIaPenggiat;
use App\Models\DataMoaBentukKegiatanKerjasama;use App\Models\NonProdiDataIaBentukKegiatanKerjasama;
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
use App\Models\ProdiMitra;
use App\Models\Fakultas;
use App\Models\FakultasPihak;
use App\Models\KegiatanKerjasama;
use App\Models\NonProdiDataMoa;
use App\Models\NonProdiDataMoaBentukKegiatanKerjasama;
use App\Models\NonProdiDataMoaPenggiat;
use App\Models\ReferensiSumberDanaLapkerma;
use App\Models\PenggiatKerjasama;
use App\Models\Sdgs;
use App\Models\StatusKerjasama;
use Illuminate\Database\QueryException as ERROR;
use DB;
use Hamcrest\Type\IsNumeric;
use phpDocumentor\Reflection\Types\This;
use Illuminate\Support\Str;

class MoaNonProdi extends Component
{
    use WithFileUploads;
    public $nama_fakultas = [], $lockFakultas = [], $arrayFakultas =[], $changeJenis, $disMoA = false;
    public $arrayMitra = [], $prodiPihak = [], $getFakultasMitras, $searchFakultasMitra = [], $fakultasMitra = [];
    public $bentukKegiatan, $renderSwitch , $badanKemitraan = [], $lainnya = [], $ptqs = [], $idEdit, $findDokumen, $showProdiDefault = [];
    public $arrayProdi=[], $arrayNamaProdi = [], $name = [], $showLoadFiles = false, $jenisKerjasamaField;
    public $ottPlatform, $files = [], $arrayJawaban = 1, $pin, $status = [], $inputs = [0,1], $lockInstansi = [];
    public $arrayBentukKegiatan = [], $arraySasaran = [], $arrayKinerja = [], $arraySdgs = [], $keterangan, $volume_luaran, $volume_satuan, $nilai_kontrak;

    public $tanggal_ttd, $jenis_kerjasama, $tingkat, $negara, $region, $kegiatan_kerjasama, $tempat_pelaksanaan, $status_kerjasama;
    public $tanggal_awal, $tanggal_berakhir, $jangka_waktu, $jenis_dokumen_kerjasama, $dasar_dokumen_kerjasama, $cek_dasar_dokumen_kerjasama;
    public $nomor_unhas, $nomor_mitra, $judul_kerjasama, $deskripsi, $anggaran, $sumber_dana;

    public $nama_pihak = [], $fakultas_pihak = [], $alamat_pihak = [];
    public $nama_pejabat_pihak = [], $jabatan_pejabat_pihak = [], $pj_pihak = [], $jabatan_pj_pihak = [];
    public $email_pj_pihak = [], $hp_pj_pihak = [];
    public $jenisKerjasama, $negaraKerjasama, $regionKerjasama, $kegiatanKerjasama, $statusKerjasama, $dasarDokKerjasama2;
    public $stat1, $stat2, $stat3, $stat4, $stat5, $stat6, $stat7, $stat8, $searchProdiMitra, $fakultas, $prodiMitra=[], $prodiAll, $dasarDokKerjasama, $sumberDana;

    public $getBentukKegiatan, $getIndikatorKinerja, $getSasaranKegiatan, $jenisDokKerjasama, $getProdiMitras, $getSdgs, $bentukSdgs, $arraySdgs = [];
    protected $listeners = ['successMe' => 'takeSuccess',
                            'errorMe' => 'takeError',
                            'getEditData' => 'showEditData',
                            'addProdiMitra' => 'addProdiMitra',
                            'addInstansi' => 'addInstansi',
                            'addFakultasMitra' => 'addFakultasMitra',
                            ];

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

    public function setJenis()
    {

        $this->jenis_dokumen_kerjasama = $this->changeJenis;
    }

    public function updatedJenisDokumenKerjasama()
    {
        $this->reset('dasar_dokumen_kerjasama');
        $this->dispatchBrowserEvent('contentChanged');
    }

    public function updatedRegion()
    {
        $this->dispatchBrowserEvent('contentChanged');
    }

    public function updatedDasarDokumenKerjasama()
    {
        $this->dispatchBrowserEvent('contentChanged');
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
        if ($status != 0) {
            $instansi = Str::lower($value);
           
            if (strpos($instansi, 'unhas') !== false) {
                // Jika $nama mengandung kata "Unhas"
                $this->emit('alerts', ['pesan' => 'Gunakan Nama Uiversitas Hasanuddin', 'icon'=>'error'] );
            } else {
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
            
        } else {
            $this->emit('alerts', ['pesan' => 'Gagal Silahkan Pilih Status', 'icon'=>'error'] );
        }

    }
    public function mount($id=null,$val=null)
    {
        if ($val == 3) {
            $this->jenis_dokumen_kerjasama = $val;
        } else {
            $this->cek_dasar_dokumen_kerjasama = $id;
        }

        $this->dasar_dokumen_kerjasama = $id;

        $this->fakultas = Fakultas::whereNot('id', 1000)->get();
        $this->getBentukKegiatan = LapkermaRefBentukKegiatan::get();
        $this->getIndikatorKinerja = LapkermaRefIndikatorKinerja::get();
        $this->getSasaranKegiatan = LapkermaRefSasaranKegiatan::get();
        $this->sumberDana = ReferensiSumberDanaLapkerma::get();
        $this->jenisKerjasama = JenisKerjasama::get();
        $this->regionKerjasama = Region::get();
        $this->negaraKerjasama = Negara::get();
        $this->kegiatanKerjasama = KegiatanKerjasama::get();
        $this->statusKerjasama = StatusKerjasama::get();
        $this->jenisDokKerjasama = JenisDokumenKerjasama::get();
        $this->getSdgs = Sdgs::get();

        $this->jenisKerjasamaField = 1;
        $this->updatedJenisKerjasamaField();

        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 5) {
            // if ($this->renderSwitch == 'moa') {
                $this->dasarDokKerjasama = DataMou::get();
            // } else {
                $this->dasarDokKerjasama2 = NonProdiDataMoa::get();
            // }
          $this->prodiAll = Prodi::get();
        } else {
          $this->prodiAll = Prodi::where('id_fakultas',auth()->user()->fakultas_id)->get();
          $this->dasarDokKerjasama = DataMou::whereIn('fakultas_pihak',[auth()->user()->fakultas_id,1000])->orderBy('id', 'desc')->get();
          $this->dasarDokKerjasama2 = NonProdiDataMoa::where('fakultas_pihak',auth()->user()->fakultas_id)->orderBy('id', 'desc')->get();
        }
        // dd($this->dasarDokKerjasama2);
    }

    public function render()
    {
        $this->getProdiMitras = ProdiMitra::get();
        $this->getFakultasMitras = FakultasPihak::get();

            return view('livewire.input.moa-non-prodi');
    }

    public function redirek()
    {
        return redirect()->route('nonprodi-moa-in');
    }

    public function pushNamaInstansi($key,$id,$nama,$status)
    {
        // dd(auth()->user()->fakultas_id);
        $this->nama_pihak[$key] = $nama;
        $this->arrayMitra[$key] = $id;
        $this->lockInstansi[$key] = 1;
        $this->status[$key] = $status;
        if ($id == 1 || $id == 55) {
           $this->fakultas_pihak[$key] = auth()->user()->fakultas_id;
        }
    }

    public function pushNamaFakultas($key,$id,$nama)
    {
        $this->nama_fakultas[$key] = $nama;
        $this->fakultas_pihak[$key] = $id;
        // $this->arrayFakultas[$key] = $id;
        $this->lockFakultas[$key] = 1;


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

    public function unsetFakultas($key, $id)
    {
        $results=array_search($id,$this->prodiPihak[$key],true);
        if($results !== false) {
            unset($this->prodiPihak[$key][$results]);
        }
    }

    public function updatedJenisKerjasamaField()
    {
        if ($this->jenisKerjasamaField == 1) {
            $this->region = 1;
            $this->negara = 'Indonesia';
        } else {
            $this->reset('region','negara');
            $this->dispatchBrowserEvent('contentChanged');
        }
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
        $this->dispatchBrowserEvent('contentChanged');
    }

    public function updatedSdgs() 
    {
        dd('abc');
    }

    public function minArrayBentuk($i)
    {
        unset($this->arrayBentukKegiatan[$i]);
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
        $this->dispatchBrowserEvent('contentChanged');
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
            //   $this->dispatchBrowserEvent('disableSelect'.$value);
              $this->fakultas_pihak[$value] = null;
              $this->prodiPihak[$value] = null;
            }else{
                // $this->fakultas_pihak[$value] = auth()->user()->fakultas_id;
                // $this->dispatchBrowserEvent('enableSelect'.$value);
            }
          }
      }
    }

    public function validasiSave()
    {
        if ($this->jenisKerjasamaField == 2) {
            $this->validate([
                  'region' => 'required',
                  'negara' => 'required',
                  'tempat_pelaksanaan' => 'required',
                  'files' => 'required',
                  'jenis_dokumen_kerjasama' => 'required',
                  'nomor_unhas' => 'required',
                  'judul_kerjasama' => 'required',
                  'deskripsi' => 'required',
                  'tanggal_ttd' => 'date|required',
                  'tanggal_awal' => 'date|required',
                  'tanggal_berakhir' => 'date|required',
                  'status_kerjasama' => 'required',
                  'jangka_waktu' => 'required',
            ]);
        }else {

            $this->validate([
                  'tempat_pelaksanaan' => 'required',
                //   'files' => 'required',
                  'jenis_dokumen_kerjasama' => 'required',
                  'tingkat' => 'required',
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

                      ]);
                  }else{
                      $this->validate([
                          'badanKemitraan.'.$value => 'required',
                          'alamat_pihak.'.$value => 'required',
                          'nama_pejabat_pihak.'.$value => 'required',

                      ]);
                  }
            }elseif ($this->status[$value] == 2)
            {

                $this->validate([
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
            'sdgs' => 'required',
        ]);

    }

    public function saveMoA()
    {
        $this->validasiSave();
        $hitung=0;
        foreach ($this->inputs as $key => $value) {
            $namanama = Str::lower($this->nama_pihak[$key]);
            $arrayNamaPenggiat[$key] = $this->nama_pihak[$key];
            if ($namanama == 'universitas hasanuddin')
            {
                $arrayNamaProdiUH = $this->arrayNamaProdi[$key];
                $alamatPihak1 = $this->alamat_pihak[$key];
                $namaPihak1 = 'Universitas Hasanuddin'; $namaPejabat1 = $this->nama_pejabat_pihak[$key];
                $jabatanPejabat1 = $this->jabatan_pejabat_pihak[$key]??null; $pj1 = $this->pj_pihak[$key]??null;
                $jabatanPj1 = $this->jabatan_pj_pihak[$key]??null; $emailPj1 = $this->email_pj_pihak[$key]??null;
                $fakultas_pihak = $this->fakultas_pihak[$key]; $hpPj1 = $this->hp_pj_pihak[$key]??null;
                $prodi_pihak = $this->prodiPihak[$key]??null;
                $hitung++;
            }

        }

        // membuat kode sistem dokumen
        $uuid = NonProdiDataMoa::max('id');
        $uuid = str_pad($uuid+1, 3, '0', STR_PAD_LEFT);
        $uuid = 'NP-MoA-'.date('y').$uuid;

        if ($hitung == 0) {
            $this->emit('alerts', ['pesan' => 'Gagal ditambahkan, Unhas tidak disertakan dalam penggiat kerjasama', 'icon'=>'error'] );
        } else {
            if ($this->files)
            {

                DB::beginTransaction();
                try {
                    
                        foreach ($prodi_pihak as $key => $value) {
                            $store = NonProdiDataMoa::firstOrCreate([
                                'nomor_dok_unhas' => $this->nomor_unhas,
                                'prodi_id' => $value,
                            ],[
                                'tanggal_ttd' => $this->tanggal_ttd, 'jenis_kerjasama' => $this->jenisKerjasamaField,
                                'tingkat' => $this->jenisKerjasamaField == 2 ? '4':$this->tingkat,
                                'negara' => $this->negara, 'region' => $this->region, 'uuid' => $uuid,
                                'tempat_pelaksanaan' => $this->tempat_pelaksanaan,
                                'status' => $this->status_kerjasama, 'tanggal_awal' => $this->tanggal_awal,
                                'tanggal_berakhir' => $this->tanggal_berakhir, 'jangka_waktu' => $this->jangka_waktu,
                                'level' => 1 , 'nomor_dok_mitra' => $this->nomor_mitra,
                                'judul' => $this->judul_kerjasama, 'fakultas_pihak' => $fakultas_pihak,
                                'anggaran' => $this->anggaran,
                                'dasar_dokumen' => $this->dasar_dokumen_kerjasama,
                                'sumber_dana' => $this->sumber_dana,
                                'nama_prodi' => $arrayNamaProdiUH[$key],
                                'deskripsi' => $this->deskripsi,
                                'nama_pihak' => $namaPihak1, 'alamat_pihak' => $alamatPihak1,
                                'nama_pejabat_pihak' => $namaPejabat1, 'jabatan_pejabat_pihak' => $jabatanPejabat1,
                                'pj_pihak' => $pj1, 'jabatan_pj_pihak' => $jabatanPj1,
                                'email_pj_pihak' => $emailPj1, 'hp_pj_pihak' => $hpPj1,
                                'penggiat' => json_encode($arrayNamaPenggiat),
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
                                    ]);
                                }

                            }
                        }
                        DB::commit();
                        $this->emit('alerts2', ['pesan' => 'Data Berhasil Ditambahkan', 'icon'=>'success'] );
                    } catch (ERROR $th)
                    {
                        DB::rollback();
                        dd($th);
                        $this->emit('alerts', ['pesan' => 'Invalid Proses, Gagal Ditambahkan', 'icon'=>'error'] );
                    }
            }else{
                $this->emit('alerts', ['pesan' => 'Tidak Ada File Pendukung, Data Gagal Ditambahkan', 'icon'=>'error'] );
            }
        }

    }

    public function saveIa()
    {
        $this->validasiSave();

        $hitung=0;
        foreach ($this->inputs as $key => $value) {
            $namanama = Str::lower($this->nama_pihak[$key]);
            $arrayNamaPenggiat[$key] = $this->nama_pihak[$key];

            if ($namanama == 'universitas hasanuddin')
            {
                $arrayNamaProdiUH = $this->arrayNamaProdi[$key];
                $alamatPihak1 = $this->alamat_pihak[$key];
                $namaPihak1 = 'Universitas Hasanuddin'; $namaPejabat1 = $this->nama_pejabat_pihak[$key];
                $jabatanPejabat1 = $this->jabatan_pejabat_pihak[$key]??null; $pj1 = $this->pj_pihak[$key]??null;
                $jabatanPj1 = $this->jabatan_pj_pihak[$key]??null; $emailPj1 = $this->email_pj_pihak[$key]??null;
                $fakultas_pihak = $this->fakultas_pihak[$key]; $hpPj1 = $this->hp_pj_pihak[$key]??null;
                $prodi_pihak = $this->prodiPihak[$key]??null;
                $hitung++;
            }
        }
        // membuat kode sistem dokumen
        $uuid = NonProdiDataIa::max('id');
        $uuid = str_pad($uuid+1, 3, '0', STR_PAD_LEFT);
        $uuid = 'NP-IA-'.date('y').$uuid;

        if ($hitung == 0) {
            $this->emit('alerts', ['pesan' => 'Gagal ditambahkan, Unhas tidak disertakan dalam penggiat kerjasama', 'icon'=>'error'] );
        } else {
            if ($this->files)
            {
                DB::beginTransaction();
                try {
                        foreach ($prodi_pihak as $key => $value) {
                            $store = NonProdiDataIa::firstOrCreate([
                                'nomor_dok_unhas' => $this->nomor_unhas,
                                'prodi_id' => $value,
                            ],[
                                'tanggal_ttd' => $this->tanggal_ttd, 'jenis_kerjasama' => $this->jenisKerjasamaField,
                                'tingkat' => $this->jenisKerjasamaField == 2 ? '4':$this->tingkat,
                                'negara' => $this->negara, 'region' => $this->region, 'uuid' => $uuid,
                                'tempat_pelaksanaan' => $this->tempat_pelaksanaan,
                                'status' => $this->status_kerjasama, 'tanggal_awal' => $this->tanggal_awal,
                                'tanggal_berakhir' => $this->tanggal_berakhir, 'jangka_waktu' => $this->jangka_waktu,
                                'level' => 1 , 'nomor_dok_mitra' => $this->nomor_mitra,
                                'judul' => $this->judul_kerjasama, 'fakultas_pihak' => $fakultas_pihak,
                                'anggaran' => $this->anggaran,
                                'dasar_dokumen' => $this->dasar_dokumen_kerjasama,
                                'sumber_dana' => $this->sumber_dana,
                                'nama_prodi' => $arrayNamaProdiUH[$key],
                                'deskripsi' => $this->deskripsi,
                                'nama_pihak' => $namaPihak1, 'alamat_pihak' => $alamatPihak1,
                                'nama_pejabat_pihak' => $namaPejabat1, 'jabatan_pejabat_pihak' => $jabatanPejabat1,
                                'pj_pihak' => $pj1, 'jabatan_pj_pihak' => $jabatanPj1,
                                'email_pj_pihak' => $emailPj1, 'hp_pj_pihak' => $hpPj1,
                                'penggiat' => json_encode($arrayNamaPenggiat),
                                'uploaded_by' => auth()->user()->name,
                            ]);

                            if ($store->wasRecentlyCreated)
                            {
                                $code = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                foreach ($this->files as $file) {
                                $random = substr(str_shuffle($code),0,3);
                                $namaDokumen = 'NP-IA'.$uuid.$random.'.'.$file->extension();
                                $file->storeAs('public/DokumenIA',$namaDokumen);
                                $store->dokumenIA()->firstOrCreate([
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
                                        'id_sdgs' => $this->sdgs??null,
                                        // 'id_sdgs' => $this->arraySdgs[$key]??null,
                                    ]);
                                }

                            }
                        }
                        DB::commit();
                        $this->emit('alerts2', ['pesan' => 'Data Berhasil Ditambahkan', 'icon'=>'success'] );
                    

                    } catch (ERROR $th)
                    {
                        DB::rollback();
                        dd($th);
                        $this->emit('alerts', ['pesan' => 'Invalid Proses, Gagal Ditambahkan', 'icon'=>'error'] );
                    }
            }else{
                $this->emit('alerts', ['pesan' => 'Tidak Ada File Pendukung, Data Gagal Ditambahkan', 'icon'=>'error'] );
            }
        }

    }

    
}
