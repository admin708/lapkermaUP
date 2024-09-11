<?php

namespace App\Exports;

use App\Invoice;
use App\Models\DataMoaBentukKegiatanKerjasama;
use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Cache;

class DatatablesExport implements FromView
{
    use Exportable;
    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */

    public function view(): View
    {
        return view('exports.datatables', [
            'data' => $this->data,
            'fakultas' => Fakultas::get(),
            'prodi' => Prodi::get(),
            'bentuk' => DataMoaBentukKegiatanKerjasama::get()
        ]);
    }
}
