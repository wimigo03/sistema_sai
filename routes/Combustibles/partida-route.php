<?php

Route::prefix('partidacomb')->name('partidacomb.')->middleware(['auth'])->group(function () { 
 

    Route::get('index', 'Compra\PartidaCombController@index')->name('index');
     Route::get('list', 'Compra\PartidaCombController@listado')->name('list');
 
     Route::get('create', 'Compra\PartidaCombController@create')->name('create');
     Route::POST('store', 'Compra\PartidaCombController@store')->name('store');
     Route::post('/ruta11', 'Compra\PartidaCombController@respuesta11')->name('pregunta11');

     Route::get('edit/{id}', 'Compra\PartidaCombController@edit')->name('edit');
     Route::POST('update/{id}', 'Compra\PartidaCombController@update')->name('update');
  
});