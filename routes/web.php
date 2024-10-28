<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('index');
})->name('home');

// Route::get('/', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::get('/map', [App\Http\Controllers\AuthController::class, 'map'])->name('map');
Route::get('/search', [App\Http\Controllers\AuthController::class, 'search'])->name('search');
// Route::get('/test', [App\Http\Controllers\AuthController::class, 'test']);
Route::get('login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
Route::get('logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('request', [App\Http\Controllers\AuthController::class, 'master'])->name('request_role');
Route::get('/getDataKerjasama', [App\Http\Controllers\Controller::class, 'getDataKerjasama']);
Route::post('register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::post('/otpVerification', [App\Http\Controllers\AuthController::class, 'verifyOtp'])->name('verifyOtp');

Route::middleware(['auth'])->group(function () {

    // Route::get('index', function () {
    //     return view('MasterApp.Borders',['PIN' => 'index' ]);
    // })->name('index');

    Route::get('/Dashboard', [App\Http\Controllers\AuthController::class, 'pimpinan'])->name('pimpinan');

    Route::get('index', function () {
        return view('Pages.Index.index');
    })->name('index');

    Route::get('/Menu/Dashboard', [App\Http\Controllers\Controller::class, 'dashboard'])->name('dashboard');
    Route::get('/Menu/InputDataTables', [App\Http\Controllers\Controller::class, 'InputDataTables'])->name('InputDataTables');
    Route::get('/Menu/DataMoU', [App\Http\Controllers\Controller::class, 'mou'])->name('mou');
    Route::get('/Menu/DataMoA', [App\Http\Controllers\Controller::class, 'moa'])->name('moa');
    Route::get('/Menu/Data/Edit/{val}/{id}/{mode?}', [App\Http\Controllers\Controller::class, 'edit_data'])->name('edit-data');
    Route::get('/Menu/Data/Laporan/{val}/{id}', [App\Http\Controllers\Controller::class, 'laporan'])->name('laporan');
    Route::get('/Menu/DataIA', [App\Http\Controllers\Controller::class, 'ia'])->name('ia');
    Route::get('/Menu/NonProdi/DataIA', [App\Http\Controllers\Controller::class, 'nonprodi_ia'])->name('nonprodi-ia');
    Route::get('/Menu/NonProdi/DataMoA', [App\Http\Controllers\Controller::class, 'nonprodi_moa'])->name('nonprodi-moa');

    Route::get('/Menu/InputMoU', [App\Http\Controllers\Controller::class, 'mou_in'])->name('mou-in');
    Route::get('/Menu/Input/{id?}/{val?}', [App\Http\Controllers\Controller::class, 'moa_in'])->name('moa-in');
    Route::get('/Menu/Non/Prodi/Input/{id?}/{val?}', [App\Http\Controllers\Controller::class, 'nonprodi_moa_in'])->name('nonprodi-moa-in');
    Route::get('/Menu/InputIa', [App\Http\Controllers\Controller::class, 'ia_in'])->name('ia-in');
    // Route::get('/Menu/{value}', [App\Http\Controllers\Controller::class, 'menu'])->name('menu');
    Route::get('/Menu/User', [App\Http\Controllers\Controller::class, 'managemen_user'])->name('managemen-user');
    Route::get('/Menu/UserNonApps', [App\Http\Controllers\Controller::class, 'user_non_apps'])->name('user-non-apps');

    Route::get('/Menu/Edit/{id}', [App\Http\Controllers\Controller::class, 'edit'])->name('edit');
    Route::get('/Menu/LayananInformasi', [App\Http\Controllers\Controller::class, 'informasi'])->name('informasi');

    Route::get('Menu/GuestInputMoU', [App\Http\Controllers\Controller::class, 'guestMouInput'])->name('guestMouInput');
});

Route::middleware(['auth', 'can:only-admin'])->group(function () {
    // Route yang hanya bisa diakses oleh pengguna dengan role ID 1
    Route::get('/sdgs', [App\Http\Controllers\Controller::class, 'sdgs'])->name('sdgs');
});

//Menampilkan data IKU
Route::middleware(['auth', 'can:only-admin'])->group(function () {
    // Route yang hanya bisa diakses oleh pengguna dengan role ID 1
    Route::get('/iku6', [App\Http\Controllers\Controller::class, 'iku6'])->name('iku6');
});

//Menampilkan data IKU
Route::middleware(['auth', 'can:only-admin'])->group(function () {
    // Route yang hanya bisa diakses oleh pengguna dengan role ID 1
    Route::get('/ikuScores', [App\Http\Controllers\Controller::class, 'ikuScores'])->name('ikuScores');
});


// Route untuk DaftarReqMoU
Route::middleware(['auth', 'can:only-admin'])->group(function () {
    // Route yang hanya bisa diakses oleh pengguna dengan role ID 1
    Route::get('Menu/DaftarReqMoU', [App\Http\Controllers\Controller::class, 'DaftarReqMoU'])->name('DaftarReqMoU');
    Route::get('Menu/DaftarUserReq', [\App\Http\Controllers\Controller::class, 'daftar_req_user'])->name('daftar-req-user');
});



Route::middleware(['auth', 'can:super-power'])->group(function () {
    // Route yang hanya bisa diakses oleh pengguna dengan role ID 1
    Route::get('/add_prodi', [App\Http\Controllers\Controller::class, 'addProdi'])->name('add-prodi');
    Route::post('/add_prodi', [App\Http\Controllers\Controller::class, 'createProdi'])->name('add-prodi');
});
