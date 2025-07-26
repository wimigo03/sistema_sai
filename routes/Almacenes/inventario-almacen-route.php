<?php
use Illuminate\Support\Facades\Route;

Route::prefix('inventario-almacen')->name('inventario.almacen.')->middleware(['auth'])->group(function () {
    Route::get('/', 'Almacenes\InventarioAlmacenController@index')->name('index')->middleware('can:inventario.almacen.index');
    Route::get('search', 'Almacenes\InventarioAlmacenController@search')->name('search')->middleware('can:inventario.almacen.index');
    //Route::get('create', 'Almacenes\TraspasoSucursalController@create')->name('create')->middleware('can:traspaso.sucursal.create');
    //Route::get('/get_ingresos_materiales_pendientes', 'Almacenes\TraspasoSucursalController@getIngresoMaterialesPendientes')->name('get.ingreso.material.pendiente')->middleware('can:traspaso.sucursal.create');
    //Route::post('store', 'Almacenes\TraspasoSucursalController@store')->name('store')->middleware('can:traspaso.sucursal.create');
});
