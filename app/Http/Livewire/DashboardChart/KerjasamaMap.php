<?php

namespace App\Http\Livewire\DashboardChart;

use App\Models\IaPenggiat;
use Livewire\Component;
use App\Models\Instansi;
use App\Models\MoaPenggiat;
use App\Models\MouPenggiat;
use App\Models\Negara;
use Illuminate\Support\Facades\DB;

class KerjasamaMap extends Component
{


    public $negaraName;
    public $dataKerjaSamaNegara;
    public $mapVisibility;

    protected $listeners = ['setNegaraName'];

    public function mount()
    {
        $this->mapVisibility = true;
        // $this->fetchAllNegaraData(); // Memanggil fungsi untuk ambil data semua negara
        $this->fetchNegaraData();
    }

    public function fetchAllNegaraData()
    {
        // Ambil data Instansi dari database tanpa filter negara
        $this->dataKerjaSamaNegara = Instansi::all(['name', 'coordinates']); // Ambil nama dan koordinat instansi

        return $this->dataKerjaSamaNegara;

        // // Kirim data ke frontend
        // $this->emit('dataKerjaSamaNegaraUpdate', $this->dataKerjaSamaNegara)
    }

    public function getNegaraDAta($negaraName = null)
    {
        $results = Instansi::select(
            'instansis.name',
            'instansis.coordinates',
            'instansis.negara_id',
            DB::raw('COALESCE(moa_counts.count, 0) as moa_count'),
            DB::raw('COALESCE(mou_counts.count, 0) as mou_count'),
            DB::raw('COALESCE(ia_counts.count, 0) as ia_count'),
            DB::raw('COALESCE(moa_counts.count, 0) + COALESCE(mou_counts.count, 0) + COALESCE(ia_counts.count, 0) as total_count')
        )
            ->leftJoin('negaras', 'instansis.negara_id', '=', 'negaras.id')
            ->leftJoinSub(
                MoaPenggiat::join('data_moa', 'data_moa.id', '=', 'moa_penggiat.id_lapkerma')
                    ->select('moa_penggiat.id_pihak', DB::raw('COUNT(*) as count'))
                    ->groupBy('moa_penggiat.id_pihak'),
                'moa_counts',
                'moa_counts.id_pihak',
                '=',
                'instansis.id'
            )
            ->leftJoinSub(
                MouPenggiat::join('data_mou', 'data_mou.id', '=', 'mou_penggiat.id_lapkerma')
                    ->select('mou_penggiat.id_pihak', DB::raw('COUNT(*) as count'))
                    ->groupBy('mou_penggiat.id_pihak'),
                'mou_counts',
                'mou_counts.id_pihak',
                '=',
                'instansis.id'
            )
            ->leftJoinSub(
                IaPenggiat::join('data_ia', 'data_ia.id', '=', 'ia_penggiat.id_lapkerma')
                    ->select('ia_penggiat.id_pihak', DB::raw('COUNT(*) as count'))
                    ->groupBy('ia_penggiat.id_pihak'),
                'ia_counts',
                'ia_counts.id_pihak',
                '=',
                'instansis.id'
            )
            ->when($negaraName, function ($query, $negaraName) {
                return $query->where('negaras.name', $negaraName);
            })
            ->where('instansis.name', '!=', 'Universitas Hasanuddin')
            ->orderBy('instansis.name')
            ->get();

        return $results;
    }

    public function setNegaraName($name)
    {
        $this->negaraName = $name;
        $this->fetchNegaraData();
    }

    public function fetchNegaraData()
    {

        $name = $this->negaraName;

        // $idNegara = Negara::where('name', '=', $name)->first();

        // Ambil data Instansi berdasarkan negara
        // $this->dataKerjaSamaNegara = Instansi::where('negara_id', '=', $idNegara->id)->get(['name', 'coordinates']);
        $this->dataKerjaSamaNegara = $this->getNegaraDAta($name);

        // Emit data ke frontend
        $this->emit('dataKerjaSamaNegaraUpdate', $this->dataKerjaSamaNegara);
    }

    public function render()
    {
        // $negaraData = $this->dataKerjaSamaNegara;
        return view('livewire.dashboard-chart.kerjasama-map');
    }
}
