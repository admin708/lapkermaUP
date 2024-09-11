<?php

namespace App\Exports;

use App\Invoice;
use App\Models\DataMouBentukKegiatanKerjasama;
use App\Models\Fakultas;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class DatatablesExport3 implements FromView
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
        return view('exports.datatables3', [
            'data' => $this->data,
            'fakultas' => Fakultas::get(),
            'bentuk' => DataMouBentukKegiatanKerjasama::get()
        ]);
    }
}
