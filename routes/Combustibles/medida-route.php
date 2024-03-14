<?php

Route::prefix('medidacomb')->name('medidacomb.')->middleware(['auth'])->group(function () { 
 
    
    Route::get('/index', 'Compra\MedidaCombController@index')->name('index');
    Route::get('create', 'Compra\MedidaCombController@create')->name('create');
    Route::post('store', 'Compra\MedidaCombController@store')->name('store');
    Route::get('list', 'Compra\MedidaCombController@list')->name('list');
    Route::get('edit/{id}', 'Compra\MedidaCombController@editar')->name('edit');
    Route::POST('update/{id}', 'Compra\MedidaCombController@update')->name('update');


    // Route::get('/index', 'Compra\MedidaCombController@index')->name('index')->middleware('can:medidacomb.index');
    // Route::get('create', 'Compra\MedidaCombController@create')->name('create')->middleware('can:medidacomb.create');
    // Route::post('store', 'Compra\MedidaCombController@store')->name('store')->middleware('can:medidacomb.store');
    // Route::get('list', 'Compra\MedidaCombController@list')->name('list')->middleware('can:medidacomb.list');
    // Route::get('edit/{id}', 'Compra\MedidaCombController@editar')->name('edit')->middleware('can:medidacomb.editar');
    // Route::POST('update/{id}', 'Compra\MedidaCombController@update')->name('update')->middleware('can:medidacomb.update');


  
});