<?php

Route::prefix('tipocomingreso')->name('tipocomingreso.')->middleware(['auth'])->group(function () { 
 

    Route::get('index', 'Almacen\Comprobante\TipocomingresoController@index')->name('index');
    Route::get('list', 'Almacen\Comprobante\TipocomingresoController@listado')->name('list');
    Route::get('{id}/edit', 'Almacen\Comprobante\TipocomingresoController@editar')->name('edit');
    Route::POST('{id}/update', 'Almacen\Comprobante\TipocomingresoController@update')->name('update');
    Route::get('create', 'Almacen\Comprobante\TipocomingresoController@create')->name('create');
    Route::POST('store', 'Almacen\Comprobante\TipocomingresoController@store')->name('store');
 
});