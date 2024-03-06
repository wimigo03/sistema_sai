<?php

Route::prefix('apedido')->name('apedido.')->middleware(['auth'])->group(function () { 
 

    Route::get('index', 'Almacen\ValeController@index')->name('index');
    Route::get('index2', 'Almacen\ValeController@index2')->name('index2');
    Route::get('index3', 'Almacen\ValeController@index3')->name('index3');
    
    Route::get('create', 'Almacen\ValeController@create')->name('create');
    Route::post('store', 'Almacen\ValeController@store')->name('store');
    Route::get('edit/{id}', 'Almacen\ValeController@edit')->name('edit');
     Route::get('editar/{id}', 'Almacen\ValeController@editar')->name('editar');
     Route::get('editardos/{id}', 'Almacen\ValeController@editardos')->name('editardos');
     Route::get('editartres/{id}', 'Almacen\ValeController@editartres')->name('editartres');

    Route::post('update', 'Almacen\ValeController@update')->name('update');
    Route::get('editable/{id}', 'Almacen\ValeController@editable')->name('editable');
    Route::get('editabletres/{id}', 'Almacen\ValeController@editabletres')->name('editabletres');
    
});