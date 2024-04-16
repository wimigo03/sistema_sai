<?php

Route::prefix('partida')->name('partida.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Compras\PartidaController@index')->name('index')->middleware('can:partida.index');
    Route::get('search', 'Compras\PartidaController@search')->name('search')->middleware('can:partida.index');
    Route::get('create/{dea_id}', 'Compras\PartidaController@create')->name('create')->middleware('can:partida.create');
    Route::post('store', 'Compras\PartidaController@store')->name('store')->middleware('can:partida.create');
    Route::get('habilitar/{partida_id}', 'Compras\PartidaController@habilitar')->name('habilitar')->middleware('can:partida.habilitar');
    Route::get('deshabilitar/{partida_id}', 'Compras\PartidaController@deshabilitar')->name('deshabilitar')->middleware('can:partida.habilitar');
    Route::get('editar/{partida_id}', 'Compras\PartidaController@editar')->name('editar')->middleware('can:partida.editar');
    Route::post('update', 'Compras\PartidaController@update')->name('update')->middleware('can:partida.editar');
});