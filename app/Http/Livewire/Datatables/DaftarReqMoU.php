<?php

namespace App\Http\Livewire\Datatables;

use Livewire\Component;
use App\Models\DataMou;
use App\Models\MouRequest;
use Livewire\WithPagination;

class DaftarReqMoU extends Component
{
    use WithPagination;

    public $cariNamaMoU = '';
    public $cariPengirimMoU = '';
    public $sortBy = 'tanggal_ttd';
    public $sortDirection = 'asc';
    public $selectedMoU = null;
    public $showModalsEdit = false;

    protected $updatesQueryString = ['cariNamaMoU', 'cariPengirimMoU', 'sortBy', 'sortDirection'];

    public function updatingCariNamaMoU()
    {
        $this->resetPage();
    }

    public function updatingCariPengirimMoU()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        $this->sortBy = $field;
    }

    public function render()
    {
        $dataMoUs = MouRequest::query()
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.datatables.daftar-req-mo-u', [
            'dataMoUs' => $dataMoUs,
        ]);
    }

    public function showDetail($id)
    {
        $this->selectedMoU = DataMou::find($id);
        $this->showModalsEdit = true; // Menampilkan modal detail
    }

    public function viewDocument($id)
    {
        $document = DataMou::find($id);
        if ($document) {
            return redirect()->away(url('path/to/document/' . $document->file_path));
        }
    }

    public function removeDocument($id)
    {
        $document = DataMou::find($id);
        if ($document) {
            $document->delete();
            session()->flash('message', 'Dokumen berhasil dihapus.');
            $this->resetPage();
        } else {
            session()->flash('error', 'Dokumen tidak ditemukan.');
        }
    }

    public function closeEdit()
    {
        $this->showModalsEdit = false;
    }
}
