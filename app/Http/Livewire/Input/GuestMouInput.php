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
            $this->negara = 103;
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

    public function validasiSave()
    {
        if ($this->nomorSistem == 1) {
            $this->nomor_unhas = 'mou-uh';
        }

        if ($this->uploadDocument) {
            if (empty($this->scopeList)) {
                $this->addError('newScopeItem', 'The scope list cannot be empty. Please add at least one item.');
                return;
            }
            $this->validate([
                'logo' => 'required|image|mimes:png|max:2048',
            ]);
        } else {
            $this->validate([
                'files' => 'required'
            ]);
        }

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
        } else {

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

        // validate penggiat kerjasama
        foreach (range(0, $this->arrayJawaban) as $key => $value) {
            $this->validate([
                'status.' . $value => 'required',
            ]);
            if ($this->status[$value] == 1) {

                $this->validate([
                    'nama_pihak.' . $value => 'required',
                    'ptqs.' . $value => 'required',
                    'fakultas_pihak.' . $value => 'required',
                    'alamat_pihak.' . $value => 'required',
                    'nama_pejabat_pihak.' . $value => 'required',

                ]);
            }
            if ($this->status[$value] == 4) {

                $this->validate([
                    'nama_pihak.' . $value => 'required',
                    'ptqs.' . $value => 'required',
                    'fakultas_pihak.' . $value => 'required',
                    //   'arrayProdi.'.$value => 'required',
                    'alamat_pihak.' . $value => 'required',
                    'nama_pejabat_pihak.' . $value => 'required',

                ]);
            }
            if ($this->status[$value] == 2) {

                $this->validate([
                    'nama_pihak.' . $value => 'required',
                    'fakultas_pihak.' . $value => 'required',
                    'alamat_pihak.' . $value => 'required',
                    'nama_pejabat_pihak.' . $value => 'required',

                ]);
            }
            if ($this->status[$value] == 3) {
                $this->validate([
                    'nama_pihak.' . $value => 'required',
                    'badanKemitraan.' . $value => 'required',
                ]);

                if ($this->badanKemitraan[$value] == 99) {
                    $this->validate([
                        'lainnya.' . $value => 'required',
                        'nama_pihak.' . $value => 'required',
                        'badanKemitraan.' . $value => 'required',
                        'alamat_pihak.' . $value => 'required',
                        'nama_pejabat_pihak.' . $value => 'required',

                    ]);
                } else {
                    $this->validate([
                        'nama_pihak.' . $value => 'required',
                        'badanKemitraan.' . $value => 'required',
                        'alamat_pihak.' . $value => 'required',
                        'nama_pejabat_pihak.' . $value => 'required',

                    ]);
                }
            }
        }

        // $this->validate([
        //     'arrayBentukKegiatan' => 'required'
        // ]);
    }

    public function save()
    {
        $this->validasiSave();
        if ($this->getErrorBag()->isNotEmpty()) {
            $this->emit('formFailed', $this->getErrorBag()->all());
        }
        $uuid = DataMou::max('id');
        $uuid = str_pad($uuid + 1, 3, '0', STR_PAD_LEFT);
        $uuid = 'MoU-' . date('y') . $uuid;

        if ($this->nomorSistem) {
            $this->nomor_unhas =  $uuid;
        }
        $this->arrayNamaPenggiat = [$this->nama_pihak[0]];

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

            if ($store->wasRecentlyCreated) {
                foreach (range(0, $this->arrayJawaban) as $key => $value) {

                    $storePJ = PenanggungJawab::updateOrCreate(
                        [
                            'id' => $this->idPJ[$value] ?? null,
                        ],
                        [
                            'name' => $this->pj_pihak[$value],
                            'designation' => $this->jabatan_pj_pihak[$value],
                            'email' => $this->email_pj_pihak[$value],
                            'phone_number' => $this->hp_pj_pihak[$value]
                        ]
                    );

                    $storePejabat = Pejabat::updateOrCreate(
                        [
                            'id' => $this->idPejabat[$value] ?? null,
                        ],
                        [
                            'nama' => $this->nama_pejabat_pihak[$value],
                            'jabatan' => $this->jabatan_pejabat_pihak[$value]
                        ]

                    );

                    $storeInstansi = Instansi::updateOrCreate(
                        [
                            'id' => $this->idInstansi ?? null,
                        ],
                        [
                            'name' => $this->nama_pihak[$value],
                            'address' => $this->alamat_pihak[$value],
                            'negara_id' => $this->negara_pihak[$value],
                            'coordinates' => $this->koordinat_pihak[$value],
                            'ptqs' => $this->ptqs[$value],
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
                            'fakultas_pihak' => $this->fakultas_pihak[$value],
                            'prodi' => '',
                        ]
                    );
                }
                $code = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $random = substr(str_shuffle($code), 0, 3);
                if ($this->uploadDocument) {
                    $templateProcessor = new TemplateProcessor(storage_path('document/Template_MOU.docx'));

                    $templateProcessor->setValue('University_Name', $this->nama_pihak[0]);
                    $templateProcessor->setValue('Country_Of_Origin', Negara::find($this->negara)->name ?? 'Unknown Country');
                    $templateProcessor->setValue('Signing_Date', date('d/m/Y', strtotime($this->tanggal_ttd)));
                    $templateProcessor->setValue('Duration_Years', $this->jangka_waktu);

                    $templateProcessor->setValue('PIC_Name', $this->pj_pihak[0]);
                    $templateProcessor->setValue('PIC_Designation', $this->jabatan_pj_pihak[0]);
                    $templateProcessor->setValue('PIC_Address', $this->alamat_pihak[0]);
                    $templateProcessor->setValue('PIC_Email', $this->email_pj_pihak[0]);
                    $templateProcessor->setValue('PIC_Phone', $this->hp_pj_pihak[0]);
                    $templateProcessor->setValue('Rep_Name', $this->nama_pejabat_pihak[0]);
                    $templateProcessor->setValue('Rep_Designation', $this->jabatan_pejabat_pihak[0]);
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
                            } else {
                                throw new \Exception("Unsupported image format: " . $extension);
                            }
                        } else {
                            // Log or throw an error if the image file doesn't exist
                            throw new \Exception("Image file not found at path: " . $logoPath);
                        }
                        // Optionally delete the logo file from storage after use
                        Storage::delete($logoFilePath);
                    }



                    // Define the name and path for the generated document
                    $namaDokumen = 'MoU_' . $uuid . '_' . $random . '.docx';
                    $outputFile = storage_path('app/public/DokumenMoU/' . $namaDokumen);

                    // Save the modified template as a new file
                    $templateProcessor->saveAs($outputFile);

                    $store->dokumenMoU()->firstOrCreate([
                        'url' => $namaDokumen,
                        'kerjasama_id' => $store->id
                    ]);

                    Mail::to('kaizerd23@gmail.com')->send(new DocumentMail($outputFile, $this->nama_pihak[0]));
                } else {
                    foreach ($this->files as $file) {
                        $random = substr(str_shuffle($code), 0, 3);
                        $namaDokumen = 'MoU' . $uuid . $random . '.' . $file->extension();

                        $file->storeAs('public/DokumenMoU', $namaDokumen);

                        $store->dokumenMoU()->firstOrCreate([
                            'url' => $namaDokumen,
                            'kerjasama_id' => $store->id
                        ]);

                        $outputFile = storage_path('app/public/DokumenMoU/' . $namaDokumen);
                        Mail::to('kaizerd23@gmail.com')->send(new DocumentMail($outputFile, $this->nama_pihak[0]));
                    }
                }

                DB::commit();

                $this->emit('formSubmitted');
            }
        } catch (\Exception $th) {
            DB::rollback();
            //dd($th);
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
        $instansi = $instansiModel->where('id', '=', 1164);

        $pejabatModel = new Pejabat();
        $pejabat = $pejabatModel->where('id', '=', 652);

        $penanggugjawabModel = new PenanggungJawab();
        $penanggungjawab = $penanggugjawabModel->where('id', '=', 496);

        



        
    }

    public function render()
    {
        return view('livewire.input.guest-mou-input', [
            'bentukKegiatan' => $this->arrayBentukKegiatan,
        ]);
    }
}
