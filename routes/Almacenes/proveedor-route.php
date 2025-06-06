<?php
use Illuminate\Support\Facades\Route;

Route::prefix('proveedor')->name('proveedor.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Almacenes\ProveedorController@index')->name('index')->middleware('can:proveedor.index');
    Route::get('search', 'Almacenes\ProveedorController@search')->name('search')->middleware('can:proveedor.index');
    Route::get('create', 'Almacenes\ProveedorController@create')->name('create')->middleware('can:proveedor.create');
    Route::post('store', 'Almacenes\ProveedorController@store')->name('store')->middleware('can:proveedor.create');
    Route::get('habilitar/{proveedor_id}', 'Almacenes\ProveedorController@habilitar')->name('habilitar')->middleware('can:proveedor.habilitar');
    Route::get('deshabilitar/{proveedor_id}', 'Almacenes\ProveedorController@deshabilitar')->name('deshabilitar')->middleware('can:proveedor.habilitar');
    Route::get('editar/{proveedor_id}', 'Almacenes\ProveedorController@editar')->name('editar')->middleware('can:proveedor.editar');
    Route::post('update', 'Almacenes\ProveedorController@update')->name('update')->middleware('can:proveedor.editar');
});
