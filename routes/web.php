<?php

use App\Http\Controllers\Api\EmprestaApi;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'empresta', 'as' => 'empresta'], function () {
    Route::get('instituicoes', [EmprestaApi::class, 'instituicoes'])->name('instituicoes');
    Route::get('convenios', [EmprestaApi::class, 'convenios'])->name('convenios');
    Route::post('simulador-credito', [EmprestaApi::class, 'simuladorCredito'])->name('simulador-credito');
});
