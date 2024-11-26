<?php

namespace App\Http\Livewire\Input;

use App\Models\Negara;

use App\Models\ReferensiBadanKemitraan;
use Livewire\Component;
use App\Models\LapkermaRefBentukKegiatan;
use App\Models\LapkermaRefSasaranKegiatan;
use App\Models\LapkermaRefIndikatorKinerja;
use App\Models\Fakultas;
use App\Models\JenisKerjasama;
use App\Models\StatusKerjasama;
use Livewire\WithFileUploads;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Mail\DocumentMail;
use App\Models\DataMou;
use App\Models\DataMouBentukKegiatanKerjasama;
use App\Models\DataMouPenggiat;
use App\Models\Instansi;
use App\Models\MouPenggiat;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Pejabat;
use App\Models\PenanggungJawab;
use App\Models\Region;

class GuestMouInput extends Component
{
    use WithFileUploads;

    // Kopian MoU;
    public $inputs = [0, 1, 2, 3, 4, 5, 6, 7, 8], $arrayJawaban = 1, $showLoadFiles, $idEdit, $findDokumen, $arrayNamaPenggiat = [], $upBy;
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
    public $showCountryInput = false;

    public $searchInstansiList = [], $searchPejabatList = [], $searchPenanggungJawab = [];
    public $idInstansi = [], $idPejabat = [], $idPJ = [];


    public $uploadDocument = false, $mou_document,  $logo, $newScopeItem, $scopeList = [
        "Research collaboration in the areas of mutual interest",
        "Exchange of academic materials which are made available by both parties",
        "Exchange of scholars",
        "Student mobility",
        "Cooperative seminars, workshops, and other academic activities"
    ];

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
    }

    public function selectInstansi($key, $id, $name, $address, $negara_id, $coordinates, $ptqs, $status, $badanKemitraan)
    {
        $this->nama_pihak[$key] = $name;
        $this->alamat_pihak[$key] = $address;
        $this->negara_pihak[$key] = $negara_id;
        $this->koordinat_pihak[$key] = $coordinates;
        $this->ptqs[$key] = ($ptqs == '1' || $ptqs == '2') ? intval($ptqs) : null;
        $this->status[$key] = $status;
        if (is_numeric($badanKemitraan)) {
            $intValue = (int) $badanKemitraan;
            if ($intValue >= 0 && $intValue <= 13) { // Check if within range
                $this->badanKemitraan[$key] = $intValue;
            } else {
                $this->badanKemitraan[$key] = 99;
            }
        } elseif ($badanKemitraan === null) { // Check for null explicitly
            $this->badanKemitraan[$key] = null;
        } else {
            $this->badanKemitraan[$key] = 99;
            $this->lainnya[$key] = $badanKemitraan; // Assign to 'lainnya' if not numeric or null
        }
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
        foreach (range(0, $this->arrayJawaban) as $value) {
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
        // $this->validate([
        //     'arrayBentukKegiatan' => 'required'
        // ]);
    }

    public function save()
    {
        $this->inputValidation();
        if ($this->getErrorBag()->isNotEmpty()) {
            $this->emit('formFailed', $this->getErrorBag()->all());
        }
        $uuid = DataMou::max('id');
        $uuid = str_pad($uuid + 1, 3, '0', STR_PAD_LEFT);
        $uuid = 'MoU-' . date('y') . $uuid;

        if ($this->nomorSistem) {
            $this->nomor_unhas =  $uuid;
        }
        foreach (range(0, $this->arrayJawaban) as $key) {
            $this->arrayNamaPenggiat[] = $this->nama_pihak[$key];
        }

        DB::beginTransaction();
        try {
            $store = DataMou::firstOrCreate([
                'nomor_dok_unhas' => $this->nomor_unhas,
            ], [
                'tanggal_ttd' => $this->tanggal_ttd,
                'jenis_kerjasama' => $this->jenisKerjasamaField,
                'negara' => $this->negara,
                'region' => $this->region,
                'uuid' => $uuid,
                'tempat_pelaksanaan' => $this->tempat_pelaksanaan,
                'status' => $this->status_kerjasama,
                'tanggal_awal' => $this->tanggal_awal,
                'tanggal_berakhir' => $this->tanggal_berakhir,
                'jangka_waktu' => $this->jangka_waktu,
                'level' => 0,
                'nomor_dok_mitra' => $this->nomor_mitra,
                'judul' => $this->judul_kerjasama,
                'fakultas_pihak' => $this->fakultas_pihak[0],
                'deskripsi' => $this->deskripsi,
                'nama_pihak' => $this->nama_pihak[0],
                'alamat_pihak' => $this->alamat_pihak[0],
                'nama_pejabat_pihak' => $this->nama_pejabat_pihak[0],
                'jabatan_pejabat_pihak' => $this->jabatan_pejabat_pihak[0],
                'pj_pihak' => $this->pj_pihak[0],
                'jabatan_pj_pihak' => $this->jabatan_pj_pihak[0],
                'email_pj_pihak' => $this->email_pj_pihak[0],
                'hp_pj_pihak' => $this->hp_pj_pihak[0],
                'penggiat' => json_encode($this->arrayNamaPenggiat),
                'uploaded_by' => auth()->user()->name,
            ]);

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

            if ($store->wasRecentlyCreated) {
                foreach (range(0, $this->arrayJawaban) as $key) {
                    $storePJ = PenanggungJawab::updateOrCreate(
                        [
                            'name' => $this->pj_pihak[$key],
                        ],
                        [
                            'designation' => $this->jabatan_pj_pihak[$key],
                            'email' => $this->email_pj_pihak[$key],
                            'phone_number' => $this->hp_pj_pihak[$key]
                        ]
                    );

                    $storePejabat = Pejabat::updateOrCreate(
                        [
                            'nama' => $this->nama_pejabat_pihak[$key],
                        ],
                        [
                            'jabatan' => $this->jabatan_pejabat_pihak[$key]
                        ]

                    );

                    $storeInstansi = Instansi::updateOrCreate(
                        [
                            'name' => $this->nama_pihak[$key],
                        ],
                        [
                            'address' => $this->alamat_pihak[$key],
                            'negara_id' => $this->negara_pihak[$key],
                            'coordinates' => $this->koordinat_pihak[$key] ?? '',
                            'ptqs' => $this->ptqs[$key] ?? 0,
                            'status' => $this->status[$key] ?? 0,
                            'badan_kemitraan' => $this->badanKemitraan[$key] ?? '',
                        ]
                    );
                    if (optional($this->badanKemitraan)[$key] == 99) {
                        $storeInstansi->update([
                            'badan_kemitraan' => $this->lainnya[$key]
                        ]);
                    }

                    $storePenggiatKerjasama2 = MouPenggiat::create(
                        [
                            'id_lapkerma' => $store->id,
                            'id_pihak' => $storeInstansi->id,
                            'pihak' => $this->nama_pihak[$key],
                            'id_pj' => $storePJ->id,
                            'id_pejabat' => $storePejabat->id,
                            'fakultas_pihak' => $this->fakultas_pihak[$key] ?? null,
                            'prodi' => '',
                        ]
                    );

                    $storePenggiatKerjasama = DataMouPenggiat::create([
                        'id_lapkerma' => $store->id,
                        'pihak' => $key + 1,
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
            }
            $code = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $random = substr(str_shuffle($code), 0, 3);
            if ($this->uploadDocument) {
                $templateProcessor = new TemplateProcessor(storage_path('document/Template_MOU.docx'));

                // Isi template MOU dengan data pihak 1
                $templateProcessor->setValue('University_Name', $this->nama_pihak[0]);
                $templateProcessor->setValue('Country_Of_Origin', Negara::find($this->negara)->name ?? 'Unknown Country');
                $templateProcessor->setValue('Signing_Date', date('d/m/Y', strtotime($this->tanggal_ttd)));
                $templateProcessor->setValue('Duration_Years', $this->jangka_waktu);

                // PIC Pihak 1
                $templateProcessor->setValue('PIC_Name', $this->pj_pihak[0]);
                $templateProcessor->setValue('PIC_Designation', $this->jabatan_pj_pihak[0]);
                $templateProcessor->setValue('PIC_Address', $this->alamat_pihak[0]);
                $templateProcessor->setValue('PIC_Email', $this->email_pj_pihak[0]);
                $templateProcessor->setValue('PIC_Phone', $this->hp_pj_pihak[0]);

                // Pejabat Pihak 1
                $templateProcessor->setValue('Rep_Name', $this->nama_pejabat_pihak[0]);
                $templateProcessor->setValue('Rep_Designation', $this->jabatan_pejabat_pihak[0]);

                // Scope Kerjasama
                $templateProcessor->setValue('Scope', '• ' . implode("\n• ", $this->scopeList));

                if (isset($this->logo)) {
                    $logoFilePath = $this->logo->store('public/logos');
                    $logoPath = storage_path('app/' . $logoFilePath);
                    if (file_exists($logoPath)) {
                        $validImageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                        $extension = pathinfo($logoPath, PATHINFO_EXTENSION);

                        if (in_array(strtolower($extension), $validImageExtensions)) {
                            $templateProcessor->setImageValue(
                                'Logo',
                                [
                                    'path' => $logoPath,
                                    'width' => 100, // Adjust width to fit template needs
                                    'height' => 100, // Adjust height as needed
                                    'ratio' => true, // Maintain aspect ratio
                                ]
                            );
                        }
                    }
                    // Hapus logo setelah digunakan
                    Storage::delete($logoFilePath);
                }

                // Simpan dokumen
                $namaDokumen = 'MoU_' . $uuid . '_' . substr(str_shuffle('1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3) . '.docx';
                $outputFile = storage_path('app/public/DokumenMoU/' . $namaDokumen);

                $templateProcessor->saveAs($outputFile);

                $store->dokumenMoU()->firstOrCreate([
                    'url' => $namaDokumen,
                    'kerjasama_id' => $store->id
                ]);

                Mail::to('kaizerd23@gmail.com')->send(new DocumentMail($outputFile, $this->nama_pihak[0]));
            } else {
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
                $outputFile = storage_path('app/public/DokumenMoU/' . $namaDokumen);

                Mail::to('kaizerd23@gmail.com')->send(new DocumentMail($outputFile, $this->nama_pihak[0]));
            }

            DB::commit();

            $this->emit('formSubmitted');
        } catch (\Exception $th) {
            DB::rollback();
            dd($th);
            $this->emit('alertz', ['pesan' => 'Invalid Proses, Gagal Ditambahkan', 'icon' => 'error']);
        }
    }


    public function addScope()
    {
        $this->validate([
            'newScopeItem' => 'required|string|max:255',
        ]);
        $this->scopeList[] = $this->newScopeItem;
        $this->newScopeItem = '';
    }

    public function removeScope($index)
    {
        unset($this->scopeList[$index]);
        $this->scopeList = array_values($this->scopeList);
    }

    public function mount()
    {
        // Ambil data dari database
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


        $instansiModel = new Instansi();
        $instansi = $instansiModel->where('id', '=', 1164)->first();
        $this->idInstansi[] = 1164;
        $this->nama_pihak[] = $instansi->name;
        $this->alamat_pihak[] = $instansi->address;
        $this->negara_pihak[] = $instansi->negara_id;
        $this->ptqs[] = 2;
        $this->badanKemitraan[] = $instansi->badan_kemitrann;
        $this->status[] = $instansi->status;
        $this->koordinat_pihak[] = $instansi->coordinates;

        $pejabatModel = new Pejabat();
        $pejabat = $pejabatModel->where('nama', '=', 'Prof. Dr. Ir. Jamaluddin Jompa, M.Sc.')->first();
        $this->idPejabat[] = $pejabat->id;
        $this->nama_pejabat_pihak[] = $pejabat->nama;
        $this->jabatan_pejabat_pihak[] = $pejabat->jabatan;

        $penanggugjawabModel = new PenanggungJawab();
        $penanggungjawab = $penanggugjawabModel->where('name', '=', 'Prof. Dr. Eng. Adi Maulana, S.T., M.Phil')->first();
        $this->idPJ[] = $penanggungjawab->id;
        $this->pj_pihak[] = $penanggungjawab->name;
        $this->jabatan_pj_pihak[] = $penanggungjawab->designation;
        $this->email_pj_pihak[] = $penanggungjawab->email;
        $this->hp_pj_pihak[] = $penanggungjawab->phone_number;
    }

    public function render()
    {
        return view('livewire.input.guest-mou-input', [
            'bentukKegiatan' => $this->arrayBentukKegiatan,
        ]);
    }
}
