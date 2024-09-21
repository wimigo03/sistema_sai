<?php

Route::prefix('archivos')->name('archivos.')->middleware(['auth'])->group(function () {
    Route::get('/rr','ArchivosController@index')->name('index')->middleware('can:archivos.index');
    Route::get('/indexAjax','ArchivosController@indexAjax')->name('index.ajax')->middleware('can:archivos.index');
    Route::get('/search','ArchivosController@search')->name('search')->middleware('can:archivos.index');
    Route::get('/excel','ArchivosController@excel')->name('excel')->middleware('can:archivos.index');
    Route::get('/pdf','ArchivosController@pdf')->name('pdf')->middleware('can:archivos.index');
    Route::get('/create','ArchivosController@create')->name('create')->middleware('can:archivos.create');
    Route::post('/store','ArchivosController@store')->name('store')->middleware('can:archivos.create');
    Route::get('/editar/{id}','ArchivosController@editar')->name('editar')->middleware('can:archivos.editar');
    Route::post('/update','ArchivosController@update')->name('update')->middleware('can:archivos.editar');
    Route::get('/documentacion/{id}','ArchivosController@documentacion')->name('documentacion')->middleware('can:archivos.documentacion');
    Route::get('/index','ArchivosController@index_full')->name('index.full')->middleware('can:archivos.index.general');
    Route::get('/generar-qr/{id}','ArchivosController@generar_qr')->name('generar.qr')->middleware('can:archivos.generar.qr');
});
