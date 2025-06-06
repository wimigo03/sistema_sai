<?php
use Illuminate\Support\Facades\Route;

Route::prefix('unidad-medida')->name('unidad.medida.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Almacenes\UnidadMedidaController@index')->name('index')->middleware('can:unidad.medida.index');
    Route::get('search', 'Almacenes\UnidadMedidaController@search')->name('search')->middleware('can:unidad.medida.index');
    Route::get('create', 'Almacenes\UnidadMedidaController@create')->name('create')->middleware('can:unidad.medida.create');
    Route::post('store', 'Almacenes\UnidadMedidaController@store')->name('store')->middleware('can:unidad.medida.create');
    Route::get('habilitar/{item_id}', 'Almacenes\UnidadMedidaController@habilitar')->name('habilitar')->middleware('can:unidad.medida.habilitar');
    Route::get('deshabilitar/{item_id}', 'Almacenes\UnidadMedidaController@deshabilitar')->name('deshabilitar')->middleware('can:unidad.medida.habilitar');
    Route::get('editar/{item_id}', 'Almacenes\UnidadMedidaController@editar')->name('editar')->middleware('can:unidad.medida.editar');
    Route::post('update', 'Almacenes\UnidadMedidaController@update')->name('update')->middleware('can:unidad.medida.editar');
});
