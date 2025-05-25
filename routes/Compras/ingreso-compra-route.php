<?php

Route::prefix('ingreso-compra')->name('ingreso.compra.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Compras\IngresoCompraController@index')->name('index')->middleware('can:ingreso.compra.index');
    Route::get('search', 'Compras\IngresoCompraController@search')->name('search')->middleware('can:ingreso.compra.index');
    Route::get('show/{ingreso_compra_id}', 'Compras\IngresoCompraController@show')->name('show')->middleware('can:ingreso.compra.show');
    Route::post('ingresar', 'Compras\IngresoCompraController@ingresar')->name('ingresar')->middleware('can:ingreso.compra.ingresar');
    Route::get('pdf/{ingreso_compra_id}', 'Compras\IngresoCompraController@pdf')->name('pdf')->middleware('can:ingreso.compra.pdf');
});
