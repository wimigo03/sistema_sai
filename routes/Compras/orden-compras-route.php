<?php

Route::prefix('orden-compras')->name('orden-compras.')->middleware(['auth'])->group(function () {
    Route::get('index', 'OrdenComprasController@index')->name('index')->middleware('can:orden.compras.index');
    Route::get('search', 'OrdenComprasController@search')->name('search')->middleware('can:orden.compras.index');
    Route::get('create/{solicitud_id}', 'OrdenComprasController@create')->name('create')->middleware('can:orden.compras.create');
    /*Route::post('store', 'CompraController2@store')->name('store')->middleware('can:compras.pedido.parcial.create');
    Route::get('editar/{id}', 'CompraController2@editar')->name('editar')->middleware('can:compras.pedido.parcial.editar');
    Route::post('update', 'CompraController2@update')->name('update')->middleware('can:compras.pedido.parcial.editar');
    Route::get('eliminar/{id}', 'CompraController2@eliminar')->name('eliminar')->middleware('can:compras.pedido.parcial.editar');
    Route::get('show/{id}', 'CompraController2@show')->name('show')->middleware('can:compras.pedido.parcial.show');
    Route::get('aprobar/{id}', 'CompraController2@aprobar')->name('aprobar')->middleware('can:compras.pedido.parcial.aprobar');
    Route::get('rechazar/{id}', 'CompraController2@rechazar')->name('rechazar')->middleware('can:compras.pedido.parcial.aprobar');*/
});