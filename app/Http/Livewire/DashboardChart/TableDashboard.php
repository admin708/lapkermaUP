<?php

namespace App\Http\Livewire\DashboardChart;

use Livewire\Component;
use App\Models\{LapkermaRefBentukKegiatan, DataMouPenggiat, DataMoaPenggiat, DataIaPenggiat,
     DataMouBentukKegiatanKerjasama, DataMou, DataMoa, DataIa, Negara, Prodi, ReferensiBadanKemitraan};

class TableDashboard extends Component
{
    public $refBentukKegiatan, $refNegara, $refBadanKemitraan, $data1 = [], $data2 = [], $data3 = [], $year, $fakultas, $prodi;
    public $data4 = [], $data5 = [], $arrayGabung, $getProdi;
    protected $listeners = ['searchBy' => 'searchBy',];

    public function mount()
    {
        $this->refBentukKegiatan = LapkermaRefBentukKegiatan::get();
        $this->refBadanKemitraan = ReferensiBadanKemitraan::get();
        $this->refNegara = Negara::get();
    }
    public function render()
    {
        $this->renderMe();
        // if ($this->year && $this->fakultas) {
        //     $data = [
        //         'totalProdiD34' => $this->getProdi->whereIn('jenjang',['diploma 3','diploma 4'])->count(),
        //         'totalProdiS1' => $this->getProdi->where('jenjang','sarjana')->count(),
        //         'totalProdiProfesi' => $this->getProdi->where('jenjang','profesi')->count(),
        //         'totalProdiS2' => $this->getProdi->where('jenjang','magister')->count(),
        //         'totalProdiS3' => $this->getProdi->where('jenjang','doktor')->count(),
        //         'totalProdiSpesialis' => $this->getProdi->whereIn('jenjang',['spesialis 1','spesialis 2'])->count(),
        //     ];
        // } else {
        //     $data = [];
        // }
        
        
        return view('livewire.dashboard-chart.table-dashboard');
        // return view('livewire.dashboard-chart.table-dashboard', $data);
    }

    public function renderMe()
    {
        foreach ($this->refBentukKegiatan as $key => $item)
        {
            $this->data1[$key]['nama'] = $item->nama;
            $this->data1[$key]['nilai'] = DataMou::countBentukKegiatan($item->id, $this->year, $this->fakultas, $this->prodi) + 
                                        DataMoa::countBentukKegiatan($item->id, $this->year, $this->fakultas, $this->prodi) + 
                                        DataIa::countBentukKegiatan($item->id, $this->year, $this->fakultas, $this->prodi);
        }

        foreach ($this->refNegara as $key => $item)
        {
            $this->data2[$key]['nama'] = $item->name;
            $this->data2[$key]['flag'] = $item->flag;
            $this->data2[$key]['nilai'] = 
                                        DataMou::countNegara($item->name, $this->year, $this->fakultas, $this->prodi) +
                                        DataMoa::countNegara($item->name, $this->year, $this->fakultas, $this->prodi) +
                                        DataIa::countNegara($item->name, $this->year, $this->fakultas, $this->prodi);
        }

        foreach ($this->refBadanKemitraan as $key => $item) {
            if ($item->id != 99) {
                $this->data3[$key]['nama'] = $item->nama;
                $this->data3[$key]['nilai'] = DataMouPenggiat::countBadanKemitraan($item->id, $this->year, $this->fakultas, $this->prodi)->count() +
                                            DataMoaPenggiat::countBadanKemitraan($item->id, $this->year, $this->fakultas, $this->prodi)->count() +
                                            DataIaPenggiat::countBadanKemitraan($item->id, $this->year, $this->fakultas, $this->prodi)->count();
            }
        }
        // foreach ($this->refBadanKemitraan as $key => $item) {
        //     if ($item->id != 99) {
        //         $this->data3[$key]['nama'] = $item->nama;
        //         $this->data3[$key]['nilai'] = DataMou::countBadanKemitraan($item->id, $this->year, $this->fakultas, $this->prodi) +
        //                                     DataMoa::countBadanKemitraan($item->id, $this->year, $this->fakultas, $this->prodi) +
        //                                     DataIa::countBadanKemitraan($item->id, $this->year, $this->fakultas, $this->prodi);
        //     }
        // }
        $this->data4[0]['nama'] = 'PTQS';
        $this->data4[0]['nilai'] = DataMouPenggiat::countPtqs(1, $this->year, $this->fakultas, $this->prodi)->count() +
                                DataMoaPenggiat::countPtqs(1, $this->year, $this->fakultas, $this->prodi)->count() +
                                DataIaPenggiat::countPtqs(1, $this->year, $this->fakultas, $this->prodi)->count();

        $this->data5[0]['nama'] = 'Institusi Pendidikan';
        $this->data5[0]['nilai'] = DataMouPenggiat::countPerguruanTinggi([1,2,4], $this->year, $this->fakultas, $this->prodi)->count() +
                                DataMoaPenggiat::countPerguruanTinggi([1,2,4], $this->year, $this->fakultas, $this->prodi)->count() +
                                DataIaPenggiat::countPerguruanTinggi([1,2,4], $this->year, $this->fakultas, $this->prodi)->count() - 1;

        $this->arrayGabung = array_merge($this->data3, $this->data5);
        // $this->arrayGabung = array_merge($this->data3, $this->data5, $this->data4);

        // $this->sortedArr = collect($this->data1)->sortByDesc('nilai')->all();
    }

    public function searchBy($year, $fakultas, $prodi)
    {
        $this->year = $year;
        $this->fakultas = $fakultas;
        $this->prodi = $prodi;
        $this->renderMe();
        $this->getProdi = Prodi::where('id_fakultas', $fakultas)->orderBy('nama_resmi', 'asc')->get();
    }
}
