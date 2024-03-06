<?php

Route::prefix('udetalle')->name('udetalle.')->middleware(['auth'])->group(function () { 
 
    Route::get('index', 'Transporte\DetalleSoluconsumoController@index')->name('index');
    Route::get('index2', 'Transporte\DetalleSoluconsumoController@index2')->name('index2');
    Route::post('store', 'Transporte\DetalleSoluconsumoController@store')->name('store');
    Route::get('transportes/delete2/{id}', 'Transporte\DetalleSoluconsumoController@delete')->name('delete');
    Route::get('aprovar/{id}', 'Transporte\DetalleSoluconsumoController@aprovar')->name('aprovar');
  
 
});