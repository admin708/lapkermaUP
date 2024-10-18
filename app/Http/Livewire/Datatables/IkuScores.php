<?php

namespace App\Http\Livewire\Datatables;

use App\Models\DataIaPenggiat;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Prodi;
use Illuminate\Support\Facades\DB;


class IkuScores extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Change this property to protected or private
    protected $DataIa;
    protected $DataSkor;

    public function render()
    {
        $this->DataIa = $this->getDataIa();
        $this->DataSkor = $this->getData();
        return view('livewire.datatables.iku-scores', [
            'DataIa' => $this->DataIa,

            'DataSkor' => $this->DataSkor,
        ]);
    }

    public function getDataIa()
    {

        return DataIaPenggiat::getDataWithJoin('sarjana')->paginate(10);
    }

    public function getData()
    {
        $results = Prodi::select('prodis.id as prodi_id', 'prodis.nama_resmi', DB::raw('ROUND((
        (COALESCE(moa_skor.skor, 0) + COALESCE(ia_skor.skor, 0)) / (
            SELECT COUNT(*) 
            FROM prodis 
            WHERE jenjang = "sarjana"
        ) * 100
    ), 2) AS skor_iku')) // Round to 2 decimal places
            ->leftJoin(DB::raw('(SELECT dm.prodi_id, SUM(rbk.bobot) AS skor
                    FROM data_moa dm
                    LEFT JOIN data_moa_penggiat dmp ON dm.id = dmp.id_lapkerma
                    LEFT JOIN referensi_badan_kemitraans rbk ON rbk.id = dmp.badan_kemitraan
                    GROUP BY dm.prodi_id) as moa_skor'), 'moa_skor.prodi_id', '=', 'prodis.id')
            ->leftJoin(DB::raw('(SELECT di.prodi_id, SUM(rbki.bobot) AS skor
                    FROM data_ia di
                    LEFT JOIN data_ia_penggiat dip ON di.id = dip.id_lapkerma
                    LEFT JOIN referensi_badan_kemitraans rbki ON rbki.id = dip.badan_kemitraan
                    GROUP BY di.prodi_id) as ia_skor'), 'ia_skor.prodi_id', '=', 'prodis.id')
            ->where('prodis.jenjang', 'sarjana')
            ->groupBy('prodis.id', 'prodis.nama_resmi')
            ->orderBy('prodis.id', 'asc')
            ->paginate(10);

        return $results;
    }




    public function getDataIaProperty()
    {
        return $this->DataIa;
    }
}
