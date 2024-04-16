<?php

Route::prefix('almacen')->name('almacen.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Almacenes\AlmacenController@index')->name('index')->middleware('can:almacen.index');
    Route::get('search', 'Almacenes\AlmacenController@search')->name('search')->middleware('can:almacen.index');
    Route::get('create/{dea_id}', 'Almacenes\AlmacenController@create')->name('create')->middleware('can:almacen.create');
    Route::post('store', 'Almacenes\AlmacenController@store')->name('store')->middleware('can:almacen.create');
    Route::get('show/{almacen_id}', 'Almacenes\AlmacenController@show')->name('show')->middleware('can:almacen.show');
    Route::get('editar/{almacen_id}', 'Almacenes\AlmacenController@editar')->name('editar')->middleware('can:almacen.editar');
    Route::post('update', 'Almacenes\AlmacenController@update')->name('update')->middleware('can:almacen.editar');
    Route::get('habilitar/{almacen_id}', 'Almacenes\AlmacenController@habilitar')->name('habilitar')->middleware('can:almacen.habilitar');
    Route::get('deshabilitar/{almacen_id}', 'Almacenes\AlmacenController@deshabilitar')->name('deshabilitar')->middleware('can:almacen.habilitar');
});
