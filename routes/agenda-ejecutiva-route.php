<?php

Route::prefix('agenda-ej')->name('agenda.ejecutiva.')->middleware(['auth'])->group(function () {
    Route::get('/index','AgendaEjecutivoController@index')->name('index')->middleware('can:agenda.ejecutiva.index');
    Route::get('index/{month}','AgendaEjecutivoController@index_month')->name('mes.index')->middleware('can:agenda.ejecutiva.index');
    Route::get('details/{id}/{id2}/{id3}','AgendaEjecutivoController@details')->name('detalle')->middleware('can:agenda.ejecutiva.index');
    Route::get('show/{evento_id}','AgendaEjecutivoController@show')->name('show')->middleware('can:agenda.ejecutiva.index');
    Route::get('form/{mes}','AgendaEjecutivoController@form')->name('form')->middleware('can:agenda.ejecutiva.create');
    Route::post('create', 'AgendaEjecutivoController@create')->name('create')->middleware('can:agenda.ejecutiva.create');
    Route::get('details2/{id}','AgendaEjecutivoController@details2')->name('details2')->middleware('can:agenda.ejecutiva.pdf');
    Route::get('actualizar/{id}','AgendaEjecutivoController@editar')->name('editar')->middleware('can:agenda.ejecutiva.editar');
    Route::post('update','AgendaEjecutivoController@actualizar')->name('update')->middleware('can:agenda.ejecutiva.editar');
});
