<?php

use App\Http\Controllers\ExcelController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KontrakController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\URL;

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
// =====================================================================================================================
// route::dia mau nampilin apa ngirim apa hapus ? nama controller::class, nama methodnya
// =====================================================================================================================
// Login
Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/loadLogin', [LoginController::class, 'loadLogin'])->name('loadLogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/syncData', [KontrakController::class, 'syncron']);

Route::middleware('auth')->group(
    function () {
        // semua yg sudah login di lindungi auth group biar gabisa tembak akses
        // tampil dashboard
        Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
        Route::resource('integrate', App\Http\Controllers\KontrakController::class);
        Route::get('/dataSOP',  [KontrakController::class, 'getdataSOP']);
        Route::get(
            '/dataBarang',
            [KontrakController::class, 'dataBarang']
        )->name('dataBarang');
        Route::get('/dataVendor/{no_vendor}', [KontrakController::class, 'vendor_data'])->name('Vendordata');

        //====================================================================================================================

        // Input Kontrak
        Route::get('/addKontrak', [KontrakController::class, 'addKontrak'])
            ->name('creatKontrak')
            ->middleware('permission:view-addKontrak');

        Route::post('/loadKontrak', [KontrakController::class, 'storeKontrak'])->name('loadKontrak');

        // ===================================================================================================================
        // input lampiran
        Route::get('/addLampiran/{id}', [KontrakController::class, 'addLampiran'])
            ->name('createLampiran')
            ->middleware('permission:view-inputLampiran');
        // Route::post('addLampiran/{id}', [KontrakController::class, 'storeLampiran1'])->name('storeLampiran1');
        Route::post('/Lampiran1', [KontrakController::class, 'storeLampiran1'])->name('submitLampiran1');
        Route::post('/Lampiran2', [KontrakController::class, 'storeLampiran2'])->name('submitLampiran2');
        Route::post('/Lampiran3', [KontrakController::class, 'storeLampiran3'])->name('submitLampiran3');
        Route::post('/Lampiran4', [KontrakController::class, 'storeLampiran4'])->name('submitLampiran4');
        Route::post('/Lampiran5', [KontrakController::class, 'storeLampiran5'])->name('submitLampiran5');
        Route::post('/Lampiran6', [KontrakController::class, 'storeLampiran6'])->name('submitLampiran6');
        Route::post('/Lampiran7', [KontrakController::class, 'storeLampiran7'])->name('submitLampiran7');

        // ===================================================================================================================

        // MANAGE USER
        Route::get('/user', [HomeController::class, 'index'])
            ->name('index')
            ->middleware('permission:viewUser');
        // ===============================================================================================

        // Tambah Data User
        Route::get('/addUser', [HomeController::class, 'addUser'])
            ->name('createUser')
            ->middleware('permission:view-addUser');
        Route::post('/loadUser', [HomeController::class, 'loadUser'])->name('loadUser');
        // ===============================================================================================

        // Edit Data User
        Route::get('/editUser/{id}', [HomeController::class, 'editUser'])
            ->name('editUser')
            ->middleware('permission:view-editUser');
        Route::put('/updateUser/{id}', [HomeController::class, 'updateUser'])->name('updateUser');

        // ===============================================================================================

        // Hapus Data User
        Route::delete('/deleteUser/{id}', [HomeController::class, 'deleteUser'])
            ->name('deleteUser')
            ->middleware('permission:view-deleteUser');
        // ===================================================================================================================

        // MANAGE MENU PASAL
        Route::get('/pasal', [HomeController::class, 'vPasal'])
            ->name('vPasal')
            ->middleware('permission:viewPasal');

        // ===============================================================================================

        Route::get('/addPasal', [HomeController::class, 'addPasal'])
            ->name('createPasal')
            ->middleware('permission:view-addPasal');
        Route::post('/loadPasal', [HomeController::class, 'loadPasal'])->name('loadPasal');

        // ===============================================================================================

        // Edit Data Pasal
        Route::get('/editPasal/{id}', [HomeController::class, 'editPasal'])
            ->name('editPasal')
            ->middleware('permission:view-editPasal');
        Route::put('/updatePasal/{id}', [HomeController::class, 'updatePasal'])->name('updatePasal');

        // ===============================================================================================

        // Hapus Data Pasal
        Route::delete('/deletePasal/{id}', [HomeController::class, 'deletePasal'])
            ->name('deletePasal')
            ->middleware('permission:view-deletePasal');

        // ===================================================================================================================

        // tampilkan hasil revisi yang dibuat oleh kasek,kadept,kadiv
        Route::get('/showRevisi/{id}', [KontrakController::class, 'showRevisi'])->name('viewRevisi');
        // tampilkan revisi ketika di klik dari notif
        Route::get('/showRevisiNotif/{id}', [KontrakController::class, 'showNotifRevisi'])->name('showNotifRevisi');
        // ===================================================================================================================
        // edit lampiran oleh staff atau admin
        Route::get('/updateLampiran/{id}', [KontrakController::class, 'updateLampiran'])
            ->name('editLampiran')
            ->middleware('permission:view-editLampiran');

        Route::post('/editLampiran1', [KontrakController::class, 'editLampiran1'])->name('submitEditLampiran1');

        // ===================================================================================================================
        // Monitoring Kontrak
        Route::get('/kontrak', [KontrakController::class, 'indexKontrak'])->name('indexKontrak');
        // ->middleware('role:admin'); //ini middleware pengecekan permission, pemisahnya dengan , misal role:admin,writer,dll
        // ===================================================================================================================

        // Review Kontrak
        Route::get('/review', [KontrakController::class, 'rKontrak'])
            ->name('rKontrak')
            ->middleware('permission:view-ReviewKontrak');

        // ===================================================================================================================

        // TAMPIL DETAIL KONTRAK
        Route::get('/detailKontrak/{id}', [KontrakController::class, 'showKontrak'])->name('showKontrak');

        // ===================================================================================================================

        // TAMPIL DETAIL KONTRAK ketika ada approved
        Route::get('/showKontrakNotif/{id}', [KontrakController::class, 'showKontrakNotif'])->name('showKontrakNotif');

        // ===================================================================================================================

        // tampil kontrak detail ketika pembuat berhasil bikin kontrak untuk notif ke kasek
        Route::get('/Kontrakshow1/{id}', [KontrakController::class, 'Kontrakshow1'])->name('Kontrakshow1');

        // ===================================================================================================================

        // ROUTE TAMPIL DETAIL KONTRAK KETIKA DI UPDATE UNTUK NOTIF KE KASEK
        Route::get('/showUpdateKontrak/{id}', [KontrakController::class, 'showUpdateKontrak'])->name('showUpdateKontrak');

        // ===================================================================================================================

        // route cetak kontrak pdf per 1 kontrak
        Route::get('/cetakKontrak/{id}', [KontrakController::class, 'cetakKontrak'])->name('cetakKontrak');

        // ===================================================================================================================

        // tombol view log perjalanan pembuatan kontrak dari awal hingga approved kadiv
        Route::get('/logKontrak/{id}', [KontrakController::class, 'logKontrak'])->name('logKontrak');
        // ===================================================================================================================

        // tombol setujui kontrak
        Route::post('/setujuiKontrak/{id}', [KontrakController::class, 'setujuiKontrak'])
            ->name('setujuiKontrak')
            ->middleware('permission:view-SubmitKontrak');

        // ===================================================================================================================

        // CREATE REVISI KONTRAK
        Route::get('/addRevisi/{id}', [KontrakController::class, 'addRevisi'])
            ->name('createRevisi')
            ->middleware('permission:view-addRevisi');
        Route::post('/loadRevisi', [KontrakController::class, 'storeRevisi'])->name('submitRevisi');

        //====================================================================================================================     
        // Hapus Data Kontrak
        Route::delete('/deleteKontrak/{id}', [KontrakController::class, 'deleteKontrak'])
            ->name('deleteKontrak')
            ->middleware('permission:view-deteleKontrak');
        //====================================================================================================================     

        // vendor
        Route::get('vendor', [VendorController::class, 'index'])->name('vendor.index');

        //====================================================================================================================

        // route untuk buka view edit vendor untuk get npwp dan ubah akta
        Route::get('vendor/{registration_no}', [VendorController::class, 'edit'])->name('vendor.edit');
        // route untuk loading update vendor
        Route::put('vendor/{registration_no}', [VendorController::class, 'update'])->name('vendor.update');

        //====================================================================================================================

        // route untuk get data npwp dari api 
        Route::get('/dataNpwp/{no_vendor}', [VendorController::class, 'npwp_data'])->name('npwpdata');
        // route untuk get data nama pejabat vendor dari api 
        Route::get('/dataPejabatVendor/{no_vendor}', [VendorController::class, 'Pejabat_vendor'])->name('dataPejabatVendor');
        // route untuk get data alamat vendor untuk contoh tampilan di form akta
        Route::get('/dataAlamatVendor/{no_vendor}', [VendorController::class, 'Alamat_vendor'])->name('dataAlamatVendor');

        //====================================================================================================================

        // route untuk buka view setting update akta peruri
        Route::get('setting/{setting}', [SettingController::class, 'edit'])->name('setting.edit');
        // route untuk loading perubahan akta peruri
        Route::put('setting/{setting}', [SettingController::class, 'update'])->name('setting.update');

        //====================================================================================================================

        // route  untuk show history revisi kontrak
        Route::get('/historyRevisi/{id}', [KontrakController::class, 'historyRevisiK'])->name('historyRevisiK');

        //====================================================================================================================

        // route untuk show tabel sop dan tunjukin tiap sop ada berapa PR 
        Route::get('/viewSOP', [KontrakController::class, 'indexSOP'])->name('indexSOP');
        Route::get('/detail/{purchasing_document_number}', [KontrakController::class, 'detailPR'])->name('detailPR');

        //====================================================================================================================

        // ROUTE untuk Export Kontrak
        // pdf
        Route::get('/ExKontrakPDF', [KontrakController::class, 'ExportKPDF'])->name('ExKontrakPDF');
        Route::get('/ExKontrakPDF=pertanggal/{tglawal}/{tglakhir}', [KontrakController::class, 'ExportKontrakPertanggalPDF'])->name('ExKontrakPDF=pertanggal');

        //====================================================================================================================
        //route klik buka menu export excel
        Route::get('kontrak/export/', [KontrakController::class, 'viewExport'])->name('viewExport');
        Route::get('/export', [KontrakController::class, 'export'])->name('contracts.export');

        //====================================================================================================================

        // ROUTE VIEW KONTRAK JUST APPROVEDKADIV UNTUK UPLOAD FITUR
        Route::get('/kontrak-upload', [KontrakController::class, 'KontrakAK'])->name('KontrakAK');

        //====================================================================================================================
        // route upload doc kontrak yang sudah di ttd
        Route::post('/loadUpload/{id}', [KontrakController::class, 'storeUploadKontrak'])->name('loadUpload');

        //====================================================================================================================

        // route untuk download doc kontrak nya
        Route::get('/downloadKontrakTTD/{id}', [KontrakController::class, 'downloadDocKontrak'])->name('downloadKontrak');

        //====================================================================================================================

        // route datatable download button
        Route::get('/get-logged-in-user-role', [KontrakController::class, 'getLoggedInUserRole']);

        //====================================================================================================================

        // ROUTE VIEW KONTRAK YANG ON PROCESS
        Route::get('/kontrak-onprocess', [KontrakController::class, 'KontrakonProcess'])->name('KontrakonProcess');

        //====================================================================================================================

        // manage role 
        Route::get('/role', [RoleController::class, 'index'])
            ->name('role')
            ->middleware('permission:viewRole');

        //====================================================================================================================

        // Tambah Data Role
        Route::get('/addRole', [RoleController::class, 'create'])
            ->name('createRole')
            ->middleware('permission:view-addRole');
        Route::post('/loadRole', [RoleController::class, 'store'])->name('loadRole');

        //====================================================================================================================

        // detail Role
        Route::get('/infoRole/{id}', [RoleController::class, 'show'])->name('infoRole');
        //====================================================================================================================

        // edit role
        Route::get('/editRole/{id}', [RoleController::class, 'edit'])
            ->name('editRole')
            ->middleware('permission:view-editRole');
        Route::put('/updateRole/{id}', [RoleController::class, 'update'])->name('updateRole');

        //====================================================================================================================
        // Hapus Data Role
        Route::delete('/deleteRole/{id}', [RoleController::class, 'delete'])
            ->name('deleteRole')
            ->middleware('permission:view-deleteRole');

        // ====================================================================================================================
        // manage permission 
        Route::get('/permission', [PermissionController::class, 'index'])
            ->name('permissions')
            ->middleware('permission:viewPermission');

        // =====================================================================================================================

        // Tambah Data permission
        Route::get('/addPermission', [PermissionController::class, 'create'])->name('createPermission');
        Route::post('/loadPermission', [PermissionController::class, 'store'])->name('loadPermission');
        // =====================================================================================================================

        //Edit Permission
        Route::get('/editPermission/{id}', [PermissionController::class, 'edit'])->name('editPermission');
        Route::put('/updatePermission/{id}', [PermissionController::class, 'update'])->name('updatePermission');

        // =====================================================================================================================

        // Hapus Data Permission
        Route::delete('/deletePermission/{id}', [PermissionController::class, 'delete'])->name('deletePermission');

        // =====================================================================================================================



        // end auth group

    }



);
