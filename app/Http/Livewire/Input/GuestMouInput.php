<?php

namespace App\Http\Livewire\Input;

use App\Models\Negara;

use App\Models\ReferensiBadanKemitraan;
use Livewire\Component;
use App\Models\LapkermaRefBentukKegiatan;
use App\Models\LapkermaRefSasaranKegiatan;
use App\Models\LapkermaRefIndikatorKinerja;
use App\Models\DataMouBentukKegiatanKerjasama;
use App\Models\Fakultas;
use App\Models\JenisKerjasama;
use App\Models\StatusKerjasama;
use Livewire\WithFileUploads;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Mail\DocumentMail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException as ERROR;
use App\Models\MouRequest;
use App\Models\MouRequestBentukKegiatanKerjasama;
use App\Models\MouRequestPenggiat;
use App\Models\Region;

class GuestMouInput extends Component
{
    use WithFileUploads;

    // Kopian MoU;
    public $inputs = [0, 1, 2, 3, 4, 5, 6, 7, 8], $arrayJawaban = 1, $showLoadFiles, $idEdit, $findDokumen, $arrayNamaPenggiat, $upBy;
    public $fakultas = [], $statusKerjasama, $getSasaranKegiatan, $getIndikatorKinerja, $getBentukKegiatan, $bentukKegiatan;

    public $nama_pihak = [], $status, $fakultas_pihak = [], $alamat_pihak = [];
    public $nama_pejabat_pihak = [], $jabatan_pejabat_pihak = [], $pj_pihak = [], $jabatan_pj_pihak = [];
    public $email_pj_pihak = [], $hp_pj_pihak = [], $files = [], $badanKemitraan = [], $lainnya = [], $ptqs = [];
    public $regionKerjasama, $jenisKerjasama, $nomorSistem, $nomorSistem2;

    public $arrayBentukKegiatan = [], $arraySasaran = [], $arrayKinerja = [], $keterangan, $volume_luaran, $volume_satuan, $nilai_kontrak;

    public $jenisKerjasamaField, $region, $negara, $tempat_pelaksanaan, $negaraKerjasama;

    public $nomor_unhas, $nomor_mitra, $judul_kerjasama, $deskripsi;

    public $tanggal_ttd, $tanggal_awal, $tanggal_berakhir, $status_kerjasama, $jangka_waktu;
    public $badanKemitraanOptions;
    public $showCountryInput = false;


    public $uploadDocument = false, $mou_document,  $logo, $newScopeItem, $scopeList = [
        "Research collaboration in the areas of mutual interest",
        "Exchange of academic materials which are made available by both parties",
        "Exchange of scholars",
        "Student mobility",
        "Cooperative seminars, workshops, and other academic activities"
    ];


    // public $negaras;
    // public $regions;
    // public $university_name, $country_of_origin, $scope, $signing_date, $duration_years;
    // public $pic_name, $pic_designation, $pic_address, $pic_email, $pic_phone;
    // public $rep_name, $rep_designation, $logo;
    // public $region;
    // public $getBentukKegiatan;
    // public $getSasaranKegiatan;
    // public $getIndikatorKinerja;
    // public $badanKemitraanOptions;
    // public $arrayBentukKegiatan = [];
    // public $alamat_pj_pihak_unhas;
    // public $nama_pejabat_pihak_unhas, $jabatan_pejabat_pihak_unhas;
    // public $pj_pihak_unhas, $jabatan_pj_pihak_unhas;
    // public $email_pj_pihak_unhas, $hp_pj_pihak_unhas;
    // public $bentuk_kegiatan, $mitra, $ptqs;

    // public $type_collaboration;

    // New properties for document upload

    public function rules()
    {
        return [
            'type_collaboration' => 'required|in:1,2', // Pastikan nilai sesuai dengan opsi dropdown
        ];
    }

    protected $rules = [
        'bentukKegiatan' => 'required|exists:lapkerma_ref_bentuk_kegiatans,id',
        'university_name' => 'required|string|max:255',
        'country_of_origin' => 'required|string|max:255',
        'signing_date' => 'required|date',
        'duration_years' => 'required|integer|min:1|max:5',
        'pic_name' => 'required|string|max:255',
        'pic_designation' => 'required|string|max:255',
        'pic_address' => 'required|string|max:255',
        'pic_email' => 'required|email|max:255',
        'pic_phone' => 'required|string|max:20',
        'rep_name' => 'required|string|max:255',
        'rep_designation' => 'required|string|max:255',
        'type_collaboration' => 'required|string|in:dalam_negeri,luar_negeri',
        'logo' => 'required|image|mimes:png|max:2048|dimensions:max_width=2048,max_height=2048',
        'mou_document' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'alamat_pj_pihak_unhas' => 'nullable|string|max:255',
        'nama_pejabat_pihak_unhas' => 'nullable|string|max:255',
        'jabatan_pejabat_pihak_unhas' => 'nullable|string|max:255',
        'pj_pihak_unhas' => 'nullable|string|max:255',
        'jabatan_pj_pihak_unhas' => 'nullable|string|max:255',
        'email_pj_pihak_unhas' => 'nullable|email|max:255',
        'hp_pj_pihak_unhas' => 'nullable|string|max:20',
        'bentuk_kegiatan' => 'nullable|string|max:255',
        'mitra' => 'nullable|string|max:255',
        'ptqs' => 'nullable|string|max:255',
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

        $this->validate([
            'arrayBentukKegiatan' => 'required'
        ]);
    }

    public function submit()
    {
        // Validate the form data
        $this->validate();

        $this->emit('formSubmitted');

        // if ($this->type_collaboration === 2) {
        //     $this->validate([
        //         'region' => 'required|string|max:255',
        //     ]);
        // }

        if ($this->uploadDocument) {

            if (empty($this->scopeList)) {
                $this->addError('newScopeItem', 'The scope list cannot be empty. Please add at least one item.');
                return; // Prevent submission if the scopeList is empty
            }
            $this->validate([
                'logo' => 'nullable|image|mimes:png|max:1024',
            ]);

            // Handle the logo upload
            $logoPath = $this->logo->store('logos', 'public');
        }


        // $data = [
        //     'nama_instansi' => $this->university_name,
        //     'tipe_kerjasama' => $this->type_collaboration,
        //     'negara' => $this->country_of_origin,
        //     'tanggal_ttd' => $this->signing_date,
        //     'alamat_pj_pihak' => $this->pic_address,
        //     'durasi' => $this->duration_years,
        //     'nama_pejabat_pihak' => $this->rep_name,
        //     'jabatan_pejabat_pihak' => $this->rep_designation,
        //     'pj_pihak' => $this->pic_name,
        //     'jabatan_pj_pihak' => $this->pic_designation,
        //     'email_pj_pihak' => $this->pic_email,
        //     'hp_pj_pihak' => $this->pic_phone,
        //     'region' => $this->region,
        //     'alamat_pj_pihak_unhas' => $this->alamat_pj_pihak_unhas,
        //     'nama_pejabat_pihak_unhas' => $this->nama_pejabat_pihak_unhas,
        //     'jabatan_pejabat_pihak_unhas' => $this->jabatan_pejabat_pihak_unhas,
        //     'pj_pihak_unhas' => $this->pj_pihak_unhas,
        //     'jabatan_pj_pihak_unhas' => $this->jabatan_pj_pihak_unhas,
        //     'email_pj_pihak_unhas' => $this->email_pj_pihak_unhas,
        //     'hp_pj_pihak_unhas' => $this->hp_pj_pihak_unhas,
        //     'bentuk_kegiatan' => $this->bentuk_kegiatan,
        //     'mitra' => $this->mitra,
        //     'ptqs' => $this->ptqs,
        // ];

        // dd($data);

        // // Simpan data ke dalam model MouRequest
        // $mouRequest = MouRequest::create($data);

        // foreach ($this->arrayBentukKegiatan as $key => $value) {
        //     $storeBentukKegiatanKerjasama = DataMouBentukKegiatanKerjasama::create([
        //         'id_mou' => $mouRequest->id,
        //         'nilai_kontrak' => $this->nilai_kontrak[$key] ?? null,
        //         'volume_satuan' => $this->volume_satuan[$key] ?? null,
        //         'volume_luaran' => $this->volume_luaran[$key] ?? null,
        //         'keterangan' => $this->keterangan[$key] ?? null,
        //         'id_ref_bentuk_kegiatan' => $value,
        //         'id_ref_indikator_kinerja' => $this->arrayKinerja[$key] ?? null,
        //         'id_ref_sasaran_kegiatan' => $this->arraySasaran[$key] ?? null,
        //     ]);
        // }

        if ($this->uploadDocument) { // If the document is not uploaded, create a new TemplateProcessor instance with the .docx template
            $templateProcessor = new TemplateProcessor(storage_path('document/Template_MOU.docx')); // Adjust the path to your template

            // Replace placeholders with form data in the template
            $templateProcessor->setValue('University_Name', $this->university_name);
            $templateProcessor->setValue('Country_Of_Origin', $this->country_of_origin);
            $templateProcessor->setValue('Signing_Date', date('d/m/Y', strtotime($this->signing_date)));
            $templateProcessor->setValue('Duration_Years', $this->duration_years);
            $templateProcessor->setValue('PIC_Name', $this->pic_name);
            $templateProcessor->setValue('PIC_Designation', $this->pic_designation);
            $templateProcessor->setValue('PIC_Address', $this->pic_address);
            $templateProcessor->setValue('PIC_Email', $this->pic_email);
            $templateProcessor->setValue('PIC_Phone', $this->pic_phone);
            $templateProcessor->setValue('Rep_Name', $this->rep_name);
            $templateProcessor->setValue('Rep_Designation', $this->rep_designation);
            $templateProcessor->setValue('Type_Collaboration', $this->type_collaboration);

            $bulletXml = '';
            foreach ($this->scopeList as $scopeItem) {
                $bulletXml .= '<w:p><w:pPr><w:numPr><w:ilvl w:val="0"/><w:numId w:val="1"/></w:numPr></w:pPr><w:r><w:t>' . htmlspecialchars($scopeItem) . '</w:t></w:r></w:p>';
            }

            // Add the logo image to the template (assuming you have a placeholder for the logo)
            $templateProcessor->setImageValue('Logo', storage_path('app/public/' . $logoPath)); // Replace 'Logo' with the placeholder name in the .docx template
            $templateProcessor->setValue('Scope', $bulletXml, true);

            // Save the filled-in document to a new file
            $outputFile = storage_path('app/public/mou_generated.docx');
            $templateProcessor->saveAs($outputFile);

            Mail::to('kaizerd23@gmail.com')->send(new DocumentMail($outputFile, $this->university_name));

            // Return the .docx file as a download
            return response()->download($outputFile)->deleteFileAfterSend(true);
        } else {
            $mouDocPath = $this->mou_document->store('mou_documents', 'public');
            $uploadedFilePath = storage_path('app/public/' . $mouDocPath);

            // Send the uploaded document via email
            Mail::to('kaizerd23@gmail.com')->send(new DocumentMail($uploadedFilePath, $this->university_name));

            // Return the uploaded file as a download
            return response()->download($uploadedFilePath)->deleteFileAfterSend(true);
        }
    }

    public function save()
    {
        $this->validasiSave();

        $this->emit('formSubmitted');

        if ($this->uploadDocument) {

            if (empty($this->scopeList)) {
                $this->addError('newScopeItem', 'The scope list cannot be empty. Please add at least one item.');
                return; // Prevent submission if the scopeList is empty
            }
            $this->validate([
                'logo' => 'nullable|image|mimes:png|max:1024',
            ]);

            // Handle the logo upload
            $logoPath = $this->logo->store('logos', 'public');
        }

        // membuat kode sistem dokumen
        $uuid = MouRequest::max('id');
        $uuid = str_pad($uuid + 1, 3, '0', STR_PAD_LEFT);
        $uuid = 'MoU-' . date('y') . $uuid;

        if ($this->nomorSistem) {
            $this->nomor_unhas = $uuid;
        }

        $this->arrayNamaPenggiat = [];
        $hitung = 0;
        foreach (range(0, $this->arrayJawaban) as $key => $value) {

            $namanama = Str::lower($this->nama_pihak[$key]);
            if ($namanama == 'unhas' || $namanama == 'universitas hasanuddin') {
                array_push($this->arrayNamaPenggiat, 'Universitas Hasanuddin');
            } else {
                array_push($this->arrayNamaPenggiat, $this->nama_pihak[$key]);
            }
            switch ($namanama) {
                case 'unhas':
                    $status = $this->status[$key];
                    $alamatPihak1 = $this->alamat_pihak[$key];
                    $namaPihak1 = 'Universitas Hasanuddin';
                    $namaPejabat1 = $this->nama_pejabat_pihak[$key];
                    $jabatanPejabat1 = $this->jabatan_pejabat_pihak[$key] ?? null;
                    $pj1 = $this->pj_pihak[$key] ?? null;
                    $jabatanPj1 = $this->jabatan_pj_pihak[$key] ?? null;
                    $emailPj1 = $this->email_pj_pihak[$key] ?? null;
                    $fakultas_pihak = $this->fakultas_pihak[$key];
                    $hpPj1 = $this->hp_pj_pihak[$key] ?? null;
                    $hitung++;
                    break;
                case 'universitas hasanuddin':
                    $status = $this->status[$key];
                    $alamatPihak1 = $this->alamat_pihak[$key];
                    $namaPihak1 = 'Universitas Hasanuddin';
                    $namaPejabat1 = $this->nama_pejabat_pihak[$key];
                    $jabatanPejabat1 = $this->jabatan_pejabat_pihak[$key] ?? null;
                    $pj1 = $this->pj_pihak[$key] ?? null;
                    $jabatanPj1 = $this->jabatan_pj_pihak[$key] ?? null;
                    $emailPj1 = $this->email_pj_pihak[$key] ?? null;
                    $fakultas_pihak = $this->fakultas_pihak[$key];
                    $hpPj1 = $this->hp_pj_pihak[$key] ?? null;
                    $hitung++;

                    break;
                default:
                    break;
            }
        }


        if ($hitung == 0) {
            $this->emit('alertz', ['pesan' => 'Gagal ditambahkan, Unhas tidak disertakan dalam penggiat kerjasama', 'icon' => 'error']);
        } else {
            if ($this->files) {
                DB::beginTransaction();
                try {
                    $store = MouRequest::firstOrCreate([
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
                        'level' => 1,
                        'nomor_dok_mitra' => $this->nomor_mitra,
                        'judul' => $this->judul_kerjasama,
                        'fakultas_pihak' => $fakultas_pihak,
                        'deskripsi' => $this->deskripsi,
                        'nama_pihak' => $namaPihak1,
                        'alamat_pihak' => $alamatPihak1,
                        'nama_pejabat_pihak' => $namaPejabat1,
                        'jabatan_pejabat_pihak' => $jabatanPejabat1,
                        'pj_pihak' => $pj1,
                        'jabatan_pj_pihak' => $jabatanPj1,
                        'email_pj_pihak' => $emailPj1,
                        'hp_pj_pihak' => $hpPj1,
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
                            $storePenggiatKerjasama = MouRequestPenggiat::create([
                                'id_lapkerma' => $store->id,
                                'pihak' => $value + 1,
                                'status_pihak' => $this->status[$key],
                                'nama_pihak' => $this->arrayNamaPenggiat[$key],
                                'fakultas_pihak' => $this->fakultas_pihak[$key] ?? '',
                                'alamat_pihak' => $this->alamat_pihak[$key],
                                'nama_pejabat_pihak' => $this->nama_pejabat_pihak[$key],
                                'jabatan_pejabat_pihak' => $this->jabatan_pejabat_pihak[$key] ?? '',
                                'pj_pihak' => $this->pj_pihak[$key] ?? null,
                                'jabatan_pj_pihak' => $this->jabatan_pj_pihak[$key] ?? null,
                                'email_pj_pihak' => $this->email_pj_pihak[$key] ?? null,
                                'hp_pj_pihak' => $this->hp_pj_pihak[$key] ?? null,
                                'ptqs' => $this->ptqs[$key] ?? null,
                                'badan_kemitraan' => $this->badanKemitraan[$key] ?? null,
                                'uploaded_by' => auth()->user()->name,
                            ]);
                            if (optional($this->badanKemitraan)[$key] == 99) {
                                $storePenggiatKerjasama->update([
                                    'badan_kemitraan' => $this->lainnya[$key]
                                ]);
                            }
                        }
                        if ($this->MouRequestId != null) {
                            MouRequestBentukKegiatanKerjasama::where('id_mou', $this->MouRequestId)->delete();
                        }
                        foreach ($this->arrayBentukKegiatan as $key => $value) {
                            $storeBentukKegiatanKerjasama = MouRequestBentukKegiatanKerjasama::create([
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
                        $this->sendEmail();
                        $this->emit('alerts', ['pesan' => 'Data Berhasil Ditambahkan', 'icon' => 'success']);
                    } else {
                        $this->emit('alertz', ['pesan' => 'Invalid Proses, Data Duplikat', 'icon' => 'error']);
                    }
                } catch (ERROR $th) {
                    DB::rollback();
                    dd($th);

                    $this->emit('alertz', ['pesan' => 'Invalid Proses, Gagal Ditambahkan', 'icon' => 'error']);
                }
            } else {
                $this->emit('alertz', ['pesan' => 'Tidak Ada File Pendukung, Data Gagal Ditambahkan', 'icon' => 'error']);
            }
        }
    }

    public function sendEmail()
    {
        if ($this->uploadDocument) {
            // Generate document using TemplateProcessor with placeholders filled
            $templateProcessor = new TemplateProcessor(storage_path('document/Template_MOU.docx'));

            // Set template placeholders with form data
            $templateProcessor->setValue('University_Name', $this->nama_pihak[1]);
            $templateProcessor->setValue('Country_Of_Origin', Negara::find($this->negara)->name ?? 'Unknown Country');
            $templateProcessor->setValue('Signing_Date', date('d/m/Y', strtotime($this->tanggal_ttd)));
            $templateProcessor->setValue('Duration_Years', $this->jangka_waktu);
            $templateProcessor->setValue('PIC_Name', $this->pj_pihak[1]);
            $templateProcessor->setValue('PIC_Designation', $this->jabatan_pj_pihak);
            $templateProcessor->setValue('PIC_Address', $this->alamat_pihak[1]);
            $templateProcessor->setValue('PIC_Email', $this->email_pj_pihak[1]);
            $templateProcessor->setValue('PIC_Phone', $this->hp_pj_pihak[1]);
            $templateProcessor->setValue('Rep_Name', $this->nama_pejabat_pihak[1]);
            $templateProcessor->setValue('Rep_Designation', $this->jabatan_pejabat_pihak[1]);
            $templateProcessor->setValue('Type_Collaboration', $this->type_collaboration);

            // Generate bullet points for scopeList items
            $bulletXml = collect($this->scopeList)->map(function ($item) {
                return '<w:p><w:pPr><w:numPr><w:ilvl w:val="0"/><w:numId w:val="1"/></w:numPr><w:r><w:t>' . htmlspecialchars($item) . '</w:t></w:r></w:p>';
            })->implode('');

            $templateProcessor->setValue('Scope', $bulletXml, true);

            // Add logo to the document if available
            if (isset($this->logo)) {
                $logoPath = storage_path('app/public/' . $this->logo->store('logos', 'public'));
                $templateProcessor->setImageValue('Logo', $logoPath);
            }

            // Save the completed template
            $outputFile = storage_path('app/public/mou_generated.docx');
            $templateProcessor->saveAs($outputFile);
        } else {
            // Handle file upload if the document was provided
            $outputFile = storage_path('app/public/' . $this->mou_document->store('mou_documents', 'public'));
        }

        // Send the document by email and return as a download
        Mail::to('kaizerd23@gmail.com')->send(new DocumentMail($outputFile, $this->university_name));
        return response()->download($outputFile)->deleteFileAfterSend(true);
    }

    public function addScope()
    {
        // Validate the input before adding to the list
        $this->validate([
            'newScopeItem' => 'required|string|max:255',
        ]);

        // Add the new scope item to the list
        $this->scopeList[] = $this->newScopeItem;

        // Clear the input field after adding
        $this->newScopeItem = '';
    }

    public function removeScope($index)
    {
        // Remove the scope item from the list
        unset($this->scopeList[$index]);

        // Re-index the array to avoid gaps in the list
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
    }

    // // Perbarui metode untuk menangani perubahan pada dropdown type_collaboration
    // public function updatedTypeCollaboration($value)
    // {
    //     if ($value == "1") {
    //         $this->negara = "103";
    //         $this->region = 1;
    //         $this->showCountryInput = false;
    //     } elseif ($value == "2") {
    //         $this->negara = null;
    //         $this->region = null;
    //         $this->showCountryInput = true;
    //     }
    // }


    public function render()
    {
        return view('livewire.input.guest-mou-input', [
            'bentukKegiatan' => $this->arrayBentukKegiatan,
        ]);
    }
}
