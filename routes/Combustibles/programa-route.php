<?php

Route::prefix('programa')->name('programa.')->middleware(['auth'])->group(function () { 
 

    Route::get('index', 'Compra\ProgramaCombController@index')->name('index');
     Route::get('list', 'Compra\ProgramaCombController@listado')->name('list');
     Route::get('edit/{id}', 'Compra\ProgramaCombController@edit')->name('edit');
    Route::POST('update/{id}', 'Compra\ProgramaCombController@update')->name('update');
     Route::get('create', 'Compra\ProgramaCombController@create')->name('create');
    Route::POST('store', 'Compra\ProgramaCombController@store')->name('store');
    Route::post('/ruta10', 'Compra\ProgramaCombController@respuesta10')->name('pregunta10');

    //  Route::post('/ruta3', 'Compra\ProgramaCombController@respuesta3')->name('pregunta3');

  
});