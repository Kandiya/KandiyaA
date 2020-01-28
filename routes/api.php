<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which 
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');

// anggota
Route::post('/simpan_anggota', 'Anggotacontroller@store');
Route::put('/ubah_anggota/{id}', 'Anggotacontroller@update');
Route::delete('/hapus_anggota/{id}', 'Anggotacontroller@destroy');
Route::get('/tampil_anggota', 'Anggotacontroller@tampil');

// buku
Route::post('/simpan_buku', 'Bukucontroller@store');
Route::put('/ubah_buku/{id}', 'Bukucontroller@update');
Route::delete('/hapus_buku/{id}', 'Bukucontroller@destroy');
Route::get('/tampil_buku', 'Bukucontroller@tampil');

Route::get('user', 'UserController@getAuthenticatedUser')->middleware('jwt.verify');
