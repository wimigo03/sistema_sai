<?php

Route::prefix('unidad-medida')->name('unidad.medida.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Compras\UnidadMedidaController@index')->name('index')->middleware('can:unidad.medida.index');
    Route::get('search', 'Compras\UnidadMedidaController@search')->name('search')->middleware('can:unidad.medida.index');
    Route::get('create', 'Compras\UnidadMedidaController@create')->name('create')->middleware('can:unidad.medida.create');
    Route::post('store', 'Compras\UnidadMedidaController@store')->name('store')->middleware('can:unidad.medida.create');
    Route::get('habilitar/{item_id}', 'Compras\UnidadMedidaController@habilitar')->name('habilitar')->middleware('can:unidad.medida.habilitar');
    Route::get('deshabilitar/{item_id}', 'Compras\UnidadMedidaController@deshabilitar')->name('deshabilitar')->middleware('can:unidad.medida.habilitar');
    Route::get('editar/{item_id}', 'Compras\UnidadMedidaController@editar')->name('editar')->middleware('can:unidad.medida.editar');
    Route::post('update', 'Compras\UnidadMedidaController@update')->name('update')->middleware('can:unidad.medida.editar');
});
