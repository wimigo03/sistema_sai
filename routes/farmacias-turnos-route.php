<?php
use Illuminate\Support\Facades\Route;

Route::prefix('farmacias-turnos')->name('farmacias.turnos.')->middleware(['auth'])->group(function () {
    Route::get('/','FarmaciaTurnoController@index')->name('index')->middleware('can:farmacias.index');
    Route::get('/search','FarmaciaTurnoController@search')->name('search')->middleware('can:farmacias.index');
    Route::get('/create','FarmaciaTurnoController@create')->name('create')->middleware('can:farmacias.index');
    Route::post('/store','FarmaciaTurnoController@store')->name('store')->middleware('can:farmacias.index');
    Route::post('/update','FarmaciaTurnoController@update')->name('update')->middleware('can:farmacias.index');
    Route::get('/delete/{farmacia_turno_id}','FarmaciaTurnoController@delete')->name('delete')->middleware('can:farmacias.index');
});
