<?php

namespace App\Http\Livewire\DashboardChart;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\{Lapkerma, DataMou, DataMoa, DataIa};
use Livewire\Component;
use Illuminate\Support\Str;

class Search extends Component
{
    public $search, $alert;
    
    public function render()
    {
        return view('livewire.dashboard-chart.search');
    }
    public function cariKerjasama()
    {
        $aksi = 0;
        $variableTanpaSpasi = str_replace(' ', '', $this->search);

        if ($variableTanpaSpasi == 'universitas') {
            $this->alert = 'Lengkapi Nama Universitas Mitra Kerjasama';
            $aksi++;
        }else{
            // Daftar kata yang ingin diblokir
            $blockedWords = ['hasanuddin', 'unhas'];

            // Pengecekan untuk kata-kata yang diblokir
            foreach ($blockedWords as $word) {
                if (Str::contains(strtolower($this->search), $word)) {
                    $this->alert = 'Masukkan Nama Mitra Universitas Hasanuddin';
                    $aksi++;
                }
            }
        }
        
        if ($aksi == 0) {
            $this->search = trim($this->search);

            $results = DataMoU::select('negara', 'nomor_dok_unhas', 'penggiat', 'this', 'id', 'prodi_id')
            ->where('negara', 'like', '%' . $this->search . '%')
            ->orWhere('nomor_dok_unhas', 'like', '%' . $this->search . '%')
            ->orWhere('penggiat', 'like', '%' . $this->search . '%')
            ->union(
                DataMoA::select('negara', 'nomor_dok_unhas', 'penggiat', 'this', 'id', 'prodi_id')
                    ->where('negara', 'like', '%' . $this->search . '%')
                    ->orWhere('nomor_dok_unhas', 'like', '%' . $this->search . '%')
                    ->orWhere('penggiat', 'like', '%' . $this->search . '%')
            )
            ->union(
                DataIa::select('negara', 'nomor_dok_unhas', 'penggiat', 'this', 'id', 'prodi_id')
                    ->where('negara', 'like', '%' . $this->search . '%')
                    ->orWhere('nomor_dok_unhas', 'like', '%' . $this->search . '%')
                    ->orWhere('penggiat', 'like', '%' . $this->search . '%')
            )
            ->get();

             // Simpan hasil pencarian ke variabel flash
            session()->flash('search_results', $results);

            return redirect()->route('search');
        }
        
    }

    public function updatedSearchProdi()
    {
        $this->emit('searchBy', $this->searchYear, $this->searchFakultas, $this->searchProdi);
    }
}
