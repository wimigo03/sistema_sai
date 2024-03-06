<?php

Route::prefix('catprogcomb')->name('catprogcomb.')->middleware(['auth'])->group(function () { 
 

    Route::get('index', 'Compra\CatProgController@index')->name('index');
    Route::get('listado', 'Compra\CatProgController@listado')->name('listado');
    Route::get('edit/{id}', 'Compra\CatProgController@editar')->name('edit');
    Route::POST('update/{id}', 'Compra\CatProgController@update')->name('update');
    Route::get('create', 'Compra\CatProgController@create')->name('create');
    Route::POST('store', 'Compra\CatProgController@store')->name('store');
    Route::post('/ruta8', 'Compra\CatProgController@respuesta8')->name('pregunta8');


  
});