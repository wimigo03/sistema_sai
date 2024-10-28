<?php

Route::prefix('categoria-presupuestaria')->name('categoria.presupuestaria.')->middleware(['auth'])->group(function () {
    Route::get('index/{categoria_programatica_id}', 'Compras\CategoriaPresupuestariaController@index')->name('index')->middleware('can:categoria.presupuestaria.index');
    Route::post('store', 'Compras\CategoriaPresupuestariaController@store')->name('store')->middleware('can:categoria.presupuestaria.index');
    Route::get('habilitar/{id}', 'Compras\CategoriaPresupuestariaController@habilitar')->name('habilitar')->middleware('can:categoria.presupuestaria.index');
    Route::get('deshabilitar/{id}', 'Compras\CategoriaPresupuestariaController@deshabilitar')->name('deshabilitar')->middleware('can:categoria.presupuestaria.index');
});
