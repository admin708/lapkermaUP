<?php

namespace App\Http\Livewire\Input;

use App\Models\DataMouDokumen;
use App\Models\DataMouPenggiat;
use App\Models\DataMou;
use App\Models\Negara;
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
use App\Mail\MoUAcceptedNotification;
use App\Models\Instansi;
use App\Models\MouPenggiat;
use App\Models\MouRequest;
use App\Models\MouRequestBentukKegiatanKerjasama;
use App\Models\MouRequestDokumen;
use App\Models\MouRequestPenggiat;
use App\Models\Pejabat;
use App\Models\PenanggungJawab;
use App\Models\ReferensiBadanKemitraan;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException as ERROR;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

use function PHPUnit\Framework\isEmpty;

class Mou extends Component
{
    use WithFileUploads;

    public $inputs = [0, 1, 2, 3, 4, 5, 6, 7, 8], $arrayJawaban = 1, $showLoadFiles, $idEdit, $findDokumen, $arrayNamaPenggiat, $upBy;
    public $fakultas = [], $statusKerjasama, $getSasaranKegiatan, $getIndikatorKinerja, $getBentukKegiatan, $bentukKegiatan;

    public $nama_pihak = [], $status, $fakultas_pihak = [], $alamat_pihak = [], $koordinat_pihak = [], $negara_pihak = [];
    public $nama_pejabat_pihak = [], $jabatan_pejabat_pihak = [], $pj_pihak = [], $jabatan_pj_pihak = [];
    public $email_pj_pihak = [], $hp_pj_pihak = [], $files = [], $badanKemitraan = [], $lainnya = [], $ptqs = [];
    public $regionKerjasama, $jenisKerjasama, $nomorSistem, $nomorSistem2;

    public $arrayBentukKegiatan = [], $arraySasaran = [], $arrayKinerja = [], $keterangan, $volume_luaran, $volume_satuan, $nilai_kontrak;

    public $jenisKerjasamaField, $region, $negara, $tempat_pelaksanaan, $negaraKerjasama;

    public $nomor_unhas, $nomor_mitra, $judul_kerjasama, $deskripsi;

    public $tanggal_ttd, $tanggal_awal, $tanggal_berakhir, $status_kerjasama, $jangka_waktu;
    public $badanKemitraanOptions;

    //Section MoU Request
    public $MouRequestId;
    public $searchInstansiList = [], $searchPejabatList = [], $searchPenanggungJawab = [];
    public $idInstansi = [], $idPejabat = [], $idPJ = [];

    protected $listeners = [
        'successMe' => 'takeSuccess',
        'updateData' => 'saveEdit',
        'errorMe' => 'takeError',
        'getEditData' => 'showEditData',
        'guestInputData' => 'showGuestInputData'
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
        $this->negaraKerjasama = Negara::get();
        $this->jenisKerjasamaField = 1;
        $this->updatedJenisKerjasamaField();
        $this->badanKemitraanOptions = ReferensiBadanKemitraan::whereNotIn('id', [10, 11])->get();
    }


    public function render()
    {
        return view('livewire.input.mou');
    }

    public function showEditData($id)
    {
        $this->idEdit = $id;
        $this->setDataMoU($id);
        $findMeTo = MouPenggiat::where('id_lapkerma', $id)->get();
        $this->arrayJawaban = $findMeTo->count('id');
        $this->inputs = [];

        foreach ($findMeTo as $key => $value) {
            array_push($this->inputs, $key);
            $this->setInstansi($findMeTo, $key);
            $this->setPejabat($findMeTo, $key);
            $this->setPJ($findMeTo, $key);

            if ($value->status_pihak == 3) {
                if (is_int($value->badan_kemitraan)) {
                    $this->badanKemitraan[$key] = $value->badan_kemitraan;
                } else {
                    $this->badanKemitraan[$key] = 99;
                    $this->lainnya[$key] = $value->badan_kemitraan;
                }
            }
        }
        $this->findDokumen = DataMouDokumen::where('kerjasama_id', $id)->get();

        $findKegiatan = DataMouBentukKegiatanKerjasama::where('id_mou', $id)->get();
        $this->arrayBentukKegiatan = [];
        foreach ($findKegiatan as $key => $value) {
            array_push($this->arrayBentukKegiatan, $value->id_ref_bentuk_kegiatan);
            $this->nilai_kontrak[$key] = $value->nilai_kontrak;
            $this->volume_satuan[$key] = $value->volume_satuan;
            $this->volume_luaran[$key] = $value->volume_luaran;
            $this->keterangan[$key] = $value->keterangan;
            $this->arrayKinerja[$key] = $value->id_ref_indikator_kinerja;
            $this->arraySasaran[$key] = $value->id_ref_sasaran_kegiatan;
        }
    }

    public function setDataMoU($id)
    {
        $findMe = DataMou::find($id);

        // $this->uuid = $findMe->uuid;
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
        $this->upBy = $findMe->uploaded_by;
    }

    public function setInstansi($findMeTo, $key)
    {
        $instansi = Instansi::where('id', '=', $findMeTo[$key]->id_pihak)->first();
        if ($instansi) {
            $this->status[$key] = $instansi->status ?? null;
            $this->nama_pihak[$key] = $instansi->name ?? null;
            $this->alamat_pihak[$key] = $instansi->address ?? null;
            $this->koordinat_pihak[$key] = $instansi->coordinates ?? null;
            $this->fakultas_pihak[$key] = $findMeTo[$key]['fakultas_pihak'] ?? 1000;
            $this->ptqs[$key] = $instansi->ptqs ?? 0;
            $this->badanKemitraan[$key] = $instansi->badan_kemitraan ?? 1;
            $this->negara_pihak[$key] = $instansi->negara_id ?? 103;
        }
    }

    public function setPejabat($findMeTo, $key)
    {
        $pejabat = Pejabat::where('id', '=', $findMeTo[$key]->id_pejabat)->first();
        if ($pejabat) {
            $this->nama_pejabat_pihak[$key] = $pejabat->nama ?? '';
            $this->jabatan_pejabat_pihak[$key] = $pejabat->jabatan ?? '';
        }
    }

    public function setPJ($findMeTo, $key)
    {
        $pj = PenanggungJawab::where('id', '=', $findMeTo[$key]->id_pj)->first();
        if ($pj) {
            $this->pj_pihak[$key] = $pj->name;
            $this->jabatan_pj_pihak[$key] = $pj->designation ?? '';
            $this->email_pj_pihak[$key] = $pj->email ?? '';
            $this->hp_pj_pihak[$key] = $pj->phone_number ?? '';
        }
    }

    public function saveEdit($id)
    {
        $this->inputValidation();

        $this->arrayNamaPenggiat = [];
        $hitung = 0;
        $indexUnhas = 0;
        foreach (range(0, $this->arrayJawaban - 1) as $key => $value) {

            if ($this->nama_pihak[$key] == 'Universitas Hasanuddin') {
                $hitung++;
                $indexUnhas = $key;
            }
            array_push($this->arrayNamaPenggiat, $this->nama_pihak[$key]);
            // $namanama = Str::lower($this->nama_pihak[$key]);
            // if ($namanama == 'unhas' || $namanama == 'universitas hasanuddin') {
            //     array_push($this->arrayNamaPenggiat, 'Universitas Hasanuddin');
            // } else {
            //     array_push($this->arrayNamaPenggiat, $this->nama_pihak[$key]);
            // }
            // switch ($namanama) {
            //     case 'unhas':
            //         $status = $this->status[$key];
            //         $alamatPihak1 = $this->alamat_pihak[$key];
            //         $namaPihak1 = 'Universitas Hasanuddin';
            //         $namaPejabat1 = $this->nama_pejabat_pihak[$key];
            //         $jabatanPejabat1 = $this->jabatan_pejabat_pihak[$key] ?? null;
            //         $pj1 = $this->pj_pihak[$key];
            //         $jabatanPj1 = $this->jabatan_pj_pihak[$key] ?? null;
            //         $emailPj1 = $this->email_pj_pihak[$key];
            //         $fakultas_pihak = $this->fakultas_pihak[$key];
            //         $hpPj1 = $this->hp_pj_pihak[$key];
            //         $hitung++;
            //         break;
            //     case 'universitas hasanuddin':
            //         $status = $this->status[$key];
            //         $alamatPihak1 = $this->alamat_pihak[$key];
            //         $koordinatPihak1 = $this->koordinat_pihak[$key];
            //         $namaPihak1 = 'Universitas Hasanuddin';
            //         $namaPejabat1 = $this->nama_pejabat_pihak[$key];
            //         $jabatanPejabat1 = $this->jabatan_pejabat_pihak[$key] ?? null;
            //         $pj1 = $this->pj_pihak[$key];
            //         $jabatanPj1 = $this->jabatan_pj_pihak[$key] ?? null;
            //         $emailPj1 = $this->email_pj_pihak[$key];
            //         $fakultas_pihak = $this->fakultas_pihak[$key];
            //         $hpPj1 = $this->hp_pj_pihak[$key];
            //         $hitung++;

            //         break;
            //     default:
            //         break;
            // }
        }

        if ($hitung == 0) {
            $this->emit('alerts', ['pesan' => 'Gagal ditambahkan, Unhas tidak disertakan dalam penggiat kerjasama', 'icon' => 'error']);
        } else {
            DB::beginTransaction();
            try {
                $find = DataMou::find($id);
                $find->update([
                    'nomor_dok_unhas' => $this->nomor_unhas,
                    'tanggal_ttd' => $this->tanggal_ttd,
                    'jenis_kerjasama' => $this->jenisKerjasamaField,
                    'negara' => $this->negara,
                    'region' => $this->region,
                    'tempat_pelaksanaan' => $this->tempat_pelaksanaan,
                    'status' => $this->status_kerjasama,
                    'tanggal_awal' => $this->tanggal_awal,
                    'tanggal_berakhir' => $this->tanggal_berakhir,
                    'jangka_waktu' => $this->jangka_waktu,
                    'level' => 1,
                    'nomor_dok_mitra' => $this->nomor_mitra,
                    'judul' => $this->judul_kerjasama,
                    'fakultas_pihak' => $this->fakultas_pihak[$indexUnhas],
                    'deskripsi' => $this->deskripsi,
                    'nama_pihak' => $this->nama_pihak[$indexUnhas],
                    'alamat_pihak' => $this->alamat_pihak[$indexUnhas],
                    'nama_pejabat_pihak' => $this->nama_pejabat_pihak[$indexUnhas],
                    'jabatan_pejabat_pihak' => $this->jabatan_pejabat_pihak[$indexUnhas],
                    'pj_pihak' => $this->pj_pihak[$indexUnhas],
                    'jabatan_pj_pihak' => $this->jabatan_pj_pihak[$indexUnhas],
                    'email_pj_pihak' => $this->email_pj_pihak[$indexUnhas],
                    'hp_pj_pihak' => $this->hp_pj_pihak[$indexUnhas],
                    'penggiat' => json_encode($this->arrayNamaPenggiat),
                    'uploaded_by' => auth()->user()->name,
                ]);

                if ($this->files) {
                    $uuid = DataMou::max('id');
                    $uuid = str_pad($uuid + 1, 3, '0', STR_PAD_LEFT);
                    $uuid = date('y') . $uuid;

                    $code = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    foreach ($this->files as $file) {
                        $random = substr(str_shuffle($code), 0, 3);
                        $namaDokumen = 'MoU' . $uuid . $random . '.' . $file->extension();
                        $file->storeAs('public/DokumenMoU', $namaDokumen);
                        $find->dokumenMoU()->firstOrCreate([
                            'url' => $namaDokumen,
                            'kerjasama_id' => $id
                        ]);
                    }
                }


                foreach (range(0, $this->arrayJawaban - 1) as $key => $value) {
                    $storePJ = PenanggungJawab::updateOrCreate(
                        [
                            'name' => $this->pj_pihak[$value] ?? null,
                        ],
                        [
                            'designation' => $this->jabatan_pj_pihak[$value],
                            'email' => $this->email_pj_pihak[$value],
                            'phone_number' => $this->hp_pj_pihak[$value]
                        ]
                    );

                    $storePejabat = Pejabat::updateOrCreate(
                        [
                            'nama' => $this->nama_pejabat_pihak[$value] ?? null,
                        ],
                        [
                            'jabatan' => $this->jabatan_pejabat_pihak[$value]
                        ]

                    );

                    $storeInstansi = Instansi::updateOrCreate(
                        [
                            'name' => $this->nama_pihak[$value] ?? null,
                        ],
                        [

                            'address' => $this->alamat_pihak[$value],
                            'negara_id' => $this->negara_pihak[$value],
                            'coordinates' => $this->koordinat_pihak[$value],
                            'ptqs' => $this->ptqs[$value] ?? 0,
                            'status' => $this->status[$value],
                            'badan_kemitraan' => $this->badanKemitraan[$value]
                        ]
                    );
                    if (optional($this->badanKemitraan)[$value] == 99) {
                        $storeInstansi->update([
                            'badan_kemitraan' => $this->lainnya[$value]
                        ]);
                    }

                    $storePenggiat = MouPenggiat::updateOrCreate(
                        [
                            'id_lapkerma' => $id, // Reference the related ID
                            'id_pihak' => $storeInstansi->id,
                        ],
                        [
                            'pihak' => $this->nama_pihak[$value],
                            'id_pj' => $storePJ->id,
                            'id_pejabat' => $storePejabat->id,
                            'fakultas_pihak' => $this->fakultas_pihak[$value] ?? '',
                            'prodi' => '', // Update this field as needed
                        ]
                    );

                    $storePenggiatKerjasama = DataMouPenggiat::updateOrCreate([
                        'id_lapkerma' => $id,
                        'nama_pihak' => $this->arrayNamaPenggiat[$key],
                    ], [
                        'pihak' => $value + 1,
                        'status_pihak' => $this->status[$key],
                        'fakultas_pihak' => $this->fakultas_pihak[$key] ?? '',
                        'alamat_pihak' => $this->alamat_pihak[$key],
                        'nama_pejabat_pihak' => $this->nama_pejabat_pihak[$key],
                        'jabatan_pejabat_pihak' => $this->jabatan_pejabat_pihak[$key] ?? '',
                        'pj_pihak' => $this->pj_pihak[$key],
                        'jabatan_pj_pihak' => $this->jabatan_pj_pihak[$key] ?? '',
                        'email_pj_pihak' => $this->email_pj_pihak[$key] ?? '',
                        'hp_pj_pihak' => $this->hp_pj_pihak[$key] ?? '',
                        'ptqs' => $this->ptqs[$key] ?? null,
                        'badan_kemitraan' => $this->badanKemitraan[$key] ?? '',
                        'uploaded_by' => auth()->user()->name,
                    ]);
                    if (optional($this->badanKemitraan)[$key] == 99) {
                        $storePenggiatKerjasama->update([
                            'badan_kemitraan' => $this->lainnya[$key]
                        ]);
                    }
                }

                foreach ($this->arrayBentukKegiatan as $key => $value) {
                    $storeBentukKegiatanKerjasama = DataMouBentukKegiatanKerjasama::create([
                        'id_mou' => $id,
                        'nilai_kontrak' => $this->nilai_kontrak[$key] ?? null,
                        'volume_satuan' => $this->volume_satuan[$key] ?? null,
                        'volume_luaran' => $this->volume_luaran[$key] ?? null,
                        'keterangan' => $this->keterangan[$key] ?? null,
                        'id_ref_bentuk_kegiatan' => $value,
                        'id_ref_indikator_kinerja' => $this->arrayKinerja[$key] ?? null,
                        'id_ref_sasaran_kegiatan' => $this->arraySasaran[$key] ?? null,
                    ]);
                }
                DB::commit();
                $this->emit('alerts', ['pesan' => 'Data Berhasil Diupdate', 'icon' => 'success']);
            } catch (ERROR $th) {
                dd($th);
                DB::rollback();
                $this->emit('alerts', ['pesan' => 'Invalid Proses, Gagal Diupdate', 'icon' => 'error']);
            }
        }
    }

    public function updatedJenisKerjasamaField()
    {
        if ($this->jenisKerjasamaField == 1) {
            $this->region = 1;
            $this->negara = 'Indonesia';
        } else {
            $this->reset('region', 'negara');
        }
    }

    public function updatedNomorSistem()
    {
        $this->reset('nomor_unhas');
    }

    public function takeArray()
    {
        if ($this->arrayJawaban < 8) {
            $this->arrayJawaban++;
        }
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

    public function updatedNamaPihak($value, $key)
    {
        if (!empty($this->nama_pihak[$key])) {
            $modelInstansis = new Instansi();
            $result = $modelInstansis->getInstansis($value);
            $this->searchInstansiList[$key] = $result;
        } else {
            $this->searchInstansiList[$key] = [];
        }
        $this->idInstansi[$key] = null;
    }

    public function selectInstansi($key, $id, $name, $address, $negara_id, $coordinates, $ptqs, $status, $badanKemitraan)
    {
        $this->nama_pihak[$key] = $name;
        $this->alamat_pihak[$key] = $address;
        $this->negara_pihak[$key] = $negara_id;
        $this->koordinat_pihak[$key] = $coordinates;
        $this->ptqs[$key] = $ptqs;
        $this->status[$key] = $status;
        $this->badanKemitraan[$key] = $badanKemitraan;
        $this->idInstansi[$key] = $id;
        $this->searchInstansiList[$key] = [];
    }

    public function updatedNamaPejabatPihak($value, $key)
    {
        if (!empty($this->nama_pejabat_pihak[$key])) {
            $modelPejabat = new Pejabat();
            $result = $modelPejabat->getPejabat(($value));
            $this->searchPejabatList[$key] = $result;
        } else {
            $this->searchPejabatList[$key] = [];
        }
        $this->idPejabat[$key] = null;
    }

    public function updatePejabatPihak($key, $id, $name, $designation)
    {
        $this->nama_pejabat_pihak[$key] = $name;
        $this->jabatan_pejabat_pihak[$key] = $designation;
        $this->idPejabat[$key] = $id;
        $this->searchPejabatList[$key] = [];
    }

    public function updatedPjPihak($value, $key)
    {
        if (!empty($this->pj_pihak[$key])) {
            $pjModel = new PenanggungJawab();
            $result = $pjModel->getPj($value);
            $this->searchPenanggungJawab[$key] = $result;
        } else {
            $this->searchPenanggungJawab[$key] = [];
        }
        $this->idPJ[$key] = null;
    }

    public function setPJData($key, $id, $name, $designation, $phoneNumber, $email)
    {
        $this->pj_pihak[$key] = $name;
        $this->jabatan_pj_pihak[$key] = $designation;
        $this->hp_pj_pihak[$key] = $phoneNumber;
        $this->email_pj_pihak[$key] = $email;
        $this->idPJ[$key] = $id;
        $this->searchPenanggungJawab = [];
    }

    public function updatedBentukKegiatan()
    {
        if ($this->bentukKegiatan != 0) {
            array_push($this->arrayBentukKegiatan, $this->bentukKegiatan);
        }
        $this->reset('bentukKegiatan');
    }

    public function inputValidation()
    {
        if ($this->nomorSistem == 1) {
            $this->nomor_unhas = 'mou-uh';
        }

        $this->validate([
            'tempat_pelaksanaan' => 'required',
            'judul_kerjasama' => 'required',
            'deskripsi' => 'required',
            'tanggal_ttd' => 'required',
            'tanggal_awal' => 'required',
            'tanggal_berakhir' => 'required',
            'status_kerjasama' => 'required',
            'jangka_waktu' => 'required',
        ]);

        if ($this->jenisKerjasamaField == '1') {
            $this->validate([
                'nomor_unhas' => 'required',
                'nomor_mitra' => 'required',
            ]);
        }


        if ($this->jenisKerjasamaField == '2') {
            $this->validate([
                'region' => 'required',
                'negara' => 'required',
            ]);
            if ($this->nomorSistem != 1) {
                $this->validate([
                    'nomor_unhas' => 'required',
                ]);
            }
        }


        if ($this->idEdit == null) {
            if ($this->uploadDocument) {
                $this->validate([
                    'logo' => 'required',
                    'scopeList' => 'required'
                ]);
            } else {
                $this->validate([
                    'files' => 'required'
                ]);
            }
        }

        foreach (range(0, $this->arrayJawaban - 1) as $value) {
            $this->validate([
                "status.$value" => 'required',
            ]);

            $commonRules = [
                "nama_pihak.$value" => 'required',
                "alamat_pihak.$value" => 'required',
                "negara_pihak.$value" => 'required',
                "koordinat_pihak.$value" => 'required',
                "nama_pejabat_pihak.$value" => 'required',
                "jabatan_pejabat_pihak.$value" => 'required',
                "pj_pihak.$value" => 'required',
                "jabatan_pj_pihak.$value" => 'required',
                "email_pj_pihak.$value" => 'required',
                "hp_pj_pihak.$value" => 'required',
            ];

            switch ($this->status[$value]) {
                case 1:
                    // Additional rules for status = 1
                    $this->validate(array_merge($commonRules, [
                        "ptqs.$value" => 'required',
                        "fakultas_pihak.$value" => 'required',
                    ]));

                    break;

                case 2:
                    // Specific to status = 2
                    $this->validate(array_merge($commonRules, [
                        "fakultas_pihak.$value" => 'required',
                    ]));

                    break;

                case 3:
                    // Additional rules for status = 3
                    $rules = array_merge($commonRules, [
                        "badanKemitraan.$value" => 'required',
                    ]);

                    $this->validate($rules);

                    // Handle the special case for badanKemitraan = 99
                    if ($this->badanKemitraan[$value] == 99) {
                        $rules["lainnya.$value"] = 'required';
                    }

                    $this->validate($rules);

                    break;

                case 4:
                    // Additional rules for status = 4
                    $this->validate(array_merge($commonRules, [
                        "ptqs.$value" => 'required',
                        "fakultas_pihak.$value" => 'required',
                    ]));

                    break;

                default:
                    break;
            }
        }

        $this->validate([
            'arrayBentukKegiatan' => 'required'
        ]);
    }
    public function validasiSave()
    {
        if ($this->nomorSistem == 1) {
            $this->nomor_unhas = 'mou-uh';
        }

        if ($this->jenisKerjasamaField == 2) {
            $this->validate([
                'region' => 'required',
                'negara' => 'required',
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
            ]);
        } else {
            $this->validate([
                'tempat_pelaksanaan' => 'required',
                'files' => 'required',
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
        foreach (array_keys($this->status) as $key) {
            $this->validate([
                "status.$key" => 'required',
            ]);


            if ($this->status[$key] == 1) {
                $this->validate([
                    "nama_pihak.$key" => 'required',
                    "ptqs.$key" => 'required',
                    "fakultas_pihak.$key" => 'required',
                    "alamat_pihak.$key" => 'required',
                    "koordinat_pihak.$key" => 'required',
                    "negara_pihak.$key" => 'required',
                    "nama_pejabat_pihak.$key" => 'required',
                ]);
            } elseif ($this->status[$key] == 4) {
                $this->validate([
                    "nama_pihak.$key" => 'required',
                    "ptqs.$key" => 'required',
                    "fakultas_pihak.$key" => 'required',
                    "alamat_pihak.$key" => 'required',
                    "koordinat_pihak.$key" => 'required',
                    "negara_pihak.$key" => 'required',
                    "nama_pejabat_pihak.$key" => 'required',
                ]);
            } elseif ($this->status[$key] == 2) {
                $this->validate([
                    "nama_pihak.$key" => 'required',
                    "fakultas_pihak.$key" => 'required',
                    "alamat_pihak.$key" => 'required',
                    "koordinat_pihak.$key" => 'required',
                    "negara_pihak.$key" => 'required',
                    "nama_pejabat_pihak.$key" => 'required',
                ]);
            } elseif ($this->status[$key] == 3) {
                $this->validate([
                    "nama_pihak.$key" => 'required',
                    "badanKemitraan.$key" => 'required',
                ]);

                if (isset($this->badanKemitraan[$key]) && $this->badanKemitraan[$key] == 99) {
                    $this->validate([
                        "lainnya.$key" => 'required',
                        "nama_pihak.$key" => 'required',
                        "badanKemitraan.$key" => 'required',
                        "alamat_pihak.$key" => 'required',
                        "koordinat_pihak.$key" => 'required',
                        "negara_pihak.$key" => 'required',
                        "nama_pejabat_pihak.$key" => 'required',
                    ]);
                } else {
                    $this->validate([
                        "nama_pihak.$key" => 'required',
                        "badanKemitraan.$key" => 'required',
                        "alamat_pihak.$key" => 'required',
                        "koordinat_pihak.$key" => 'required',
                        "negara_pihak.$key" => 'required',
                        "nama_pejabat_pihak.$key" => 'required',
                    ]);
                }
            }
        }

        $this->validate([
            'arrayBentukKegiatan' => 'required'
        ]);
    }

    public function save()
    {
        $this->inputValidation();
        $uuid = DataMou::max('id');
        $uuid = str_pad($uuid + 1, 3, '0', STR_PAD_LEFT);
        $uuid = 'MoU-' . date('y') . $uuid;

        if ($this->nomorSistem) {
            $this->nomor_unhas = $uuid;
        }

        $this->arrayNamaPenggiat = [];
        $hitung = 0;
        $indexUnhas = 0;
        foreach (array_keys($this->status) as $key => $value) {

            if ($this->nama_pihak[$key] == 'Universitas Hasanuddin') {
                $hitung++;
                $indexUnhas = $key;
            }
            array_push($this->arrayNamaPenggiat, $this->nama_pihak[$key]);

            //     $namanama = Str::lower($this->nama_pihak[$key]);
            //     if ($namanama == 'unhas' || $namanama == 'universitas hasanuddin') {
            //         array_push($this->arrayNamaPenggiat, 'Universitas Hasanuddin');
            //     } else {
            //         array_push($this->arrayNamaPenggiat, $this->nama_pihak[$key]);
            //     }
            //     switch ($namanama) {
            //         case 'unhas':
            //             $status = $this->status[$key];
            //             $alamatPihak1 = $this->alamat_pihak[$key];
            //             $koordinatPihak1 = $this->koordinat_pihak[$key];
            //             $namaPihak1 = 'Universitas Hasanuddin';
            //             $namaPejabat1 = $this->nama_pejabat_pihak[$key];
            //             $jabatanPejabat1 = $this->jabatan_pejabat_pihak[$key] ?? null;
            //             $pj1 = $this->pj_pihak[$key] ?? null;
            //             $jabatanPj1 = $this->jabatan_pj_pihak[$key] ?? null;
            //             $emailPj1 = $this->email_pj_pihak[$key] ?? null;
            //             $fakultas_pihak = $this->fakultas_pihak[$key];
            //             $hpPj1 = $this->hp_pj_pihak[$key] ?? null;
            //             $hitung++;
            //             break;
            //         case 'universitas hasanuddin':
            //             $status = $this->status[$key];
            //             $alamatPihak1 = $this->alamat_pihak[$key];
            //             $koordinatPihak1 = $this->koordinat_pihak[$key];
            //             $namaPihak1 = 'Universitas Hasanuddin';
            //             $namaPejabat1 = $this->nama_pejabat_pihak[$key];
            //             $jabatanPejabat1 = $this->jabatan_pejabat_pihak[$key] ?? null;
            //             $pj1 = $this->pj_pihak[$key] ?? null;
            //             $jabatanPj1 = $this->jabatan_pj_pihak[$key] ?? null;
            //             $emailPj1 = $this->email_pj_pihak[$key] ?? null;
            //             $fakultas_pihak = $this->fakultas_pihak[$key];
            //             $hpPj1 = $this->hp_pj_pihak[$key] ?? null;
            //             $hitung++;

            //             break;
            //         default:
            //             break;
            //     }
            // }

        }
        if ($hitung == 0) {
            $this->emit('alertz', ['pesan' => 'Gagal ditambahkan, Unhas tidak disertakan dalam penggiat kerjasama', 'icon' => 'error']);
        } else {
            if ($this->files) {
                DB::beginTransaction();

                try {
                    $store = DataMou::firstOrCreate([
                        'nomor_dok_unhas' => $this->nomor_unhas,
                    ], [
                        'uuid' => $uuid,
                        'tanggal_ttd' => $this->tanggal_ttd,
                        'jenis_kerjasama' => $this->jenisKerjasamaField,
                        'negara' => $this->negara,
                        'region' => $this->region,
                        'tempat_pelaksanaan' => $this->tempat_pelaksanaan,
                        'status' => $this->status_kerjasama,
                        'tanggal_awal' => $this->tanggal_awal,
                        'tanggal_berakhir' => $this->tanggal_berakhir,
                        'jangka_waktu' => $this->jangka_waktu,
                        'level' => 1,
                        'nomor_dok_mitra' => $this->nomor_mitra,
                        'judul' => $this->judul_kerjasama,
                        'fakultas_pihak' => $this->fakultas_pihak[$indexUnhas],
                        'deskripsi' => $this->deskripsi,
                        'nama_pihak' => $this->nama_pihak[$indexUnhas],
                        'alamat_pihak' => $this->alamat_pihak[$indexUnhas],
                        'nama_pejabat_pihak' => $this->nama_pejabat_pihak[$indexUnhas],
                        'jabatan_pejabat_pihak' => $this->jabatan_pejabat_pihak[$indexUnhas],
                        'pj_pihak' => $this->pj_pihak[$indexUnhas],
                        'jabatan_pj_pihak' => $this->jabatan_pj_pihak[$indexUnhas],
                        'email_pj_pihak' => $this->email_pj_pihak[$indexUnhas],
                        'hp_pj_pihak' => $this->hp_pj_pihak[$indexUnhas],
                        'penggiat' => json_encode($this->arrayNamaPenggiat),
                        'uploaded_by' => auth()->user()->name,
                    ]);



                    if ($store->wasRecentlyCreated) {
                        $code = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        foreach ($this->files as $file) {
                            $random = substr(str_shuffle($code), 0, 3);
                            $namaDokumen = 'MoU' . $uuid . $random . '.' . $file->extension();
                            $file->storeAs('public/DokumenMoU', $namaDokumen);
                            $store->dokumenMoU()->firstOrCreate([
                                'url' => $namaDokumen,
                                'kerjasama_id' => $store->id
                            ]);
                        }


                        foreach (range(0, $this->arrayJawaban) as $key => $value) {

                            $storePJ = PenanggungJawab::updateOrCreate(
                                [
                                    'name' => $this->pj_pihak[$value] ?? null,
                                ],
                                [
                                    'designation' => $this->jabatan_pj_pihak[$value],
                                    'email' => $this->email_pj_pihak[$value],
                                    'phone_number' => $this->hp_pj_pihak[$value]
                                ]
                            );

                            $storePejabat = Pejabat::updateOrCreate(
                                [
                                    'nama' => $this->nama_pejabat_pihak[$value] ?? null,
                                ],
                                [
                                    'jabatan' => $this->jabatan_pejabat_pihak[$value]
                                ]

                            );

                            $storeInstansi = Instansi::updateOrCreate(
                                [
                                    'name' => $this->nama_pihak[$value] ?? null,
                                ],
                                [

                                    'address' => $this->alamat_pihak[$value],
                                    'negara_id' => $this->negara_pihak[$value],
                                    'coordinates' => $this->koordinat_pihak[$value],
                                    'ptqs' => $this->ptqs[$value] ?? 0,
                                    'status' => $this->status[$value],
                                    'badan_kemitraan' => $this->badanKemitraan[$value]
                                ]
                            );
                            if (optional($this->badanKemitraan)[$value] == 99) {
                                $storeInstansi->update([
                                    'badan_kemitraan' => $this->lainnya[$value]
                                ]);
                            }

                            $storePenggiatKerjasama2 = MouPenggiat::create(
                                [
                                    'id_lapkerma' => $store->id,
                                    'id_pihak' => $storeInstansi->id,
                                    'pihak' => $this->nama_pihak[$value],
                                    'id_pj' => $storePJ->id,
                                    'id_pejabat' => $storePejabat->id,
                                    'fakultas_pihak' => $this->fakultas_pihak[$value] ?? '',
                                    'prodi' => '',
                                ]
                            );
                            $storePenggiatKerjasama = DataMouPenggiat::create([
                                'id_lapkerma' => $store->id,
                                'pihak' => $value + 1,
                                'status_pihak' => $this->status[$key],
                                'nama_pihak' => $this->arrayNamaPenggiat[$key],
                                'fakultas_pihak' => $this->fakultas_pihak[$key] ?? '',
                                'alamat_pihak' => $this->alamat_pihak[$key],
                                'nama_pejabat_pihak' => $this->nama_pejabat_pihak[$key],
                                'jabatan_pejabat_pihak' => $this->jabatan_pejabat_pihak[$key] ?? '',
                                'pj_pihak' => $this->pj_pihak[$key],
                                'jabatan_pj_pihak' => $this->jabatan_pj_pihak[$key] ?? '',
                                'email_pj_pihak' => $this->email_pj_pihak[$key] ?? '',
                                'hp_pj_pihak' => $this->hp_pj_pihak[$key] ?? '',
                                'ptqs' => $this->ptqs[$key] ?? null,
                                'badan_kemitraan' => $this->badanKemitraan[$key] ?? '',
                                'uploaded_by' => auth()->user()->name,
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
                                'nilai_kontrak' => $this->nilai_kontrak[$key] ?? null,
                                'volume_satuan' => $this->volume_satuan[$key] ?? null,
                                'volume_luaran' => $this->volume_luaran[$key] ?? null,
                                'keterangan' => $this->keterangan[$key] ?? null,
                                'id_ref_bentuk_kegiatan' => $value,
                                'id_ref_indikator_kinerja' => $this->arrayKinerja[$key] ?? null,
                                'id_ref_sasaran_kegiatan' => $this->arraySasaran[$key] ?? null,
                            ]);
                        }
                        DB::commit();
                        $this->emit('alerts', ['pesan' => 'Data Berhasil Ditambahkan', 'icon' => 'success']);
                        Mail::to($this->email_pj_pihak[1])->send(new MoUAcceptedNotification($this->pj_pihak[1]));
                    } else {
                        $this->emit('alerts', ['pesan' => 'Invalid Proses, Data Duplikat', 'icon' => 'error']);
                    }
                } catch (ERROR $th) {
                    DB::rollback();
                    dd($th);
                    $this->emit('alerts', ['pesan' => 'Invalid Proses, Gagal Ditambahkan', 'icon' => 'error']);
                }
            } else {
                $this->emit('alerts', ['pesan' => 'Tidak Ada File Pendukung, Data Gagal Ditambahkan', 'icon' => 'error']);
            }
        }
    }
}
