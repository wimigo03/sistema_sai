<?php

Route::prefix('medidacomb')->name('medidacomb.')->middleware(['auth'])->group(function () { 
 

    Route::get('index', 'Compra\MedidaCombController@index')->name('index');
    Route::get('create', 'Compra\MedidaCombController@create')->name('create');
    Route::post('store', 'Compra\MedidaCombController@store')->name('store');
    Route::get('list', 'Compra\MedidaCombController@list')->name('list');
    Route::get('edit/{id}', 'Compra\MedidaCombController@editar')->name('edit');
    Route::POST('update/{id}', 'Compra\MedidaCombController@update')->name('update');



  
});