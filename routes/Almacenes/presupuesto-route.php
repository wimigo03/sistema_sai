<?php
use Illuminate\Support\Facades\Route;

Route::prefix('presupuesto')->name('presupuesto.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Almacenes\PresupuestoController@index')->name('index')->middleware('can:presupuesto.index');
    Route::get('search', 'Almacenes\PresupuestoController@search')->name('search')->middleware('can:presupuesto.index');
    Route::get('create', 'Almacenes\PresupuestoController@create')->name('create')->middleware('can:presupuesto.create');
    Route::get('/get_partidas_presupuestarias', 'Almacenes\PresupuestoController@getPartidasPresupuestarias')->name('get.partidas.presupuestarias')->middleware('can:presupuesto.create');
    Route::post('store', 'Almacenes\PresupuestoController@store')->name('store')->middleware('can:presupuesto.create');
    Route::get('editar/{presupuesto_id}', 'Almacenes\PresupuestoController@editar')->name('editar')->middleware('can:presupuesto.editar');
    Route::post('update', 'Almacenes\PresupuestoController@update')->name('update')->middleware('can:presupuesto.editar');
});
