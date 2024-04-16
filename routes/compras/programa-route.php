<?php

Route::prefix('programa')->name('programa.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Compras\ProgramaController@index')->name('index')->middleware('can:programa.index');
    Route::get('search', 'Compras\ProgramaController@search')->name('search')->middleware('can:programa.index');
    Route::get('create/{dea_id}', 'Compras\ProgramaController@create')->name('create')->middleware('can:programa.create');
    Route::post('store', 'Compras\ProgramaController@store')->name('store')->middleware('can:programa.create');
    Route::get('habilitar/{programa_id}', 'Compras\ProgramaController@habilitar')->name('habilitar')->middleware('can:programa.habilitar');
    Route::get('deshabilitar/{programa_id}', 'Compras\ProgramaController@deshabilitar')->name('deshabilitar')->middleware('can:programa.habilitar');
    Route::get('editar/{programa_id}', 'Compras\ProgramaController@editar')->name('editar')->middleware('can:programa.editar');
    Route::post('update', 'Compras\ProgramaController@update')->name('update')->middleware('can:programa.editar');
});