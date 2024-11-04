<?php

namespace App\Http\Livewire\Datatables;

use Livewire\Component;
use App\Models\DataMou;
use App\Models\MouRequest;
use Livewire\WithPagination;

class DaftarReqMoU extends Component
{
    use WithPagination;

    public $reqMoUId;
    public $cariNamaMoU = '';
    public $cariPengirimMoU = '';
    public $sortBy = 'tanggal_ttd';
    public $sortDirection = 'asc';
    public $selectedMoU = null;
    public $showModalsEdit = false;
    public $isEdit = false;

    protected $updatesQueryString = ['cariNamaMoU', 'cariPengirimMoU', 'sortBy', 'sortDirection'];
    public $listeners = ['deleteMouRequest'];

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

    public function deleteMouRequest()
    {
        $mouRequest = MouRequest::find($this->reqMoUId);

        // Check if the request exists
        if ($mouRequest) {
            $mouRequest->delete();
        }
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
        $this->isEdit = true;
        $this->reqMoUId = $id;
        $this->showModalsEdit = true; // Menampilkan modal detail
        $this->emit('guestInputData', $id);
    }

    public function closeEdit()
    {
        $this->showModalsEdit = false;
    }
}
