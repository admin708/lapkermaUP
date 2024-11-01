<?php

namespace App\Http\Livewire\Input;

use App\Models\Negara;
use Livewire\Component;
use Livewire\WithFileUploads;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Mail\DocumentMail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class GuestMouInput extends Component
{
    use WithFileUploads;


    public $negaras; // Store the countries here 
    public $university_name, $country_of_origin, $scope, $signing_date, $duration_years;
    public $pic_name, $pic_designation, $pic_address, $pic_email, $pic_phone;
    public $rep_name, $rep_designation, $logo;

    public $type_collaboration;

    // New properties for document upload
    public $uploadDocument = false; // Checkbox state
    public $mou_document; // Document upload input

    public $scopeList = [
        "Research collaboration in the areas of mutual interest",
        "Exchange of academic materials which are made available by both parties",
        "Exchange of scholars",
        "Student mobility",
        "Cooperative seminars, workshops, and other academic activities"
    ];
    public $newScopeItem;
    public function rules()
{
    return [
        'type_collaboration' => 'required|in:1,2', // Pastikan nilai sesuai dengan opsi dropdown
        // aturan validasi lainnya
    ];
}

    protected $rules = [
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
        'logo' => 'required|image|mimes:png|max:2048|dimensions:max_width=2048,max_height=2048', // Corrected dimension validation
        'mou_document' => 'nullable|file|mimes:pdf,doc,docx|max:2048' // Add rules for document upload
    ];

    public function submit()
    {
        // Validate the form data
        $this->validate();

        if (empty($this->scopeList)) {
            $this->addError('newScopeItem', 'The scope list cannot be empty. Please add at least one item.');
            return; // Prevent submission if the scopeList is empty
        }
        $this->validate([
            'logo' => 'nullable|image|mimes:png|max:1024',
        ]);

        // Handle the logo upload
        $logoPath = $this->logo->store('logos', 'public');
       

        $data = [
            'nama_instansi' => $this->university_name,
            'tipe_kerjasama' => $this->type_collaboration,
            'negara' => $this->country_of_origin,
            'tanggal_ttd' => $this->signing_date,
            'alamat_pj_pihak' => $this->pic_address,
            'durasi' => $this->duration_years,
            'nama_pejabat_pihak' => $this->rep_name,
            'jabatan_pejabat_pihak' => $this->rep_designation,
            'pj_pihak' => $this->pic_name,
            'jabatan_pj_pihak' => $this->pic_designation,
            'email_pj_pihak' => $this->pic_email,
            'hp_pj_pihak' => $this->pic_phone,
        ];

        if ($this->uploadDocument) {
            // Handle MoU document upload if checkbox is checked
            $mouDocPath = $this->mou_document->store('mou_documents', 'public');
            // You can add any further processing here if necessary
        } else {
            // If the document is not uploaded, create a new TemplateProcessor instance with the .docx template
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
        }
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
        // Fetch all countries when the component is initialized
        $this->negaras = Negara::all();
        $this->pic_name = auth()->user()->name;
        $this->pic_email = auth()->user()->email;
    }

    public function render()
    {
        return view('livewire.input.guest-mou-input');
    }
}
