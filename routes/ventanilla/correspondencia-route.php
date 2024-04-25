<?php

Route::prefix('correspondencia')->name('correspondencia.')->middleware(['auth'])->group(function () {
    Route::get('/', 'CorrespondenciaController@index')->name('index')->middleware('can:correspondencia.index');
    Route::get('createRecepcion', 'CorrespondenciaController@create')->name('create')->middleware('can:correspondencia.index');
    Route::get('indexUnidad', 'CorrespondenciaController@indexUnidad')->name('unidadIndex')->middleware('can:correspondencia.index');
    Route::get('indexRemitente', 'CorrespondenciaController@indexRemitente')->name('remitenteIndex')->middleware('can:correspondencia.index');
    Route::get('createUnidad', 'CorrespondenciaController@createLugar')->name('crear.lugar')->middleware('can:correspondencia.index');
    Route::post('storeLugar', 'CorrespondenciaController@storeLugar')->name('guardar.lugar')->middleware('can:correspondencia.index');
    Route::get('createRemitente', 'CorrespondenciaController@createRemitente')->name('crear.remitente')->middleware('can:correspondencia.index');
    Route::post('storeRemitente', 'CorrespondenciaController@storeRemitente')->name('guardar.remitente')->middleware('can:correspondencia.index');
    Route::get('createRecepcion', 'CorrespondenciaController@createRecepcion')->name('crear.recepcion')->middleware('can:correspondencia.index');
    Route::post('storeRecepcion', 'CorrespondenciaController@storeRecepcion')->name('guardar.recepcion')->middleware('can:correspondencia.index');
    Route::get('{id}/edit', 'CorrespondenciaController@editarCodigo')->name('edit')->middleware('can:correspondencia.index');
    Route::post('{id}/updateCodigo', 'CorrespondenciaController@updateCodigo')->name('update')->middleware('can:correspondencia.index');
});
