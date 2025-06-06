<?php
use Illuminate\Support\Facades\Route;

Route::prefix('sucursal')->name('sucursal.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Almacenes\SucursalController@index')->name('index')->middleware('can:sucursal.index');
    Route::get('search', 'Almacenes\SucursalController@search')->name('search')->middleware('can:sucursal.index');
    Route::get('create', 'Almacenes\SucursalController@create')->name('create')->middleware('can:sucursal.create');
    Route::post('store', 'Almacenes\SucursalController@store')->name('store')->middleware('can:sucursal.create');
    Route::get('editar/{almacen_id}', 'Almacenes\SucursalController@editar')->name('editar')->middleware('can:sucursal.editar');
    Route::post('update', 'Almacenes\SucursalController@update')->name('update')->middleware('can:sucursal.editar');
    Route::get('habilitar/{almacen_id}', 'Almacenes\SucursalController@habilitar')->name('habilitar')->middleware('can:sucursal.habilitar');
    Route::get('deshabilitar/{almacen_id}', 'Almacenes\SucursalController@deshabilitar')->name('deshabilitar')->middleware('can:sucursal.habilitar');
    Route::get('asignar/{almacen_id}', 'Almacenes\SucursalController@asignar')->name('asignar')->middleware('can:sucursal.asignar');
    Route::post('asignar-store', 'Almacenes\SucursalController@asignarStore')->name('asignar.store')->middleware('can:sucursal.asignar');
    Route::get('eliminar-area/{area_id}', 'Almacenes\SucursalController@eliminarArea')->name('eliminar.area')->middleware('can:sucursal.asignar');
    Route::get('configuracion', 'Almacenes\SucursalController@configuracion')->name('configuracion')->middleware('can:sucursal.configuracion');
});
