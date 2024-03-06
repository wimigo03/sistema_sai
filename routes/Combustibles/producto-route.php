<?php

Route::prefix('producto')->name('producto.')->middleware(['auth'])->group(function () { 
 

    Route::get('index', 'Compra\ProdCombController@index')->name('index');
    Route::get('create', 'Compra\ProdCombController@create')->name('create');
    Route::post('store', 'Compra\ProdCombController@store')->name('store');
    Route::get('list', 'Compra\ProdCombController@list')->name('list');
    Route::get('edit/{id}', 'Compra\ProdCombController@editar')->name('edit');
    Route::POST('update/{id}', 'Compra\ProdCombController@update')->name('update');

     Route::post('/ruta3', 'Compra\ProdCombController@respuesta3')->name('pregunta3');

  
});