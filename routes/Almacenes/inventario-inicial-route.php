<?php
use Illuminate\Support\Facades\Route;

Route::prefix('inventario-inicial')->name('inventario.inicial.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Almacenes\InventarioInicialController@index')->name('index')->middleware('can:inventario.inicial.index');
    Route::get('search', 'Almacenes\InventarioInicialController@search')->name('search')->middleware('can:inventario.inicial.index');
    Route::get('create', 'Almacenes\InventarioInicialController@create')->name('create')->middleware('can:inventario.inicial.create');
    Route::post('store', 'Almacenes\InventarioInicialController@store')->name('store')->middleware('can:inventario.inicial.create');
    Route::get('show/{ingreso_almacen_id}', 'Almacenes\InventarioInicialController@show')->name('show')->middleware('can:inventario.inicial.show');
    Route::get('pdf/{ingreso_almacen_id}', 'Almacenes\InventarioInicialController@pdf')->name('pdf')->middleware('can:inventario.inicial.pdf');
    Route::get('editar/{ingreso_almacen_id}', 'Almacenes\InventarioInicialController@editar')->name('editar')->middleware('can:inventario.inicial.editar');
});
