<?php

use App\Http\Controllers\ExcelController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KontrakController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\VendorController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// route::dia mau nampilin apa ngirim apa hapus ? nama controller::class, nama methodnya

// Login
Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/loadLogin', [LoginController::class, 'loadLogin'])->name('loadLogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(
    function () {
        // semua yg sudah login di lindungi auth group biar gabisa tembak akses
        // tampil dashboard
        Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

        // Route::group(['prefix' => 'admin'], function () {
        // Route::prefix('admin')->group(function () {

        // });
        Route::resource('integrate', App\Http\Controllers\KontrakController::class);
        Route::get('/syncData', [KontrakController::class, 'syncron']);
        Route::get('/dataSOP',  [KontrakController::class, 'getdataSOP']);
        Route::get(
            '/dataBarang',
            [KontrakController::class, 'dataBarang']
        )->name('dataBarang');
        Route::get('/dataVendor/{no_vendor}', [KontrakController::class, 'vendor_data'])->name('Vendordata');


        // Input Kontrak & Lampiran
        Route::get('/addKontrak', [KontrakController::class, 'addKontrak'])->name('creatKontrak');
        Route::post('/loadKontrak', [KontrakController::class, 'storeKontrak'])->name('loadKontrak');
        // input lampiran
        Route::get('/addLampiran/{id}', [KontrakController::class, 'addLampiran'])->name('createLampiran');
        // Route::post('addLampiran/{id}', [KontrakController::class, 'storeLampiran1'])->name('storeLampiran1');
        Route::post('/Lampiran1', [KontrakController::class, 'storeLampiran1'])->name('submitLampiran1');
        Route::post('/Lampiran2', [KontrakController::class, 'storeLampiran2'])->name('submitLampiran2');
        Route::post('/Lampiran3', [KontrakController::class, 'storeLampiran3'])->name('submitLampiran3');
        Route::post('/Lampiran4', [KontrakController::class, 'storeLampiran4'])->name('submitLampiran4');
        Route::post('/Lampiran5', [KontrakController::class, 'storeLampiran5'])->name('submitLampiran5');
        Route::post('/Lampiran6', [KontrakController::class, 'storeLampiran6'])->name('submitLampiran6');
        Route::post('/Lampiran7', [KontrakController::class, 'storeLampiran7'])->name('submitLampiran7');

        // MANAGE USER
        // tampil user
        Route::get('/user', [HomeController::class, 'index'])->name('index');
        // Tambah Data User
        Route::get('/addUser', [HomeController::class, 'addUser'])->name('createUser');
        Route::post('/loadUser', [HomeController::class, 'loadUser'])->name('loadUser');
        // Edit Data User
        Route::get('/editUser/{id}', [HomeController::class, 'editUser'])->name('editUser');
        Route::put('/updateUser/{id}', [HomeController::class, 'updateUser'])->name('updateUser');
        // Hapus Data User
        Route::delete('/deleteUser/{id}', [HomeController::class, 'deleteUser'])->name('deleteUser');


        // MANAGE MENU PASAL
        Route::get('/pasal', [HomeController::class, 'vPasal'])->name('vPasal');
        Route::get('/addPasal', [HomeController::class, 'addPasal'])->name('createPasal');
        Route::post('/loadPasal', [HomeController::class, 'loadPasal'])->name('loadPasal');
        // Edit Data Pasal
        Route::get('/editPasal/{id}', [HomeController::class, 'editPasal'])->name('editPasal');
        Route::put('/updatePasal/{id}', [HomeController::class, 'updatePasal'])->name('updatePasal');
        // Hapus Data Pasal
        Route::delete('/deletePasal/{id}', [HomeController::class, 'deletePasal'])->name('deletePasal');
        // tampilkan hasil revisi yang dibuat oleh kasek,kadept,kadiv
        Route::get(
            '/showRevisi/{id}',
            [KontrakController::class, 'showRevisi']
        )->name('viewRevisi');
        // edit lampiran
        Route::get('/updateLampiran/{id}', [KontrakController::class, 'updateLampiran'])->name('editLampiran');
        Route::post('/editLampiran1', [KontrakController::class, 'editLampiran1'])->name('submitEditLampiran1');


        // Monitoring Kontrak
        Route::get('/kontrak', [KontrakController::class, 'indexKontrak'])->name('indexKontrak');

        // ->middleware('role:admin'); //ini middleware pengecekan permission, pemisahnya dengan , misal role:admin,writer,dll
        Route::get('/Printkontrak', [KontrakController::class, 'printKontrak'])->name('printKontrak');

        // Review Kontrak
        Route::get('/review', [KontrakController::class, 'rKontrak'])->name('rKontrak');
        // TAMPIL DETAIL KONTRAK
        Route::get('/detailKontrak/{id}', [KontrakController::class, 'showKontrak'])->name('showKontrak');
        Route::get('/cetakKontrak/{id}', [KontrakController::class, 'cetakKontrak'])->name('cetakKontrak');
        Route::get('/logKontrak/{id}', [KontrakController::class, 'logKontrak'])->name('logKontrak');
        Route::post('/setujuiKontrak/{id}', [KontrakController::class, 'setujuiKontrak'])->name('setujuiKontrak');
        // CREATE REVISI KONTRAK
        Route::get('/addRevisi/{id}', [KontrakController::class, 'addRevisi'])->name('createRevisi');
        Route::post('/loadRevisi', [KontrakController::class, 'storeRevisi'])->name('submitRevisi');
        // Hapus Data Kontrak
        Route::delete('/deleteKontrak/{id}', [KontrakController::class, 'deleteKontrak'])->name('deleteKontrak');

        // vendor
        Route::get('vendor', [VendorController::class, 'index'])->name('vendor.index');
        // route untuk buka view edit vendor untuk get npwp dan ubah akta
        Route::get('vendor/{registration_no}', [VendorController::class, 'edit'])->name('vendor.edit');
        // route untuk loading update vendor
        Route::put('vendor/{registration_no}', [VendorController::class, 'update'])->name('vendor.update');
        // route untuk get data npwp dari api 
        Route::get('/dataNpwp/{no_vendor}', [VendorController::class, 'npwp_data'])->name('npwpdata');

        // route untuk buka view setting update akta peruri
        Route::get('setting/{setting}', [SettingController::class, 'edit'])->name('setting.edit');
        // route untuk loading perubahan akta peruri
        Route::put('setting/{setting}', [SettingController::class, 'update'])->name('setting.update');


        // route  untuk show history revisi kontrak
        Route::get('/historyRevisi/{id}', [KontrakController::class, 'historyRevisiK'])->name('historyRevisiK');

        // route untuk show tabel sop dan tunjukin tiap sop ada berapa PR 
        Route::get('/viewSOP', [KontrakController::class, 'indexSOP'])->name('indexSOP');
        Route::get('/detail/{purchasing_document_number}', [KontrakController::class, 'detailPR'])->name('detailPR');

        // ROUTE untuk Export Kontrak
        // pdf
        Route::get('/ExKontrakPDF', [KontrakController::class, 'ExportKPDF'])->name('ExKontrakPDF');
        Route::get('/ExKontrakPDF=pertanggal/{tglawal}/{tglakhir}', [KontrakController::class, 'ExportKontrakPertanggalPDF'])->name('ExKontrakPDF=pertanggal');
        //route klik buka menu export excel
        Route::get('kontrak/export/', [KontrakController::class, 'viewExport'])->name('viewExport');
        Route::get('/export', [KontrakController::class, 'export'])->name('contracts.export');

        
        // end auth group

    }
);
