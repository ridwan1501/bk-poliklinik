<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('dashboard', [AuthController::class, 'dashboard']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');



Route::group(['middleware' => 'auth', 'as' => 'backoffice.', 'prefix' => 'backoffice'], function () {
    Route::get('/', function () {
        return view('backoffice.dashboard');
    });

    // PaymentMethod
    Route::get('payment_methods', ['as' => 'payment_methods.index', 'uses' => 'App\Http\Controllers\PaymentMethodController@index']);
    Route::post('payment_methods/data', ['as' => 'payment_methods.data', 'uses' => 'App\Http\Controllers\PaymentMethodController@data']);
    Route::post('payment_methods', ['as' => 'payment_methods.store', 'uses' => 'App\Http\Controllers\PaymentMethodController@store']);
    Route::put('payment_methods/{id}', ['as' => 'payment_methods.update', 'uses' => 'App\Http\Controllers\PaymentMethodController@update']);
    Route::delete('payment_methods/{id}', ['as' => 'payment_methods.destroy', 'uses' => 'App\Http\Controllers\PaymentMethodController@destroy']);

    // POLI
    Route::get('poli', ['as' => 'poli.index', 'uses' => 'App\Http\Controllers\PoliController@index']);
    Route::post('poli/data', ['as' => 'poli.data', 'uses' => 'App\Http\Controllers\PoliController@data']);
    Route::post('poli', ['as' => 'poli.store', 'uses' => 'App\Http\Controllers\PoliController@store']);
    Route::put('poli/{id}', ['as' => 'poli.update', 'uses' => 'App\Http\Controllers\PoliController@update']);
    Route::delete('poli/{id}', ['as' => 'poli.destroy', 'uses' => 'App\Http\Controllers\PoliController@destroy']);

    // Dokter
    Route::get('dokter', ['as' => 'dokter.index', 'uses' => 'App\Http\Controllers\DokterController@index']);
    Route::post('dokter/data', ['as' => 'dokter.data', 'uses' => 'App\Http\Controllers\DokterController@data']);
    Route::post('dokter', ['as' => 'dokter.store', 'uses' => 'App\Http\Controllers\DokterController@store']);
    Route::put('dokter/{id}', ['as' => 'dokter.update', 'uses' => 'App\Http\Controllers\DokterController@update']);
    Route::delete('dokter/{id}', ['as' => 'dokter.destroy', 'uses' => 'App\Http\Controllers\DokterController@destroy']);
    Route::get('dokter/edit', ['as' => 'dokter.edit', 'uses' => 'App\Http\Controllers\DokterController@edit']);
    Route::post('dokter/update-profil', ['as' => 'dokter.updateProfil', 'uses' => 'App\Http\Controllers\DokterController@updateProfil']);

    // Jadwal Periksa
    Route::get('jadwal_periksa', ['as' => 'jadwal_periksa.index', 'uses' => 'App\Http\Controllers\JadwalPeriksaController@index']);
    Route::post('jadwal_periksa/data', ['as' => 'jadwal_periksa.data', 'uses' => 'App\Http\Controllers\JadwalPeriksaController@data']);
    Route::post('jadwal_periksa', ['as' => 'jadwal_periksa.store', 'uses' => 'App\Http\Controllers\JadwalPeriksaController@store']);
    Route::put('jadwal_periksa/{id}', ['as' => 'jadwal_periksa.update', 'uses' => 'App\Http\Controllers\JadwalPeriksaController@update']);
    Route::delete('jadwal_periksa/{id}', ['as' => 'jadwal_periksa.destroy', 'uses' => 'App\Http\Controllers\JadwalPeriksaController@destroy']);

    // Pasien
    Route::get('pasien', ['as' => 'pasien.index', 'uses' => 'App\Http\Controllers\PasienController@index']);
    Route::post('pasien/data', ['as' => 'pasien.data', 'uses' => 'App\Http\Controllers\PasienController@data']);
    Route::post('pasien', ['as' => 'pasien.store', 'uses' => 'App\Http\Controllers\PasienController@store']);
    Route::put('pasien/{id}', ['as' => 'pasien.update', 'uses' => 'App\Http\Controllers\PasienController@update']);
    Route::delete('pasien/{id}', ['as' => 'pasien.destroy', 'uses' => 'App\Http\Controllers\PasienController@destroy']);

    // Obat
    Route::get('obat', ['as' => 'obat.index', 'uses' => 'App\Http\Controllers\ObatController@index']);
    Route::post('obat/data', ['as' => 'obat.data', 'uses' => 'App\Http\Controllers\ObatController@data']);
    Route::post('obat', ['as' => 'obat.store', 'uses' => 'App\Http\Controllers\ObatController@store']);
    Route::put('obat/{id}', ['as' => 'obat.update', 'uses' => 'App\Http\Controllers\ObatController@update']);
    Route::delete('obat/{id}', ['as' => 'obat.destroy', 'uses' => 'App\Http\Controllers\ObatController@destroy']);

    // Registrasi
    Route::get('registrasi', ['as' => 'registrasi.index', 'uses' => 'App\Http\Controllers\RegistrasiController@index']);
    Route::get('registrasi/detail/{id}', ['as' => 'registrasi.detail', 'uses' => 'App\Http\Controllers\RegistrasiController@detail']);
    Route::post('registrasi/data', ['as' => 'registrasi.data', 'uses' => 'App\Http\Controllers\RegistrasiController@data']);
    Route::get('registrasi/history', ['as' => 'registrasi.history', 'uses' => 'App\Http\Controllers\RegistrasiController@history']);
    Route::post('registrasi/data_dokter', ['as' => 'registrasi.data_dokter', 'uses' => 'App\Http\Controllers\RegistrasiController@dataDokter']);
    Route::post('registrasi/data_poli', ['as' => 'registrasi.data_poli', 'uses' => 'App\Http\Controllers\RegistrasiController@dataPoli']);
    Route::post('registrasi/data_jadwal_periksa', ['as' => 'registrasi.data_jadwal_periksa', 'uses' => 'App\Http\Controllers\RegistrasiController@dataJadwalPeriksa']);
    Route::post('registrasi/store', ['as' => 'registrasi.store', 'uses' => 'App\Http\Controllers\RegistrasiController@store']);
    Route::post('registrasi/upsert-periksa', ['as' => 'registrasi.upsert-periksa', 'uses' => 'App\Http\Controllers\RegistrasiController@upsertPeriksa']);

    // User
    Route::get('users', ['as' => 'users.index', 'uses' => 'App\Http\Controllers\UserController@index']);
    Route::post('users/data', ['as' => 'users.data', 'uses' => 'App\Http\Controllers\UserController@data']);
    Route::post('users', ['as' => 'users.store', 'uses' => 'App\Http\Controllers\UserController@store']);
    Route::put('users/{id}', ['as' => 'users.update', 'uses' => 'App\Http\Controllers\UserController@update']);
    Route::delete('users/{id}', ['as' => 'users.destroy', 'uses' => 'App\Http\Controllers\UserController@destroy']);

    // Pasien
    Route::get('antrian', ['as' => 'antrian.index', 'uses' => 'App\Http\Controllers\AntrianController@index']);
    Route::post('antrian/data-menunggu', ['as' => 'antrian.data-menunggu', 'uses' => 'App\Http\Controllers\AntrianController@dataMenunggu']);
    Route::put('antrian/panggil/{id}', ['as' => 'antrian.panggil', 'uses' => 'App\Http\Controllers\AntrianController@panggil']);

    Route::get('antrian/display', ['as' => 'antrian.display', 'uses' => 'App\Http\Controllers\AntrianController@display']);
    Route::post('antrian/data-display', ['as' => 'antrian.data-display', 'uses' => 'App\Http\Controllers\AntrianController@dataDisplay']);
    Route::post('antrian/selesai-display/{id}', ['as' => 'antrian.selesai-display', 'uses' => 'App\Http\Controllers\AntrianController@selesaiDisplay']);
});
