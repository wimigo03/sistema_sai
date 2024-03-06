<?php

Route::prefix('upedido')->name('upedido.')->middleware(['auth'])->group(function () { 
 
    Route::get('index', 'Transporte\SoluconsumoController@index')->name('index');
    Route::get('index2', 'Transporte\SoluconsumoController@index2')->name('index2');
    Route::get('index3', 'Transporte\SoluconsumoController@index3')->name('index3');
    Route::get('index4', 'Transporte\SoluconsumoController@index4')->name('index4');
    Route::get('editar/{id}', 'Transporte\SoluconsumoController@editar')->name('editar');
    Route::POST('update', 'Transporte\SoluconsumoController@update')->name('update');
    Route::get('edit/{id}', 'Transporte\SoluconsumoController@edit')->name('edit');
    Route::get('editable/{id}', 'Transporte\SoluconsumoController@editable')->name('editable');
    Route::get('aprovar/{id}', 'Transporte\SoluconsumoController@aprovar')->name('aprovar');
    Route::get('rechazar/{id}', 'Transporte\SoluconsumoController@rechazar')->name('rechazar');
    Route::get('rechazartr/{id}', 'Transporte\SoluconsumoController@rechazartr')->name('rechazartr');
    Route::get('solicitud/{id}', 'Transporte\SoluconsumoController@solicitud')->name('solicitud');

    
 
});