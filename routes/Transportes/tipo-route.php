<?php 
Route::prefix('tipo')->name('tipo.')->middleware(['auth'])->group(function () { 
 

    Route::get('index', 'Transporte\TipomovilidadController@index')->name('index');
    Route::get('list', 'Transporte\TipomovilidadController@listado')->name('list');
    Route::get('edit/{id}', 'Transporte\TipomovilidadController@editar')->name('edit');
    Route::POST('update/{id}', 'Transporte\TipomovilidadController@update')->name('update');
    Route::get('create', 'Transporte\TipomovilidadController@create')->name('create');
    Route::POST('store', 'Transporte\TipomovilidadController@store')->name('store');
});