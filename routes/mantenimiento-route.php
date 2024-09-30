<?php

Route::prefix('mantenimientos')->name('mantenimientos.')->middleware(['auth'])->group(function () {
    Route::get('/','MantenimientoController@index')->name('index')->middleware('can:mantenimientos.index');
    Route::get('/search','MantenimientoController@search')->name('search')->middleware('can:mantenimientos.index');
    Route::get('/create','MantenimientoController@create')->name('create')->middleware('can:mantenimientos.index');
    Route::post('/store','MantenimientoController@store')->name('store')->middleware('can:mantenimientos.index');
    Route::get('/show/{mantenimiento_id}','MantenimientoController@show')->name('show')->middleware('can:mantenimientos.index');
    Route::post('/store-detalle','MantenimientoController@storeDetalle')->name('store.detalle')->middleware('can:mantenimientos.index');
    Route::get('/editar/{mantenimiento_id}','MantenimientoController@editar')->name('editar')->middleware('can:mantenimientos.index');
    Route::post('/update','MantenimientoController@update')->name('update')->middleware('can:mantenimientos.index');
    Route::get('/pdf/{mantenimiento_id}','MantenimientoController@pdf')->name('pdf')->middleware('can:mantenimientos.index');
    Route::get('/eliminar_registro/{mantenimiento_detalle_id}', 'MantenimientoController@eliminarRegistro')->name('eliminar_registro')->middleware('can:mantenimientos.index');
    Route::get('/editar-detalle/{mantenimiento_detalle_id}','MantenimientoController@editarDetalle')->name('editarDetalle')->middleware('can:mantenimientos.index');
    Route::post('/update-detalle','MantenimientoController@updateDetalle')->name('updateDetalle')->middleware('can:mantenimientos.index');
});
