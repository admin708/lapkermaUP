<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\{
    LapkermaRefBentukKegiatan,
    DataMouPenggiat,
    DataMoaPenggiat,
    DataIaPenggiat,
    DataMouBentukKegiatanKerjasama,
    DataMou,
    DataMoa,
    DataIa,
    Negara,
    ReferensiBadanKemitraan,
    Fakultas,
    Prodi
};
use Illuminate\Support\Collection;
use Validator;
use Illuminate\Support\Facades\Cache;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // sidebar menu
    public function menu($value)
    {
        return view('MasterApp.Borders', ['PIN' => $value]);
    }

    public function addProdi()
    {
        $data = [
            'fakultasAll' => Fakultas::get()
        ];
        return view('addProdi', $data);
    }

    public function createProdi(Request $request)
    {
        // Validasi input
        $request->validate([
            'fakultas' => 'required',
            'prodi' => 'required',
        ]);
        // dd($request->fakultas);
        $create = Prodi::firstOrCreate([
            'nama_resmi' => strtoupper($request->prodi),
        ], [
            'id_fakultas' => $request->fakultas,
            'is_eksakta' => 1
        ]);

        $data = [
            'fakultasAll' => Fakultas::get()
        ];

        if ($create->wasRecentlyCreated) {
            return redirect()->route('add-prodi', $data)->with('success', 'Data berhasil disimpan!');
        } else {
            return redirect()->route('add-prodi', $data)->with('success', 'Data Duplikat!');
        }
    }

    // sidebar menu
    public function dashboard()
    {
        if (auth()->user()->role_id == 4) {
            return view('MasterApp.Dashboard');
        } else {
            return view('Pages.Dashboard');
        }
    }

    // sidebar menu
    public function mou()
    {
        return view('Pages.Table.mou');
    }

    // sidebar menu
    public function moa()
    {
        return view('Pages.Table.moa');
    }

    // sidebar menu
    public function nonprodi_ia()
    {
        return view('Pages.Table.nonprodi-ia');
    }

    // sidebar menu
    public function nonprodi_moa()
    {
        return view('Pages.Table.nonprodi-moa');
    }
    // sidebar menu
    public function ia()
    {
        return view('Pages.Table.ia');
    }

    public function mou_in()
    {
        if (auth()->user()->role_id == 1) {
            return view('Pages.Input.mou');
        } else {
            return redirect()->route('index');
        }
    }

    // sidebar menu
    public function moa_in($id = null, $val = null)
    {
        return view('Pages.Input.moa', ['id' => $id, 'val' => $val]);
    }

    public function edit_data($val, $id, $mode = null)
    {
        return view('Pages.Edit.index', ['id' => $id, 'val' => $val, 'modeData' => $mode]);
    }

    // sidebar menu
    public function nonprodi_moa_in($id = null, $val = null)
    {
        return view('Pages.Input.nonprodi-moa', ['id' => $id, 'val' => $val]);
    }

    // sidebar menu
    public function ia_in()
    {
        return view('Pages.Input.ia');
    }

    // sidebar menu
    public function InputDataTables()
    {
        return view('Pages.InputDataTables');
    }

    // sidebar menu
    public function sdgs()
    {
        return view('Pages.Sdgs.index');
    }

    // Siderbar menu
    public function iku6()
    {
        return view('Pages.Table.iku6');
    }



    // DaftarMoU
    public function DaftarReqMoU()
    {
        return view('Pages.Table.daftarreqmou');
    }

    public function daftar_req_user()
    {
        return view('Pages.Table.daftarrequser');
    }

    public function ikuScores()
    {
        return view('Pages.Table.iku-score');
    }

    public function kerjaSamaDalamNegeri()
    {
        return view('Pages.Table.kerjasamadalamnegeri');
    }

    public function kerjaSamaLuarNegeri()
    {

        return view('Pages.Table.kerjasamaluarnegeri');
    }

    public function guestMoUInput()
    {
        return view('Pages.Input.guest-mou');
    }

    // edit data
    public function edit($id)
    {
        return view('Pages.EditDataTables', ['id' => $id]);
    }

    // hanya percobaan
    public function store(Request $request)
    {
        //validate data
        $validator = Validator::make(
            $request->all(),
            [
                'title'     => 'required',
                'content'   => 'required',
            ],
            [
                'title.required' => 'Masukkan Title Post !',
                'content.required' => 'Masukkan Content Post !',
            ]
        );

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ], 400);
        } else {

            $post = Post::create([
                'title'     => $request->input('title'),
                'content'   => $request->input('content')
            ]);


            if ($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Post Berhasil Disimpan!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Post Gagal Disimpan!',
                ], 400);
            }
        }
    }

    public function managemen_user()
    {
        return view('Pages.Index.user');
    }

    public function user_non_apps()
    {
        return view('Pages.Index.user-non-apps');
    }

    public function informasi()
    {
        if (auth()->user()->role_id == 1) {
            return view('Pages.Index.layanan-informasi-admin');
        } else {
            $data = [
                'getContact' => ContactInfo::orderBy('orders', 'asc')->get(),
            ];
            return view('Pages.Index.layanan-informasi', $data);
        }
    }

    public function laporan($val = null, $id = null)
    {
        return view('Pages.Input.laporan', ['id' => $id, 'val' => $val]);
    }

    public function getMapData()
    {
        $keyCache = 'map_kerjasama';
        $data2 = Cache::get($keyCache);
        if ($data2) {
            return response()->json([
                'code' => 200,
                'message' => 'OK',
                'data' => $data2
            ]);
        }
        $data2 = [];
        $refNegara = Negara::get();

        foreach ($refNegara as $key => $item) {
            $cek = DataMou::countNegara($item->name) +
                DataMoa::countNegara($item->name) +
                DataIa::countNegara($item->name);
            if ($cek <= 10) {
                $color = '#4d71a8';
            } elseif ($cek <= 50) {
                $color = '#324460';
            } elseif ($cek <= 1000) {
                $color = '#ea8d48';
            } elseif ($cek <= 10000) {
                $color = '#a93138';
            }

            if ($cek > 0) {
                // $this->data2[$item->code2]['link'] = 'https://lapkerma.unhas.ac.id';
                $data2[$item->code2]['link'] = '';
                $data2[$item->code2]['color'] = $color;
                $data2[$item->code2]['total'] = $cek;
            }
        }

        Cache::put($keyCache, $data2, 360);

        return response()->json([
            'code' => 200,
            'message' => 'OK',
            'data' => $data2
        ]);

        // try {
        //     $data = FakultasResource::collection(Fakultas::all());
        //     return response()->json([
        //         'code' => 200,
        //         'message' => 'OK',
        //         'data' => $data
        //     ]);
        // } catch (\Throwable $th) {
        //     return response()->json([
        //         'code' => 404,
        //         'message' => 'Not Found',
        //     ]);
        // }
        // return FakultasResource::collection(Fakultas::all()); // untuk array
    }

    public function getMitra()
    {
        $keyCache = 'mitra_kerjasama';
        $groupedData = Cache::get($keyCache);
        if ($groupedData) {
            return response()->json([
                'code' => 200,
                'message' => 'OK',
                'data' => $groupedData
            ]);
        }
        // cek data penggiat jika error
        $penggiatTanpaKerjasama = DataIaPenggiat::whereDoesntHave('cekid')->get();
        $penggiatTanpaKerjasama1 = DataMoaPenggiat::whereDoesntHave('cekid')->get();
        $penggiatTanpaKerjasama2 = DataMouPenggiat::whereDoesntHave('cekid')->get();
        // dd($penggiatTanpaKerjasama->pluck('id'));

        if (count($penggiatTanpaKerjasama) === 0) {
            if (count($penggiatTanpaKerjasama1) === 0) {
                if (count($penggiatTanpaKerjasama2) === 0) {
                    $data = DataIaPenggiat::whereNot('nama_pihak', 'LIKE', '%universitas hasanuddin%')->get();
                    $data1 = DataMoaPenggiat::whereNot('nama_pihak', 'LIKE', '%universitas hasanuddin%')->get();
                    $data2 = DataMouPenggiat::whereNot('nama_pihak', 'LIKE', '%universitas hasanuddin%')->get();

                    // Menambahkan kolom 'source' ke setiap koleksi
                    $data = $data->map(function ($item) {
                        // $item->data = $item->getDataIa;
                        $item->kategori = $item->getDataIa->jenis_kerjasama;
                        $item->negara = $item->getDataIa->negara;
                        $item->berakhir = $item->getDataIa->tanggal_berakhir;
                        $item->jenis_kerjasama = 'Ia';
                        return $item;
                    });

                    $data1 = $data1->map(function ($item) {
                        // $item->data = $item->getDataMoa;
                        $item->kategori = $item->getDataMoa->jenis_kerjasama;
                        $item->negara = $item->getDataMoa->negara;
                        $item->berakhir = $item->getDataMoa->tanggal_berakhir;
                        $item->jenis_kerjasama = 'MoA';
                        return $item;
                    });

                    $data2 = $data2->map(function ($item) {
                        // $item->data = $item->getDataMou;
                        $item->kategori = $item->getDataMou->jenis_kerjasama;
                        $item->negara = $item->getDataMou->negara;
                        $item->berakhir = $item->getDataMou->tanggal_berakhir;
                        $item->jenis_kerjasama = 'Mou';
                        return $item;
                    });

                    // Menggabungkan ketiga koleksi
                    $combinedData = $data->concat($data1)->concat($data2);

                    $groupedData = collect($combinedData)
                        ->groupBy('nama_pihak')
                        ->map(function ($group) {
                            $maxSource = $group->max('jenis_kerjasama');
                            $status = $group->max('status_pihak');
                            $badan_kemitraan = $group->max('badan_kemitraan');
                            $negara = $group->max('negara');
                            $kategori = $group->max('kategori');
                            $berakhir = $group->max('berakhir');
                            return [
                                'nama_pihak' => $group[0]['nama_pihak'],
                                'jenis_kerjasama' => $maxSource,
                                'status' => $status == 1 ? 'Perguruan Tinggi Negeri' : ($status == 2 ? 'Perguruan Tinggi Swasta' : ($status == 3 ? 'Mitra' : ($status == 4 ? 'Perguruan Tinggi Luar Negeri' : ''))),
                                'badan_kemitraan' => $badan_kemitraan == 1 ? 'Perusahaan Nasional' : ($badan_kemitraan == 2 ? 'Perusahaan Multinasional' : ($badan_kemitraan == 3 ? 'Institusi Pemerintahan (kementrian)' : ($badan_kemitraan == 4 ? 'Pemerintah Daerah (Provinsi/Kabupaten)' : ($badan_kemitraan == 5 ? 'BUMN / BUMD' : $badan_kemitraan)))),
                                'negara' => $negara,
                                'kategori' => $kategori == 1 ? 'Nasional' : ($kategori == 2 ? 'Internasional' : 'Null'),
                                'berakhir' => $berakhir,
                            ];
                        })
                        ->values()
                        ->all();

                    Cache::put($keyCache, $groupedData, 600);
                    return response()->json([
                        'code' => 200,
                        'message' => 'OK',
                        'data' => $groupedData
                    ]);
                } else {
                    return response()->json([
                        'code' => 404,
                        'message' => 'ERROR DATA PENGGIAT MoU',
                        'id_penggiat' => $penggiatTanpaKerjasama2->pluck('id'),
                        'id_mou' => $penggiatTanpaKerjasama2->pluck('id_lapkerma'),
                        'data' => 'error'
                    ]);
                }
            } else {
                return response()->json([
                    'code' => 404,
                    'message' => 'ERROR DATA PENGGIAT MoA',
                    'id_penggiat' => $penggiatTanpaKerjasama1->pluck('id'),
                    'id_moa' => $penggiatTanpaKerjasama1->pluck('id_lapkerma'),
                    'data' => 'error'
                ]);
            }
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'ERROR DATA PENGGIAT IA',
                'id_penggiat' => $penggiatTanpaKerjasama->pluck('id'),
                'id_ia' => $penggiatTanpaKerjasama->pluck('id_lapkerma'),
                'data' => 'error'
            ]);
        }
    }

    public function getDataKerjasama()
    {
        $keyCache = 'data_kerjasama';
        $groupedData = Cache::get($keyCache);

        if ($groupedData) {
            return response()->json([
                'jumlah_data' => count($groupedData),
                'code' => 200,
                'message' => 'OK',
                'data' => $groupedData
            ]);
        }

        // cek data penggiat jika error
        $penggiatTanpaKerjasama = DataIaPenggiat::whereDoesntHave('cekid')->get();
        $penggiatTanpaKerjasama1 = DataMoaPenggiat::whereDoesntHave('cekid')->get();
        $penggiatTanpaKerjasama2 = DataMouPenggiat::whereDoesntHave('cekid')->get();

        if (count($penggiatTanpaKerjasama) === 0) {
            if (count($penggiatTanpaKerjasama1) === 0) {
                if (count($penggiatTanpaKerjasama2) === 0) {
                    $data = DataIaPenggiat::whereNot('nama_pihak', 'LIKE', '%universitas hasanuddin%')->get();
                    $data1 = DataMoaPenggiat::whereNot('nama_pihak', 'LIKE', '%universitas hasanuddin%')->get();
                    $data2 = DataMouPenggiat::whereNot('nama_pihak', 'LIKE', '%universitas hasanuddin%')->get();

                    $data = $data->map(function ($item) {
                        // $item->data = $item->getDataIa;
                        $item->kategori = $item->getDataIa->jenis_kerjasama;
                        $item->negara = $item->getDataIa->negara;
                        $item->berakhir = $item->getDataIa->tanggal_berakhir;
                        $item->jenis_kerjasama = 'Ia';
                        return $item;
                    });

                    $data1 = $data1->map(function ($item) {
                        // $item->data = $item->getDataMoa;
                        $item->kategori = $item->getDataMoa->jenis_kerjasama;
                        $item->negara = $item->getDataMoa->negara;
                        $item->berakhir = $item->getDataMoa->tanggal_berakhir;
                        $item->jenis_kerjasama = 'MoA';
                        return $item;
                    });

                    $data2 = $data2->map(function ($item) {
                        // $item->data = $item->getDataMou;
                        $item->kategori = $item->getDataMou->jenis_kerjasama;
                        $item->negara = $item->getDataMou->negara;
                        $item->berakhir = $item->getDataMou->tanggal_berakhir;
                        $item->jenis_kerjasama = 'Mou';
                        return $item;
                    });

                    // Menggabungkan ketiga koleksi
                    $combinedData = $data->concat($data1)->concat($data2);

                    $groupedData = collect($combinedData)
                        ->groupBy('nama_pihak')
                        ->map(function ($group) {
                            $maxSource = $group->max('jenis_kerjasama');
                            $status = $group->max('status_pihak');
                            $badan_kemitraan = $group->max('badan_kemitraan');
                            $negara = $group->max('negara');
                            $kategori = $group->max('kategori');
                            $berakhir = $group->max('berakhir');
                            return [
                                'nama_pihak' => $group[0]['nama_pihak'],
                                'jenis_kerjasama' => $maxSource,
                                'status' => $status == 1 ? 'Perguruan Tinggi Negeri' : ($status == 2 ? 'Perguruan Tinggi Swasta' : ($status == 3 ? 'Mitra' : ($status == 4 ? 'Perguruan Tinggi Luar Negeri' : ''))),
                                'badan_kemitraan' => $badan_kemitraan == 1 ? 'Perusahaan Nasional' : ($badan_kemitraan == 2 ? 'Perusahaan Multinasional' : ($badan_kemitraan == 3 ? 'Institusi Pemerintahan (kementrian)' : ($badan_kemitraan == 4 ? 'Pemerintah Daerah (Provinsi/Kabupaten)' : ($badan_kemitraan == 5 ? 'BUMN / BUMD' : $badan_kemitraan)))),
                                'negara' => $negara,
                                'kategori' => $kategori == 1 ? 'Nasional' : ($kategori == 2 ? 'Internasional' : 'Null'),
                                'berakhir' => $berakhir,
                            ];
                        })
                        ->values()
                        ->all();
                    Cache::put($keyCache, $groupedData, 1300);
                    return response()->json([
                        'jumlah_data' => count($groupedData),
                        'code' => 200,
                        'message' => 'OK',
                        'data' => $groupedData
                    ]);
                } else {
                    return response()->json([
                        'code' => 404,
                        'message' => 'ERROR DATA PENGGIAT MoU',
                        'id_penggiat' => $penggiatTanpaKerjasama2->pluck('id'),
                        'id_mou' => $penggiatTanpaKerjasama2->pluck('id_lapkerma'),
                        'data' => 'error'
                    ]);
                }
            } else {
                return response()->json([
                    'code' => 404,
                    'message' => 'ERROR DATA PENGGIAT MoA',
                    'id_penggiat' => $penggiatTanpaKerjasama1->pluck('id'),
                    'id_moa' => $penggiatTanpaKerjasama1->pluck('id_lapkerma'),
                    'data' => 'error'
                ]);
            }
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'ERROR DATA PENGGIAT IA',
                'id_penggiat' => $penggiatTanpaKerjasama->pluck('id'),
                'id_ia' => $penggiatTanpaKerjasama->pluck('id_lapkerma'),
                'data' => 'error'
            ]);
        }
    }
}
