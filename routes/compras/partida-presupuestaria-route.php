<?php

Route::prefix('partida-presupuestaria')->name('partida.presupuestaria.')->middleware(['auth'])->group(function () {
    Route::get('/', 'Compras\PartidaPresupuestariaController@index')->name('index')->middleware('can:partida.presupuestaria.index');
    Route::get('/get_datos', 'Compras\PartidaPresupuestariaController@getDatos')->name('get.datos')->middleware('can:partida.presupuestaria.index');
    Route::get('search', 'Compras\PartidaPresupuestariaController@search')->name('search')->middleware('can:partida.presupuestaria.index');
    Route::get('excel', 'Compras\PartidaPresupuestariaController@excel')->name('excel')->middleware('can:partida.presupuestaria.index');
    Route::get('create', 'Compras\PartidaPresupuestariaController@create')->name('create')->middleware('can:partida.presupuestaria.create');
    Route::post('store', 'Compras\PartidaPresupuestariaController@store')->name('store')->middleware('can:partida.presupuestaria.create');
    Route::get('editar', 'Compras\PartidaPresupuestariaController@editar')->name('editar')->middleware('can:partida.presupuestaria.editar');
    Route::post('update', 'Compras\PartidaPresupuestariaController@update')->name('update')->middleware('can:partida.presupuestaria.editar');
});
