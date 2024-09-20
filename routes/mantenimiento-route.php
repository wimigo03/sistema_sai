<?php

Route::prefix('mantenimientos')->name('mantenimientos.')->middleware(['auth'])->group(function () {
    Route::get('/','MantenimientoController@index')->name('index')->middleware('can:mantenimientos.index');
    Route::get('/search','MantenimientoController@search')->name('search')->middleware('can:mantenimientos.index');
    Route::get('/create','MantenimientoController@create')->name('create')->middleware('can:mantenimientos.index');
    Route::post('/store','MantenimientoController@store')->name('store')->middleware('can:mantenimientos.index');
    /*Route::get('/editar/{control_interno_id}','MantenimientoController@editar')->name('editar')->middleware('can:mantenimientoindex');
    Route::post('/update','MantenimientoController@update')->name('update')->middleware('can:mantenimientoindex');
    Route::get('/anular/{control_interno_id}','MantenimientoController@anular')->name('anular')->middleware('can:mantenimientoindex');
    Route::get('/habilitar/{control_interno_id}','MantenimientoController@habilitar')->name('habilitar')->middleware('can:mantenimientoindex');
    Route::get('/descargar-word/{control_interno_id}','MantenimientoController@descargarWord')->name('descargar.word')->middleware('can:mantenimientoindex');*/
});
