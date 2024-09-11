<?php

namespace App\Exports;

use App\Invoice;
use App\Models\DataIaBentukKegiatanKerjasama;
use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class DatatablesExport2 implements FromView
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
        return view('exports.datatables2', [
            'data' => $this->data,
            'fakultas' => Fakultas::get(),
            'prodi' => Prodi::get(),
            'bentuk' => DataIaBentukKegiatanKerjasama::get()
        ]);
    }
}
