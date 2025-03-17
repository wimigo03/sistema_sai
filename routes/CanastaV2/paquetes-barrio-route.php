<?php
use Illuminate\Support\Facades\Route;

Route::prefix('paquetes-barrio')->name('paquetes.barrio.')->middleware(['auth'])->group(function () {
    Route::get('/{paquete_id}', 'Canasta_v2\PaqueteBarrioV2Controller@index')->name('index')->middleware('can:canasta.paquetes.barrio.index');
    Route::get('/get_barrios/{paquete_id}', 'Canasta_v2\PaqueteBarrioV2Controller@getBarrios')->name('get.barrios')->middleware('can:canasta.paquetes.barrio.index');
    Route::get('/search/{paquete_id}', 'Canasta_v2\PaqueteBarrioV2Controller@search')->name('search')->middleware('can:canasta.paquetes.barrio.index');
    Route::get('/pdf/{paquete_id}', 'Canasta_v2\PaqueteBarrioV2Controller@pdf')->name('pdf')->middleware('can:canasta.paquetes.barrio.pdf');
    Route::get('/excel/{paquete_id}', 'Canasta_v2\PaqueteBarrioV2Controller@excel')->name('excel')->middleware('can:canasta.paquetes.barrio.excel');
    Route::get('create/{paquete_id}', 'Canasta_v2\PaqueteBarrioV2Controller@create')->name('create')->middleware('can:canasta.paquetes.barrio.create');
    Route::post('store/{paquete_id}', 'Canasta_v2\PaqueteBarrioV2Controller@store')->name('store')->middleware('can:canasta.paquetes.barrio.create');
    Route::get('/editar/{paquete_barrio_id}', 'Canasta_v2\PaqueteBarrioV2Controller@editar')->name('editar')->middleware('can:canasta.paquetes.barrio.editar');
    Route::post('update', 'Canasta_v2\PaqueteBarrioV2Controller@update')->name('update')->middleware('can:canasta.paquetes.barrio.editar');
});
