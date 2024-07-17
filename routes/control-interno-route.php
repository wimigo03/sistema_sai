<?php

Route::prefix('control-interno')->name('control.interno.')->middleware(['auth'])->group(function () {
    Route::get('/','ControlInternoController@index')->name('index')->middleware('can:control.interno.index');
    Route::get('/search','ControlInternoController@search')->name('search')->middleware('can:control.interno.index');
    Route::get('/create','ControlInternoController@create')->name('create')->middleware('can:control.interno.index');
    Route::get('/get_datos_tipo', 'ControlInternoController@getDatosTipo')->name('get.datos.tipo')->middleware('can:control.interno.index');
    Route::post('/store','ControlInternoController@store')->name('store')->middleware('can:control.interno.index');
    Route::get('/editar/{control_interno_id}','ControlInternoController@editar')->name('editar')->middleware('can:control.interno.index');
    Route::post('/update','ControlInternoController@update')->name('update')->middleware('can:control.interno.index');
    Route::get('/anular/{control_interno_id}','ControlInternoController@anular')->name('anular')->middleware('can:control.interno.index');
    Route::get('/habilitar/{control_interno_id}','ControlInternoController@habilitar')->name('habilitar')->middleware('can:control.interno.index');
    Route::get('/descargar-word/{control_interno_id}','ControlInternoController@descargarWord')->name('descargar.word')->middleware('can:control.interno.index');
});
