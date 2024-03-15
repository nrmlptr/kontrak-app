<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KontrakController;


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
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/loadLogin', [LoginController::class, 'loadLogin'])->name('loadLogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
// tampil dashboard
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

// Route::group(['prefix' => 'admin'], function () {
Route::prefix('admin')->group(function () {
    Route::resource('integrate', App\Http\Controllers\KontrakController::class);
    Route::get('/syncData', [KontrakController::class, 'syncron']);
    Route::get('/dataSOP',  [KontrakController::class, 'getdataSOP']);
    Route::get('/dataBarang/{po}', [KontrakController::class, 'dataBarang']);
    Route::get('/dataVendor/{no_vendor}', [KontrakController::class, 'vendor_data']);

    // Input Kontrak & Lampiran
    Route::get('/addKontrak', [KontrakController::class, 'addKontrak'])->name('creatKontrak');
    Route::post('/loadKontrak', [KontrakController::class, 'storeKontrak'])->name('loadKontrak');
    // input lampiran1
    Route::get('/addLampiran/{id}', [KontrakController::class, 'addLampiran'])->name('createLampiran');
    Route::post('/Lampiran1', [KontrakController::class, 'storeLampiran1'])->name('submitLampiran1');
    Route::post('/Lampiran2', [KontrakController::class, 'storeLampiran2'])->name('submitLampiran2');




    // MANAGE USER
    // tampil user
    Route::get('/user', [HomeController::class, 'index'])->name('admin.index');
    // Tambah Data User
    Route::get('/addUser', [HomeController::class, 'addUser'])->name('admin.user.createUser');
    Route::post('/loadUser', [HomeController::class, 'loadUser'])->name('admin.user.loadUser');
    // Edit Data User
    Route::get('/editUser/{id}', [HomeController::class, 'editUser'])->name('admin.user.editUser');
    Route::put('/updateUser/{id}', [HomeController::class, 'updateUser'])->name('admin.user.updateUser');
    // Hapus Data User
    Route::delete('/deleteUser/{id}', [HomeController::class, 'deleteUser'])->name('admin.user.deleteUser');
});


// Monitoring Kontrak
Route::get('/kontrak', [KontrakController::class, 'indexKontrak'])->name('indexKontrak');
// tes tampilin pasal 
Route::get('/Printkontrak', [KontrakController::class, 'printKontrak'])->name('printKontrak');
