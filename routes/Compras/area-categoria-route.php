<?php

Route::prefix('area-categoria')->name('area.categoria.')->middleware(['auth'])->group(function () {
    Route::get('index/{categoria_programatica_id}', 'Compras\AreaCategoriaController@index')->name('index')->middleware('can:area.categoria.index');
    Route::post('store', 'Compras\AreaCategoriaController@store')->name('store')->middleware('can:area.categoria.index');
    Route::get('eliminar/{id}', 'Compras\AreaCategoriaController@eliminar')->name('eliminar')->middleware('can:area.categoria.index');
});
