<?php 
Route::prefix('marca')->name('marca.')->middleware(['auth'])->group(function () { 
 

    Route::get('index', 'Transporte\MarcaMovilidadController@index')->name('index');
    Route::get('list', 'Transporte\MarcaMovilidadController@listado')->name('list');
    Route::get('edit/{id}', 'Transporte\MarcaMovilidadController@editar')->name('edit');
    Route::POST('update/{id}', 'Transporte\MarcaMovilidadController@update')->name('update');
    Route::get('create', 'Transporte\MarcaMovilidadController@create')->name('create');
    Route::POST('store', 'Transporte\MarcaMovilidadController@store')->name('store');
});