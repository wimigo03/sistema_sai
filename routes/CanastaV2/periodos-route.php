<?php
use Illuminate\Support\Facades\Route;

Route::prefix('periodos')->name('periodos.')->middleware(['auth'])->group(function () {
    Route::get('/{id}', 'Canasta_v2\PeriodosV2Controller@index')->name('index')->middleware('can:canasta.paquete.periodo');
    Route::post('store', 'Canasta_v2\PeriodosV2Controller@store')->name('store')->middleware('can:canasta.paquete.periodo');
    Route::get('finalizar/{id}', 'Canasta_v2\PeriodosV2Controller@finalizar')->name('finalizar')->middleware('can:canasta.entregas.finalizar');
    Route::get('eliminar/{id}', 'Canasta_v2\PeriodosV2Controller@eliminar')->name('eliminar')->middleware('can:canasta.periodo.eliminar');
});
