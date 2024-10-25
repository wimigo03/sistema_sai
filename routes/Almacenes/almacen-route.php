<?php

Route::prefix('almacen')->name('almacen.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Almacenes\AlmacenController@index')->name('index')->middleware('can:almacen.index');
    Route::get('search', 'Almacenes\AlmacenController@search')->name('search')->middleware('can:almacen.index');
    Route::get('create', 'Almacenes\AlmacenController@create')->name('create')->middleware('can:almacen.create');
    Route::post('store', 'Almacenes\AlmacenController@store')->name('store')->middleware('can:almacen.create');
    /* Route::get('show/{almacen_id}', 'Almacenes\AlmacenController@show')->name('show')->middleware('can:almacen.show');
    Route::get('show-search/{almacen_id}', 'Almacenes\AlmacenController@showSearch')->name('show.search')->middleware('can:almacen.show'); */
    Route::get('editar/{almacen_id}', 'Almacenes\AlmacenController@editar')->name('editar')->middleware('can:almacen.editar');
    Route::post('update', 'Almacenes\AlmacenController@update')->name('update')->middleware('can:almacen.editar');
    Route::get('habilitar/{almacen_id}', 'Almacenes\AlmacenController@habilitar')->name('habilitar')->middleware('can:almacen.habilitar');
    Route::get('deshabilitar/{almacen_id}', 'Almacenes\AlmacenController@deshabilitar')->name('deshabilitar')->middleware('can:almacen.habilitar');
    Route::get('asignar/{almacen_id}', 'Almacenes\AlmacenController@asignar')->name('asignar')->middleware('can:almacen.asignar');
    Route::post('asignar-store', 'Almacenes\AlmacenController@asignarStore')->name('asignar.store')->middleware('can:almacen.asignar');
    Route::get('eliminar-area/{area_id}', 'Almacenes\AlmacenController@eliminarArea')->name('eliminar.area')->middleware('can:almacen.asignar');
});
