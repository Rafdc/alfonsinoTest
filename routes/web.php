<?php

use App\Http\Controllers\OrdiniController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProdottiController;
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
    return view('auth.login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
    Partner routes
*/
Route::prefix('partner')->group(function(){
    Route::get('/show', [PartnerController::class, 'show'])->name('showPartner');
    Route::get('/form/{id?}', [PartnerController::class, 'formPartner'])->name('formPartner');
    Route::post('/addUpdate', [PartnerController::class, 'addUpdatePartner'])->name('addOrUpdatePartner');
    Route::get('/detail/{id}', [PartnerController::class, 'detailPartner'])->name('detailPartner');
    Route::get('/delete/{id}', [PartnerController::class, 'delete'])->name('deletePartner');
    Route::get('/listino/{idPartner}/{idProdottoAssociato?}', [PartnerController::class, 'listinoPartner'])->name('listino');
    Route::post('/createListino', [PartnerController::class, 'createListino'])->name('createListino');
    Route::get('/deleteAssociazioneProdotto/{idPartner}/{idProdottoAssociato}', [PartnerController::class, 'deleteAssociazioneProdotto'])->name('deleteAssociazioneProdotto');
});

Route::prefix('prodotto')->group(function(){
    Route::get('/show', [ProdottiController::class, 'show'])->name('showProdotti');
    Route::get('/form/{id?}', [ProdottiController::class, 'formProdotto'])->name('formProdotto');
    Route::post('/addUpdate', [ProdottiController::class, 'addUpdateProdoto'])->name('addOrUpdateProdotto');
    Route::get('/delete/{id}', [ProdottiController::class, 'delete'])->name('deleteProdotto');
});

Route::prefix('ordini')->group(function(){
    Route::get('/show', [OrdiniController::class, 'show'])->name('showOrdini');
    Route::get('/detail/{id}', [OrdiniController::class, 'detail'])->name('detailOrdine');
});

Auth::routes();
