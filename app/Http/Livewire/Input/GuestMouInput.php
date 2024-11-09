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
use Illuminate\Support\Facades\File;
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
        // If validation fails, emit formFailed event
        if ($this->getErrorBag()->isNotEmpty()) {
            $this->emit('formFailed', $this->getErrorBag()->all());
        }
        $uuid = MouRequest::max('id');
        $uuid = str_pad($uuid + 1, 3, '0', STR_PAD_LEFT);
        $uuid = date('y') . $uuid;

        // Ensure nomor_unhas is set if $this->nomorSistem is true
        if ($this->nomorSistem) {
            $this->nomor_unhas = 'MoU-' . date('y') . '-' . $uuid; // Format the UUID
        }
        // Initialize array for storing the names of involved parties
        $this->arrayNamaPenggiat = [];
        $hitung = 0;

        // Loop through the list of responses (assuming arrayJawaban is an integer count)
        foreach (range(0, $this->arrayJawaban) as $key => $value) {

            $namanama = Str::lower($this->nama_pihak[$key]);

            // Check for "unhas" or "universitas hasanuddin" in the names and handle accordingly
            if ($namanama == 'unhas' || $namanama == 'universitas hasanuddin') {
                array_push($this->arrayNamaPenggiat, 'Universitas Hasanuddin');
            } else {
                array_push($this->arrayNamaPenggiat, $this->nama_pihak[$key]);
            }

            // Process data for Unhas and other institutions
            switch ($namanama) {
                case 'unhas':
                case 'universitas hasanuddin':
                    // Set the data for the Unhas institution
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

        // If no valid Unhas data is found, display an error
        if ($hitung == 0) {
            $this->emit('alertz', ['pesan' => 'Gagal ditambahkan, Unhas tidak disertakan dalam penggiat kerjasama', 'icon' => 'error']);
        } else {
            DB::beginTransaction();
            try {
                // Store the MouRequest data
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

                // dd('JALAN');

                if ($store->wasRecentlyCreated) {

                    // Store the collaboration partners data
                    // foreach (range(0, $this->arrayJawaban) as $key => $value) {
                    //     $storePenggiatKerjasama = MouRequestPenggiat::create([
                    //         'id_lapkerma' => $store->id,
                    //         'pihak' => $value + 1,
                    //         'status_pihak' => $this->status[$key],
                    //         'nama_pihak' => $this->arrayNamaPenggiat[$key],
                    //         'fakultas_pihak' => $this->fakultas_pihak[$key] ?? '',
                    //         'alamat_pihak' => $this->alamat_pihak[$key],
                    //         'nama_pejabat_pihak' => $this->nama_pejabat_pihak[$key],
                    //         'jabatan_pejabat_pihak' => $this->jabatan_pejabat_pihak[$key] ?? '',
                    //         'pj_pihak' => $this->pj_pihak[$key] ?? null,
                    //         'jabatan_pj_pihak' => $this->jabatan_pj_pihak[$key] ?? null,
                    //         'email_pj_pihak' => $this->email_pj_pihak[$key] ?? null,
                    //         'hp_pj_pihak' => $this->hp_pj_pihak[$key] ?? null,
                    //         'ptqs' => $this->ptqs[$key] ?? null,
                    //         'badan_kemitraan' => $this->badanKemitraan[$key] ?? null,
                    //         'uploaded_by' => auth()->user()->name,
                    //     ]);

                    //     // Handle specific conditions for badan_kemitraan
                    //     if (optional($this->badanKemitraan)[$key] == 99) {
                    //         $storePenggiatKerjasama->update([
                    //             'badan_kemitraan' => $this->lainnya[$key]
                    //         ]);
                    //     }
                    // }

                    // // Store the kegiatan data
                    // foreach ($this->arrayBentukKegiatan as $key => $value) {
                    //     $storeBentukKegiatanKerjasama = MouRequestBentukKegiatanKerjasama::create([
                    //         'id_mou' => $store->id,
                    //         'nilai_kontrak' => $this->nilai_kontrak[$key] ?? null,
                    //         'volume_satuan' => $this->volume_satuan[$key] ?? null,
                    //         'volume_luaran' => $this->volume_luaran[$key] ?? null,
                    //         'keterangan' => $this->keterangan[$key] ?? null,
                    //         'id_ref_bentuk_kegiatan' => $value,
                    //         'id_ref_indikator_kinerja' => $this->arrayKinerja[$key] ?? null,
                    //         'id_ref_sasaran_kegiatan' => $this->arraySasaran[$key] ?? null,
                    //     ]);
                    // }



                    //Sending document to email
                    $code = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $random = substr(str_shuffle($code), 0, 3);
                    if ($this->uploadDocument) {
                        // Initialize TemplateProcessor for the DOCX template
                        $templateProcessor = new TemplateProcessor(storage_path('document/Template_MOU.docx'));

                        // Set simple placeholders
                        $templateProcessor->setValue('University_Name', $this->nama_pihak[1]);
                        $templateProcessor->setValue('Country_Of_Origin', Negara::find($this->negara)->name ?? 'Unknown Country');
                        $templateProcessor->setValue('Signing_Date', date('d/m/Y', strtotime($this->tanggal_ttd)));
                        $templateProcessor->setValue('Duration_Years', $this->jangka_waktu);

                        // Set values for PIC (person in charge)
                        $templateProcessor->setValue('PIC_Name', $this->pj_pihak[1]);
                        $templateProcessor->setValue('PIC_Designation', $this->jabatan_pj_pihak[1]);
                        $templateProcessor->setValue('PIC_Address', $this->alamat_pihak[1]);
                        $templateProcessor->setValue('PIC_Email', $this->email_pj_pihak[1]);
                        $templateProcessor->setValue('PIC_Phone', $this->hp_pj_pihak[1]);
                        $templateProcessor->setValue('Rep_Name', $this->nama_pejabat_pihak[1]);
                        $templateProcessor->setValue('Rep_Designation', $this->jabatan_pejabat_pihak[1]);

                        // Generate bullet points for the Scope placeholder
                        // Initialize the bullet XML for the Scope placeholder
                        $bulletXml = '';
                        // foreach ($this->scopeList as $scopeItem) {
                        //     $bulletXml .= '<w:p><w:pPr><w:numPr><w:ilvl w:val="0"/><w:numId w:val="1"/></w:numPr></w:pPr><w:r><w:t>'
                        //         . htmlspecialchars(trim($scopeItem), ENT_QUOTES, 'UTF-8') . '</w:t></w:r></w:p>';
                        // }

                        // dd($bulletXml);

                        // Use setComplexValue to support the bullet XML format
                        // $templateProcessor->setValue('Scope', $bulletXml, true);
                        $templateProcessor->setValue('Scope', '• ' . implode("\n• ", $this->scopeList));


                        // Check if a logo file is provided and handle it
                        // Handle the logo image with extra validation
                        if (isset($this->logo)) {
                            // Store the logo file and retrieve its path
                            $logoFilePath = $this->logo->store('public/logos');
                            $logoPath = storage_path('app/' . $logoFilePath); // Full path to the stored logo image

                            // Ensure the file exists and is accessible
                            if (file_exists($logoPath)) {
                                // Check if the image format is compatible
                                $validImageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                                $extension = pathinfo($logoPath, PATHINFO_EXTENSION);

                                if (in_array(strtolower($extension), $validImageExtensions)) {
                                    // Insert the logo image in the template
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
                                    // Log or throw an error if the format isn't compatible
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

                        // Create or update the MoU document record in the database
                        $store->dokumenMoURequest()->firstOrCreate([
                            'url' => $namaDokumen,
                            'kerjasama_id' => $store->id
                        ]);

                        // Send the document by email as an attachment
                        Mail::to('kaizerd23@gmail.com')->send(new DocumentMail($outputFile, $this->nama_pihak[1]));
                    } else {
                        foreach ($this->files as $file) {
                            $random = substr(str_shuffle($code), 0, 3);
                            $namaDokumen = 'MoU' . $uuid . $random . '.' . $file->extension();
                            $file->storeAs('public/DokumenMoU', $namaDokumen);

                            $store->dokumenMoURequest()->firstOrCreate([
                                'url' => $namaDokumen,
                                'kerjasama_id' => $store->id
                            ]);

                            $outputFile = storage_path('app/public/DokumenMoU/' . $namaDokumen);
                            Mail::to('kaizerd23@gmail.com')->send(new DocumentMail($outputFile, $this->nama_pihak[1]));
                        }
                    }

                    DB::commit();

                    $this->emit('formSubmitted');
                }
            } catch (\Exception $th) {
                DB::rollback();
                dd($th);
                $this->emit('alertz', ['pesan' => 'Invalid Proses, Gagal Ditambahkan', 'icon' => 'error']);
            }
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
        $this->nama_pejabat_pihak[] = 'Prof. Dr. Eng. Adi Maulana, S.T., M.Phil';
        $this->jabatan_pejabat_pihak[] = 'Wakil Rektor Bidang Kemitraan, Inovasi, Kewirausahaan dan Bisnis';
        $this->pj_pihak[] = 'Dr. Amril Hans, S.AP., MPA';
        $this->jabatan_pj_pihak[] = 'Kasubdit Kerja Sama Dalam Negeri';
        $this->alamat_pihak[] = 'Jalan Perintis Kemerdekaan Km. 10, Tamalanrea, Makassar';
        $this->email_pj_pihak[] = 'intl.partnership@unhas.ac.id';
        $this->hp_pj_pihak[] = '085256310457';
        $this->ptqs[] = 2;
        $this->nama_pihak[] = "Universitas Hasanuddin";
        $this->status[] = 1;
    }

    public function render()
    {
        return view('livewire.input.guest-mou-input', [
            'bentukKegiatan' => $this->arrayBentukKegiatan,
        ]);
    }
}
