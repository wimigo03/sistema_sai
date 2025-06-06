<?php
use Illuminate\Support\Facades\Route;

Route::prefix('productos')->name('producto.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Almacenes\ProductoController@index')->name('index')->middleware('can:producto.index');
    Route::get('search', 'Almacenes\ProductoController@search')->name('search')->middleware('can:producto.index');
    Route::get('create', 'Almacenes\ProductoController@create')->name('create')->middleware('can:producto.create');
    Route::post('store', 'Almacenes\ProductoController@store')->name('store')->middleware('can:producto.create');
    Route::get('editar/{item_id}', 'Almacenes\ProductoController@editar')->name('editar')->middleware('can:producto.editar');
    Route::post('update', 'Almacenes\ProductoController@update')->name('update')->middleware('can:producto.editar');
    Route::get('habilitar/{item_id}', 'Almacenes\ProductoController@habilitar')->name('habilitar')->middleware('can:producto.habilitar');
    Route::get('inhabilitar/{item_id}', 'Almacenes\ProductoController@inhabilitar')->name('inhabilitar')->middleware('can:producto.habilitar');
});
