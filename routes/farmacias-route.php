<?php
use Illuminate\Support\Facades\Route;

Route::prefix('farmacias')->name('farmacias.')->middleware(['auth'])->group(function () {
    Route::get('/index','FarmaciaController@index')->name('index')->middleware('can:farmacias.index');
    Route::get('/search','FarmaciaController@search')->name('search')->middleware('can:farmacias.index');
    Route::get('/create','FarmaciaController@create')->name('create')->middleware('can:farmacias.index');
    Route::post('/store','FarmaciaController@store')->name('store')->middleware('can:farmacias.index');
    Route::get('/editar/{farmacia_id}','FarmaciaController@editar')->name('editar')->middleware('can:farmacias.index');
    Route::post('/update','FarmaciaController@update')->name('update')->middleware('can:farmacias.index');
    Route::post('/subir-imagen','FarmaciaController@subirImagen')->name('subir.imagen')->middleware('can:farmacias.index');
});
