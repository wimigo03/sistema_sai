<?php

Route::prefix('compras/pedidoparcial')->name('compras.pedidoparcial.')->middleware(['auth'])->group(function () {
    Route::get('index', 'CompraController2@index')->name('index')->middleware('can:compras.pedido.parcial.index');
    Route::get('search', 'CompraController2@search')->name('search')->middleware('can:compras.pedido.parcial.index');
    Route::get('create', 'CompraController2@create')->name('create')->middleware('can:compras.pedido.parcial.create');
    Route::post('store', 'CompraController2@store')->name('store')->middleware('can:compras.pedido.parcial.create');
    Route::get('editar/{id}', 'CompraController2@editar')->name('editar')->middleware('can:compras.pedido.parcial.editar');
    Route::post('update', 'CompraController2@update')->name('update')->middleware('can:compras.pedido.parcial.editar');
    Route::get('eliminar/{id}', 'CompraController2@eliminar')->name('eliminar')->middleware('can:compras.pedido.parcial.editar');
    Route::get('show/{id}', 'CompraController2@show')->name('show')->middleware('can:compras.pedido.parcial.show');
    Route::get('aprobar/{id}', 'CompraController2@aprobar')->name('aprobar')->middleware('can:compras.pedido.parcial.aprobar');
    Route::get('rechazar/{id}', 'CompraController2@rechazar')->name('rechazar')->middleware('can:compras.pedido.parcial.aprobar');

    Route::get('responsable', 'CompraController2@listadoResponsables')->name('listadoResponsables');
    Route::get('responsableCreate', 'CompraController2@crearEncargado')->name('crearEncargado');
    Route::post('store2', 'CompraController2@storeEncargado')->name('storeEncargado');
    Route::get('responsableEdit/{id}', 'CompraController2@responsableEdit')->name('responsableEdit');
    Route::post('responsableUpdate', 'CompraController2@UpdateResponsable')->name('UpdateResponsable');
});