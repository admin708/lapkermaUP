<?php

namespace App\Http\Livewire\Datatables;

use Livewire\Component;
use App\Models\DataMou;
use App\Models\DataMouPenggiat;
use App\Models\MouPenggiat;
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
        $dataMous = DataMou::query()
            ->when($uid, function ($query) use ($uid) {
                return $query->where('uuid', 'like', '%' . $uid . '%'); // Filter by searchProdi
            })
            ->when($sender, function ($query) use ($sender) {
                return $query->where('uploaded_by', 'like', '%' . $sender . '%');
            })
            ->where('level', '=', 0)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return $dataMous;
    }

    public function deleteMouRequest($id)
    {
        $mouRequest = DataMou::find($id);

        $DataMouPenggiat = DataMouPenggiat::where('id_lapkerma', '=', $id)->get();
        foreach ($DataMouPenggiat as $data) {
            $data->delete();
        }

        $MouPenggiat = MouPenggiat::where('id_lapkerma', '=', $id)->get();
        foreach ($MouPenggiat as $data) {
            $data->delete();
        }

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
        $this->showModalsEdit = true;
        $this->emit('getEditData', $id);
    }

    public function closeEdit()
    {
        $this->showModalsEdit = false;
    }
}
