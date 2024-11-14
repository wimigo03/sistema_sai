<?php

Route::prefix('salida-almacen')->name('salida.almacen.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Compras\SalidaAlmacenController@index')->name('index')->middleware('can:salida.almacen.index');
    Route::get('search', 'Compras\SalidaAlmacenController@search')->name('search')->middleware('can:salida.almacen.index');
    Route::get('create', 'Compras\SalidaAlmacenController@create')->name('create')->middleware('can:salida.almacen.index');
    Route::post('store', 'Compras\SalidaAlmacenController@store')->name('store')->middleware('can:salida.almacen.index');
});
