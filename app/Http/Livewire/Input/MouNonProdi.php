<?php

namespace App\Http\Livewire\Input;

use App\Models\DataMouDokumen;
use App\Models\DataMouPenggiat;
use App\Models\DataMou;
use App\Models\JenisKerjasama;
use App\Models\LapkermaRefSasaranKegiatan;
use App\Models\Region;
use App\Models\Fakultas;
use App\Models\LapkermaRefBentukKegiatan;
use App\Models\DataMouBentukKegiatanKerjasama;
use App\Models\LapkermaRefIndikatorKinerja;
use App\Models\StatusKerjasama;
use Livewire\WithFileUploads;
use Livewire\Component;
use App\Http\Livewire\Field;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException as ERROR;
use DB;

class MouNonProdi extends Component
{
    use WithFileUploads;

    public $inputs = [1], $arrayJawaban = 1, $showLoadFiles, $idEdit, $findDokumen;
    public $fakultas = [], $statusKerjasama, $getSasaranKegiatan, $getIndikatorKinerja, $getBentukKegiatan ,$bentukKegiatan;

    public $nama_pihak = ['Universitas Hasanuddin'], $status, $fakultas_pihak = [], $alamat_pihak = [];
    public $nama_pejabat_pihak = [], $jabatan_pejabat_pihak = [], $pj_pihak = [], $jabatan_pj_pihak = []; 
    public $email_pj_pihak = [], $hp_pj_pihak = [], $files = [], $badanKemitraan = [], $lainnya = [], $ptqs = [];
    public $regionKerjasama, $jenisKerjasama;

    public $arrayBentukKegiatan = [], $arraySasaran = [], $arrayKinerja = [], $keterangan, $volume_luaran, $volume_satuan, $nilai_kontrak;

    public $jenisKerjasamaField, $region, $negara, $tempat_pelaksanaan;

    public $nomor_unhas, $nomor_mitra, $judul_kerjasama, $deskripsi;

    public $tanggal_ttd, $tanggal_awal, $tanggal_berakhir, $status_kerjasama, $jangka_waktu;

    protected $listeners = ['successMe' => 'takeSuccess',
                            'errorMe' => 'takeError','getEditData2' => 'showEditData'
                            ];

    public function mount()
    {
        $this->getIndikatorKinerja = LapkermaRefIndikatorKinerja::get();
        $this->getSasaranKegiatan = LapkermaRefSasaranKegiatan::get();
        $this->getBentukKegiatan = LapkermaRefBentukKegiatan::get();
        $this->statusKerjasama = StatusKerjasama::get();
        $this->fakultas = Fakultas::get();
        $this->jenisKerjasama = JenisKerjasama::get();
        $this->regionKerjasama = Region::get();
        $this->jenisKerjasamaField = 1;
        $this->updatedJenisKerjasamaField();
        
    }

    public function saves()
    {
        if ($this->jenisKerjasamaField == 2) {
            $this->validate([
                'region' => 'required',
                'negara' => 'required',
            ]);
        }else {
            $this->validate([
                'nomor_mitra' => 'required',
            ]);
        }

        $this->validate([
            'jenisKerjasamaField' => 'required',
            'tempat_pelaksanaan' => 'required',
            'files' => 'required',
            'nomor_unhas' => 'required',
            'judul_kerjasama' => 'required',
            'deskripsi' => 'required',
            'tanggal_ttd' => 'required',
            'tanggal_awal' => 'required',
            'tanggal_berakhir' => 'required',
            'status_kerjasama' => 'required',
            'jangka_waktu' => 'required',
            'fakultas_pihak.0' => 'required',
            'alamat_pihak.0' => 'required',
            'nama_pejabat_pihak.0' => 'required',
            'pj_pihak.0' => 'required',
            'email_pj_pihak.0' => 'required',
            'hp_pj_pihak.0' => 'required',
            'arrayBentukKegiatan' => 'required'
        ]);

        // validate penggiat kerjasama
        foreach (range(1,$this->arrayJawaban) as $key => $value) {
            $this->validate([
                'status.'.$value => 'required',
                'nama_pihak.'.$value => 'required',
                'alamat_pihak.'.$value => 'required',
                'nama_pejabat_pihak.'.$value => 'required',
                'pj_pihak.'.$value => 'required',
                'email_pj_pihak.'.$value => 'required',
                'hp_pj_pihak.'.$value => 'required',

            ]);
            if ($this->status[$value] == 1) {
                $this->validate([
                    'fakultas_pihak.'.$value => 'required',
                    'ptqs.'.$value => 'required',
                ]);
            }
            if ($this->status[$value] == 2) {
                $this->validate([
                    'fakultas_pihak.'.$value => 'required',
                ]);
            }
            if ($this->status[$value] == 3) {
                $this->validate([
                    'badanKemitraan.'.$value => 'required',
                ]);
                if ($this->badanKemitraan[$value] == 99) {
                    $this->validate([
                        'lainnya.'.$value => 'required',
                    ]);
                }
            }
        }

        // validate bentuk kegiatan
        foreach ($this->arrayBentukKegiatan as $key => $value) {
            $this->validate([
                'arrayKinerja.'.$key => 'required',
                'arraySasaran.'.$key => 'required',
            ]);
        }

        $this->arrayNamaPenggiat = [];
        $hitung=0;
        foreach (range(0,$this->arrayJawaban) as $key => $value) {
            $namanama = Str::lower($this->nama_pihak[$key]);
            if ($namanama == 'unhas' || $namanama == 'universitas hasanuddin') {
                array_push($this->arrayNamaPenggiat, 'Universitas Hasanuddin');
            } else {
                array_push($this->arrayNamaPenggiat, $this->nama_pihak[$key]);
            }
            
            switch ($namanama) {
                case 'unhas':
                    $status = $this->status[$key]; $alamatPihak1 = $this->alamat_pihak[$key];
                    $namaPihak1 = 'Universitas Hasanuddin'; $namaPejabat1 = $this->nama_pejabat_pihak[$key];
                    $jabatanPejabat1 = $this->jabatan_pejabat_pihak[$key]??null; $pj1 = $this->pj_pihak[$key];
                    $jabatanPj1 = $this->jabatan_pj_pihak[$key]??null; $emailPj1 = $this->email_pj_pihak[$key];
                    $fakultas_pihak = $this->fakultas_pihak[$key]??null; $hpPj1 = $this->hp_pj_pihak[$key];
                    $hitung++;
                    break;
                case 'universitas hasanuddin':
                    $status = $this->status[$key]; $alamatPihak1 = $this->alamat_pihak[$key];
                    $namaPihak1 = 'Universitas Hasanuddin'; $namaPejabat1 = $this->nama_pejabat_pihak[$key];
                    $jabatanPejabat1 = $this->jabatan_pejabat_pihak[$key]??null; $pj1 = $this->pj_pihak[$key];
                    $jabatanPj1 = $this->jabatan_pj_pihak[$key]??null; $emailPj1 = $this->email_pj_pihak[$key];
                    $fakultas_pihak = $this->fakultas_pihak[$key]??null; $hpPj1 = $this->hp_pj_pihak[$key];
                    $hitung++;
                    break;
                default:
                    break;
            }
        }

        // membuat kode sistem dokumen
        $uuid = DataMou::max('id');
        $uuid = str_pad($uuid+1, 3, '0', STR_PAD_LEFT);
        $uuid = date('y').$uuid;
        if ($hitung == 0) {
            $this->emit('alerts', ['pesan' => 'Gagal ditambahkan, Unhas tidak disertakan dalam penggiat kerjasama', 'icon'=>'error'] );
          } else {
        if ($this->files) {
            DB::beginTransaction();
            try {
              $store = DataMou::firstOrCreate([
                'nomor_dok_unhas' => $this->nomor_unhas, 
              ],[
                'tanggal_ttd' => $this->tanggal_ttd, 'jenis_kerjasama' => $this->jenisKerjasamaField,
                'negara' => $this->negara, 'region' => $this->region, 'uuid' => $uuid,
                'tempat_pelaksanaan' => $this->tempat_pelaksanaan,
                'status' => $this->status_kerjasama, 'tanggal_awal' => $this->tanggal_awal,
                'tanggal_berakhir' => $this->tanggal_berakhir, 'jangka_waktu' => $this->jangka_waktu,
                'level' => 1 , 'nomor_dok_mitra' => $this->nomor_mitra,
                'judul' => $this->judul_kerjasama, 'fakultas_pihak' => $fakultas_pihak, 
                'deskripsi' => $this->deskripsi,
                'nama_pihak' => $namaPihak1, 'alamat_pihak' => $alamatPihak1,
                'nama_pejabat_pihak' => $namaPejabat1, 'jabatan_pejabat_pihak' => $jabatanPejabat1,
                'pj_pihak' => $pj1, 'jabatan_pj_pihak' => $jabatanPj1,
                'email_pj_pihak' => $emailPj1, 'hp_pj_pihak' => $hpPj1,
                'penggiat' => json_encode($this->arrayNamaPenggiat),
                'uploaded_by' => auth()->user()->id,
              ]);
            if ($store->wasRecentlyCreated)
                {
                    $code = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    foreach ($this->files as $file) {
                      $random = substr(str_shuffle($code),0,3);
                      $namaDokumen = 'MoU'.$uuid.$random.'.'.$file->extension();
                      $file->storeAs('public/DokumenMoU',$namaDokumen);
                      $store->dokumenMoU()->firstOrCreate([
                          'url' => $namaDokumen,
                          'kerjasama_id' => $store->id
                      ]);
                    }
                    foreach (range(0,$this->arrayJawaban) as $key => $value) {
                        $storePenggiatKerjasama = DataMouPenggiat::create([
                            'id_lapkerma' => $store->id, 'pihak' => $value+1, 'status_pihak' => $this->status[$key],
                            'nama_pihak' => $this->nama_pihak[$key], 'fakultas_pihak' => $this->fakultas_pihak[$key]??'', 'alamat_pihak' => $this->alamat_pihak[$key],
                            'nama_pejabat_pihak' => $this->nama_pejabat_pihak[$key], 'jabatan_pejabat_pihak' => $this->jabatan_pejabat_pihak[$key]??'', 'pj_pihak' => $this->pj_pihak[$key],
                            'jabatan_pj_pihak' => $this->jabatan_pj_pihak[$key]??'', 'email_pj_pihak' => $this->email_pj_pihak[$key]??'', 'hp_pj_pihak' => $this->hp_pj_pihak[$key]??'',
                            'ptqs' => $this->ptqs[$key]??null, 'badan_kemitraan' => $this->badanKemitraan[$key]??'', 'uploaded_by' => auth()->user()->id,
                        ]);
                        if (optional($this->badanKemitraan)[$key] == 99) {
                            $storePenggiatKerjasama->update([
                                'badan_kemitraan' => $this->lainnya[$key]
                            ]);
                        }
                    }
                    foreach ($this->arrayBentukKegiatan as $key => $value) {
                        $storeBentukKegiatanKerjasama = DataMouBentukKegiatanKerjasama::create([
                            'id_mou' => $store->id,
                            'nilai_kontrak' => $this->nilai_kontrak[$key]??null,
                            'volume_satuan' => $this->volume_satuan[$key]??null,
                            'volume_luaran' => $this->volume_luaran[$key]??null,
                            'keterangan' => $this->keterangan[$key]??null,
                            'id_ref_bentuk_kegiatan' => $value,
                            'id_ref_indikator_kinerja' => $this->arrayKinerja[$key],
                            'id_ref_sasaran_kegiatan' => $this->arraySasaran[$key],
                        ]);
                    }
                    DB::commit();
                    $this->emit('alerts', ['pesan' => 'Data Berhasil Ditambahkan', 'icon'=>'success'] );
                }else{
                    $this->emit('alerts', ['pesan' => 'Invalid Proses, Data Duplikat', 'icon'=>'error'] );
                }
            } catch (ERROR $th) {
                DB::rollback();
                dd($th);
                $this->emit('alerts', ['pesan' => 'Invalid Proses, Gagal Ditambahkan', 'icon'=>'error'] );
            }
          }else{
              $this->emit('alerts', ['pesan' => 'Tidak Ada File Pendukung, Data Gagal Ditambahkan', 'icon'=>'error'] );
          }
        }
    }


    public function save()
    {
        if ($this->jenisKerjasamaField == 2) {
            $this->validate([
                'region' => 'required',
                'negara' => 'required',
            ]);
        }else {
            $this->validate([
                'nomor_mitra' => 'required',
            ]);
        }

        $this->validate([
            'jenisKerjasamaField' => 'required',
            'tempat_pelaksanaan' => 'required',
            'files' => 'required',
            'nomor_unhas' => 'required',
            'judul_kerjasama' => 'required',
            'deskripsi' => 'required',
            'tanggal_ttd' => 'required',
            'tanggal_awal' => 'required',
            'tanggal_berakhir' => 'required',
            'status_kerjasama' => 'required',
            'jangka_waktu' => 'required',
            'fakultas_pihak.0' => 'required',
            'alamat_pihak.0' => 'required',
            'nama_pejabat_pihak.0' => 'required',
            'pj_pihak.0' => 'required',
            'email_pj_pihak.0' => 'required',
            'hp_pj_pihak.0' => 'required',
            'arrayBentukKegiatan' => 'required'
        ]);

        // validate penggiat kerjasama
        foreach (range(1,$this->arrayJawaban) as $key => $value) {
            $this->validate([
                'status.'.$value => 'required',
                'nama_pihak.'.$value => 'required',
                'alamat_pihak.'.$value => 'required',
                'nama_pejabat_pihak.'.$value => 'required',
                'pj_pihak.'.$value => 'required',
                'email_pj_pihak.'.$value => 'required',
                'hp_pj_pihak.'.$value => 'required',

            ]);
            if ($this->status[$value] == 1) {
                $this->validate([
                    'fakultas_pihak.'.$value => 'required',
                    'ptqs.'.$value => 'required',
                ]);
            }
            if ($this->status[$value] == 2) {
                $this->validate([
                    'fakultas_pihak.'.$value => 'required',
                ]);
            }
            if ($this->status[$value] == 3) {
                $this->validate([
                    'badanKemitraan.'.$value => 'required',
                ]);
                if ($this->badanKemitraan[$value] == 99) {
                    $this->validate([
                        'lainnya.'.$value => 'required',
                    ]);
                }
            }
        }

        // validate bentuk kegiatan
        // foreach ($this->arrayBentukKegiatan as $key => $value) {
        //     $this->validate([
        //         'nilai_kontrak.'.$key => 'required',
        //         'volume_satuan.'.$key => 'required',
        //         'volume_luaran.'.$key => 'required',
        //         'keterangan.'.$key => 'required',
        //         'arrayKinerja.'.$key => 'required',
        //         'arraySasaran.'.$key => 'required',
        //     ]);
        // }

        // memberi inputan default pihak1 
        $this->status[0] = 1; $alamatPihak1 = $this->alamat_pihak[0];
        $namaPihak1 = $this->nama_pihak[0]; $namaPejabat1 = $this->nama_pejabat_pihak[0];
        $jabatanPejabat1 = $this->jabatan_pejabat_pihak[0]??null; $pj1 = $this->pj_pihak[0];
        $jabatanPj1 = $this->jabatan_pj_pihak[0]??null; $emailPj1 = $this->email_pj_pihak[0]??null;
        $hpPj1 = $this->hp_pj_pihak[0]??null;

        // membuat kode sistem dokumen
        $uuid = DataMou::max('id');
        $uuid = str_pad($uuid+1, 3, '0', STR_PAD_LEFT);
        $uuid = date('y').$uuid;
        
        if ($this->files) {
            DB::beginTransaction();
            try {
              $store = DataMou::firstOrCreate([
                'nomor_dok_unhas' => $this->nomor_unhas, 
              ],[
                'tanggal_ttd' => $this->tanggal_ttd, 'jenis_kerjasama' => $this->jenisKerjasamaField,
                'negara' => $this->negara, 'region' => $this->region, 'uuid' => $uuid,
                'tempat_pelaksanaan' => $this->tempat_pelaksanaan,
                'status' => $this->status_kerjasama, 'tanggal_awal' => $this->tanggal_awal,
                'tanggal_berakhir' => $this->tanggal_berakhir, 'jangka_waktu' => $this->jangka_waktu,
                'level' => 2 , 'nomor_dok_mitra' => $this->nomor_mitra,
                'judul' => $this->judul_kerjasama, 'fakultas_pihak' => $this->fakultas_pihak[0],
                'deskripsi' => $this->deskripsi,
                'nama_pihak' => $namaPihak1, 'alamat_pihak' => $alamatPihak1,
                'nama_pejabat_pihak' => $namaPejabat1, 'jabatan_pejabat_pihak' => $jabatanPejabat1,
                'pj_pihak' => $pj1, 'jabatan_pj_pihak' => $jabatanPj1,
                'email_pj_pihak' => $emailPj1, 'hp_pj_pihak' => $hpPj1,
                'uploaded_by' => auth()->user()->id,
              ]);
            if ($store->wasRecentlyCreated)
                {
                    $code = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    foreach ($this->files as $file) {
                      $random = substr(str_shuffle($code),0,3);
                      $namaDokumen = 'MoU'.$uuid.$random.'.'.$file->extension();
                      $file->storeAs('public/DokumenMoU',$namaDokumen);
                      $store->dokumenMoU()->firstOrCreate([
                          'url' => $namaDokumen,
                          'kerjasama_id' => $store->id
                      ]);
                    }
                    foreach (range(0,$this->arrayJawaban) as $key => $value) {
                        $storePenggiatKerjasama = DataMouPenggiat::create([
                            'id_lapkerma' => $store->id, 'pihak' => $value+1, 'status_pihak' => $this->status[$key],
                            'nama_pihak' => $this->nama_pihak[$key], 'fakultas_pihak' => $this->fakultas_pihak[$key]??'', 'alamat_pihak' => $this->alamat_pihak[$key],
                            'nama_pejabat_pihak' => $this->nama_pejabat_pihak[$key], 'jabatan_pejabat_pihak' => $this->jabatan_pejabat_pihak[$key]??'', 'pj_pihak' => $this->pj_pihak[$key],
                            'jabatan_pj_pihak' => $this->jabatan_pj_pihak[$key]??'', 'email_pj_pihak' => $this->email_pj_pihak[$key]??'', 'hp_pj_pihak' => $this->hp_pj_pihak[$key]??'',
                            'ptqs' => $this->ptqs[$key]??null, 'badan_kemitraan' => $this->badanKemitraan[$key]??'', 'uploaded_by' => auth()->user()->id,
                        ]);
                        if (optional($this->badanKemitraan)[$key] == 99) {
                            $storePenggiatKerjasama->update([
                                'badan_kemitraan' => $this->lainnya[$key]
                            ]);
                        }
                    }
                    foreach ($this->arrayBentukKegiatan as $key => $value) {
                        $storeBentukKegiatanKerjasama = DataMouBentukKegiatanKerjasama::create([
                            'id_mou' => $store->id,
                            'nilai_kontrak' => $this->nilai_kontrak[$key]??null,
                            'volume_satuan' => $this->volume_satuan[$key]??null,
                            'volume_luaran' => $this->volume_luaran[$key]??null,
                            'keterangan' => $this->keterangan[$key]??null,
                            'id_ref_bentuk_kegiatan' => $value,
                            'id_ref_indikator_kinerja' => $this->arrayKinerja[$key],
                            'id_ref_sasaran_kegiatan' => $this->arraySasaran[$key],
                        ]);
                    }
                    DB::commit();
                    $this->emit('alerts', ['pesan' => 'Data Berhasil Ditambahkan', 'icon'=>'success'] );
                }else{
                    $this->emit('alerts', ['pesan' => 'Invalid Proses, Data Duplikat', 'icon'=>'error'] );
                }
            } catch (ERROR $th) {
                DB::rollback();
                dd($th);
                $this->emit('alerts', ['pesan' => 'Invalid Proses, Gagal Ditambahkan', 'icon'=>'error'] );
            }
          }else{
              $this->emit('alerts', ['pesan' => 'Tidak Ada File Pendukung, Data Gagal Ditambahkan', 'icon'=>'error'] );
          }
    }

    public function savetest()
    {
        foreach ($this->arrayBentukKegiatan as $key => $value) {
            $this->validate([
                'nilai_kontrak.'.$key => 'required',
                'volume_satuan.'.$key => 'required',
                'volume_luaran.'.$key => 'required',
                'keterangan.'.$key => 'required',
                'arrayKinerja.'.$key => 'required',
                'arraySasaran.'.$key => 'required',
            ]);
        }
        foreach ($this->arrayBentukKegiatan as $key => $value) {
            $storeBentukKegiatanKerjasama = DataMouBentukKegiatanKerjasama::create([
                'id_mou' => 2,
                'nilai_kontrak' => $this->nilai_kontrak[$key],
                'volume_satuan' => $this->volume_satuan[$key],
                'volume_luaran' => $this->volume_luaran[$key],
                'keterangan' => $this->keterangan[$key],
                'id_ref_bentuk_kegiatan' => $value,
                'id_ref_indikator_kinerja' => $this->arrayKinerja[$key],
                'id_ref_sasaran_kegiatan' => $this->arraySasaran[$key],
            ]);
        }
        $this->emit('alerts', ['pesan' => 'Data Berhasil Ditambahkan', 'icon'=>'success'] );
    }

    public function render()
    {
        return view('livewire.input.mou-non-prodi');
    }

    public function showEditData($id)
    {
        $this->idEdit = $id;
        $findMe = DataMou::find($id);

        $this->uuid = $findMe->uuid;
        $this->tanggal_ttd = $findMe->tanggal_ttd;
        $this->jenisKerjasamaField = $findMe->jenis_kerjasama; 
        $this->negara = $findMe->negara; 
        $this->region = $findMe->region; 
        $this->tempat_pelaksanaan = $findMe->tempat_pelaksanaan;
        $this->status_kerjasama = $findMe->status; 
        $this->tanggal_awal = $findMe->tanggal_awal; 
        $this->tanggal_berakhir = $findMe->tanggal_berakhir;
        $this->jangka_waktu = $findMe->jangka_waktu;
        $this->nomor_unhas = $findMe->nomor_dok_unhas; 
        $this->nomor_mitra = $findMe->nomor_dok_mitra; 
        $this->judul_kerjasama = $findMe->judul; 
        $this->deskripsi = $findMe->deskripsi;

        $findMeTo = DataMouPenggiat::where('id_lapkerma',$id);
        $this->arrayJawaban = $findMeTo->count('id')-1;
        $this->inputs = [];
        foreach ($findMeTo->get() as $key => $value) {
            if ($key != 0) {
                array_push($this->inputs ,$key);
            }
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
            if ($value->status_pihak == 3) {
                if (is_int($value->badan_kemitraan)){
                    $this->badanKemitraan[$key] = $value->badan_kemitraan ;
                }else{
                    $this->badanKemitraan[$key] = 99 ;
                    $this->lainnya[$key] = $value->badan_kemitraan ;
                }
            }
           
        }
        $this->findDokumen = DataMouDokumen::where('kerjasama_id',$id)->get();

        $findKegiatan = DataMouBentukKegiatanKerjasama::where('id_mou',$id)->get();
        $this->arrayBentukKegiatan = [];
        foreach ($findKegiatan as $key => $value) {
            array_push($this->arrayBentukKegiatan ,$value->id_ref_bentuk_kegiatan);
            $this->nilai_kontrak[$key] = $value->nilai_kontrak;
            $this->volume_satuan[$key] = $value->volume_satuan;
            $this->volume_luaran[$key] = $value->volume_luaran;
            $this->keterangan[$key] = $value->keterangan;
            $this->arrayKinerja[$key] = $value->id_ref_indikator_kinerja;
            $this->arraySasaran[$key] = $value->id_ref_sasaran_kegiatan;
        }
    }

    public function saveEdit()
    {
        // dd('kdslasj');
        if ($this->jenisKerjasamaField == 2) {
            $this->validate([
                'region' => 'required',
                'negara' => 'required',
            ]);
        }

        $this->validate([
            'jenisKerjasamaField' => 'required',
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
            'fakultas_pihak.0' => 'required',
            'alamat_pihak.0' => 'required',
            'nama_pejabat_pihak.0' => 'required',
            'pj_pihak.0' => 'required',
            'email_pj_pihak.0' => 'required',
            'hp_pj_pihak.0' => 'required',
        ]);
        // dd('kdslasj');

        foreach (range(1,$this->arrayJawaban) as $key => $value) {

            $this->validate([
                'status.'.$value => 'required',
                'nama_pihak.'.$value => 'required',
                'alamat_pihak.'.$value => 'required',
                'nama_pejabat_pihak.'.$value => 'required',
                'pj_pihak.'.$value => 'required',
                'email_pj_pihak.'.$value => 'required',
                'hp_pj_pihak.'.$value => 'required',
            ]);
            if ($this->status[$value] == 1) {
                $this->validate([
                    'fakultas_pihak.'.$value => 'required',
                    'ptqs.'.$value => 'required',
                ]);
            }
            if ($this->status[$value] == 2) {
                $this->validate([
                    'fakultas_pihak.'.$value => 'required',
                ]);
            }
            if ($this->status[$value] == 3) {
                $this->validate([
                    'badanKemitraan.'.$value => 'required',
                ]);
                if ($this->badanKemitraan[$value] == 99) {
                    $this->validate([
                        'lainnya.'.$value => 'required',
                    ]);
                }
            }
        }

        // memberi inputan default pihak1 
        $this->status[0] = 1; $alamatPihak1 = $this->alamat_pihak[0];
        $namaPihak1 = $this->nama_pihak[0]; $namaPejabat1 = $this->nama_pejabat_pihak[0];
        $jabatanPejabat1 = $this->jabatan_pejabat_pihak[0]??null; $pj1 = $this->pj_pihak[0];
        $jabatanPj1 = $this->jabatan_pj_pihak[0]??null; $emailPj1 = $this->email_pj_pihak[0]??null;
        $hpPj1 = $this->hp_pj_pihak[0]??null;

            DB::beginTransaction();
            try {
                $find = DataMou::find($this->idEdit);
                $find->update([
                    'nomor_dok_unhas' => $this->nomor_unhas,
                    'tanggal_ttd' => $this->tanggal_ttd, 'jenis_kerjasama' => $this->jenisKerjasamaField,
                    'negara' => $this->negara, 'region' => $this->region,
                    'tempat_pelaksanaan' => $this->tempat_pelaksanaan,
                    'status' => $this->status_kerjasama, 'tanggal_awal' => $this->tanggal_awal,
                    'tanggal_berakhir' => $this->tanggal_berakhir, 'jangka_waktu' => $this->jangka_waktu,
                    'level' => 2 , 'nomor_dok_mitra' => $this->nomor_mitra,
                    'judul' => $this->judul_kerjasama, 'fakultas_pihak' => $this->fakultas_pihak[0],
                    'deskripsi' => $this->deskripsi,
                    'nama_pihak' => $namaPihak1, 'alamat_pihak' => $alamatPihak1,
                    'nama_pejabat_pihak' => $namaPejabat1, 'jabatan_pejabat_pihak' => $jabatanPejabat1,
                    'pj_pihak' => $pj1, 'jabatan_pj_pihak' => $jabatanPj1,
                    'email_pj_pihak' => $emailPj1, 'hp_pj_pihak' => $hpPj1,
                    'edited_by' => auth()->user()->id,
                  ]);

                  $findMeTo = DataMouPenggiat::where('id_lapkerma',$this->idEdit)->delete();
                  foreach (range(0,$this->arrayJawaban) as $key => $value) {
                    $storePenggiatKerjasama = DataMouPenggiat::create([
                      'id_lapkerma' => $this->idEdit, 'pihak' => $value+1, 'status_pihak' => $this->status[$key],
                      'nama_pihak' => $this->nama_pihak[$key], 'fakultas_pihak' => $this->fakultas_pihak[$key]??'', 'alamat_pihak' => $this->alamat_pihak[$key],
                      'nama_pejabat_pihak' => $this->nama_pejabat_pihak[$key], 'jabatan_pejabat_pihak' => $this->jabatan_pejabat_pihak[$key]??'', 'pj_pihak' => $this->pj_pihak[$key],
                      'jabatan_pj_pihak' => $this->jabatan_pj_pihak[$key]??'', 'email_pj_pihak' => $this->email_pj_pihak[$key]??'', 'hp_pj_pihak' => $this->hp_pj_pihak[$key]??'',
                      'ptqs' => $this->ptqs[$key]??null, 'badan_kemitraan' => $this->badanKemitraan[$key]??'', 'uploaded_by' => auth()->user()->id,
                    ]);
                    if (optional($this->badanKemitraan)[$key] == 99) {
                        $storePenggiatKerjasama->update([
                            'badan_kemitraan' => $this->lainnya[$key]
                        ]);
                    }
                  }

                  $findKegiatan = DataMouBentukKegiatanKerjasama::where('id_mou',$this->idEdit)->delete();
                  foreach ($this->arrayBentukKegiatan as $key => $value) {
                    $storeBentukKegiatanKerjasama = DataMouBentukKegiatanKerjasama::create([
                        'id_mou' => $this->idEdit,
                        'nilai_kontrak' => $this->nilai_kontrak[$key]??null,
                        'volume_satuan' => $this->volume_satuan[$key]??null,
                        'volume_luaran' => $this->volume_luaran[$key]??null,
                        'keterangan' => $this->keterangan[$key]??null,
                        'id_ref_bentuk_kegiatan' => $value,
                        'id_ref_indikator_kinerja' => $this->arrayKinerja[$key],
                        'id_ref_sasaran_kegiatan' => $this->arraySasaran[$key],
                    ]);
                }

                if ($this->files)
                    {
                        $code = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        foreach ($this->files as $file) {
                        $random = substr(str_shuffle($code),0,3);
                        $namaDokumen = 'MoU'.$this->uuid.$random.'.'.$file->extension();
                        $file->storeAs('public/DokumenMoU',$namaDokumen);
                        $find->dokumenMoU()->firstOrCreate([
                            'url' => $namaDokumen,
                            'kerjasama_id' => $find->id
                        ]);
                        }
                    }
                    DB::commit();
                    $this->emit('alerts', ['pesan' => 'Data Berhasil Diupdate', 'icon'=>'success'] );
            } catch (ERROR $th) {
                DB::rollback();
                dd($th);
                $this->emit('alerts', ['pesan' => 'Invalid Proses, Gagal Diupdate', 'icon'=>'error'] );
            }
          

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

    public function takeArray()
    {
        $this->arrayJawaban = $this->arrayJawaban + 1;
        array_push($this->inputs ,$this->arrayJawaban);
    }

    public function minArrayPihak($i)
    {
        unset($this->inputs[$i]);
        $this->arrayJawaban--;
    } 

    public function minArrayBentuk($i)
    {
        unset($this->arrayBentukKegiatan[$i]);
    } 
    
    public function takeSuccess()
    {
      $this->showLoadFiles = true;
    }

    public function updatedBentukKegiatan()
    {
        if ($this->bentukKegiatan != 0) {
            array_push($this->arrayBentukKegiatan, $this->bentukKegiatan);
        }
        $this->reset('bentukKegiatan');
    }
}
