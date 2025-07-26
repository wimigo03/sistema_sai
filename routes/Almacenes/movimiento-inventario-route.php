<?php
use Illuminate\Support\Facades\Route;

Route::prefix('movimiento-inventario')->name('movimiento.inventario.')->middleware(['auth'])->group(function () {
    //Route::get('/', 'Almacenes\InventarioAlmacenController@index')->name('index')->middleware('can:inventario.almacen.index');
    //Route::get('search', 'Almacenes\InventarioAlmacenController@search')->name('search')->middleware('can:inventario.almacen.index');
    Route::get('show/{id}', 'Almacenes\MovimientoInventarioController@show')->name('show')->middleware('can:inventario.almacen.index');
});
