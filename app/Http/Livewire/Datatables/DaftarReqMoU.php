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

    public function searchMoU($uid, $sender)
    {
        $dataMous = MouRequest::query()
            ->when($uid, function ($query) use ($uid) {
                return $query->where('data_mou_request.uuid', 'like', '%' . $uid . '%'); // Filter by searchProdi
            })
            ->when($sender, function ($query) use ($sender) {
                return $query->where('data_mou_request.uploaded_by', 'like', '%' . $sender . '%');
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return $dataMous;
    }

    public function deleteMouRequest($id)
    {
        $mouRequest = MouRequest::find($id);

        // Check if the request exists
        if ($mouRequest) {
            $mouRequest->delete();
        }
    }

    public function render()
    {
        $dataMoUs = $this->searchMoU($this->cariNamaMoU, $this->cariPengirimMoU);

        return view('livewire.datatables.daftar-req-mo-u', [
            'dataMoUs' => $dataMoUs,
        ]);
    }

    public function showDetail($id)
    {
        $this->isEdit = true;
        $this->showModalsEdit = true; // Menampilkan modal detail
        $this->emit('guestInputData', $id);
    }

    public function closeEdit()
    {
        $this->showModalsEdit = false;
    }
}
