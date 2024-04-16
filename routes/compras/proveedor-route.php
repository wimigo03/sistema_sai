<?php

Route::prefix('proveedor')->name('proveedor.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Compras\ProveedorController@index')->name('index')->middleware('can:proveedor.index');
    Route::get('search', 'Compras\ProveedorController@search')->name('search')->middleware('can:proveedor.index');
    Route::get('create/{dea_id}', 'Compras\ProveedorController@create')->name('create')->middleware('can:proveedor.create');
    Route::post('store', 'Compras\ProveedorController@store')->name('store')->middleware('can:proveedor.create');
    Route::get('habilitar/{proveedor_id}', 'Compras\ProveedorController@habilitar')->name('habilitar')->middleware('can:proveedor.habilitar');
    Route::get('deshabilitar/{proveedor_id}', 'Compras\ProveedorController@deshabilitar')->name('deshabilitar')->middleware('can:proveedor.habilitar');
    Route::get('editar/{proveedor_id}', 'Compras\ProveedorController@editar')->name('editar')->middleware('can:proveedor.editar');
    Route::post('update', 'Compras\ProveedorController@update')->name('update')->middleware('can:proveedor.editar');
});