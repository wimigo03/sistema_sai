<?php

Route::prefix('tipo-archivos')->name('tipos.archivos.')->middleware(['auth'])->group(function () {
    Route::get('/','TipoArchivosController@index')->name('index')->middleware('can:tipos.archivos.index');
    Route::post('/store-cargar','TipoArchivosController@storeCargar')->name('store.cargar')->middleware('can:tipos.archivos.cargar');
    Route::get('/delete/{id}','TipoArchivosController@delete')->name('delete')->middleware('can:tipos.archivos.eliminar');
    Route::get('/create','TipoArchivosController@create')->name('create')->middleware('can:tipos.archivos.create');
    Route::post('/store','TipoArchivosController@store')->name('store')->middleware('can:tipos.archivos.create');
    Route::get('/editar/{id}','TipoArchivosController@editar')->name('editar')->middleware('can:tipos.archivos.create');
    Route::post('/update','TipoArchivosController@update')->name('update')->middleware('can:tipos.archivos.create');
});
