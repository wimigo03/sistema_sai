<?php

Route::prefix('localidad')->name('localidad.')->middleware(['auth'])->group(function () { 
 

    Route::get('index', 'Almacen\LocalidadController@index')->name('index');
    Route::get('list', 'Almacen\LocalidadController@listado')->name('list');
    Route::get('edit/{id}', 'Almacen\LocalidadController@editar')->name('edit');
    Route::POST('update/{id}', 'Almacen\LocalidadController@update')->name('update');
    Route::get('create', 'Almacen\LocalidadController@create')->name('create');
    Route::POST('store', 'Almacen\LocalidadController@store')->name('store');
 
});