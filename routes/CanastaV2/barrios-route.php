<?php

Route::prefix('barrios')->name('barrios.')->middleware(['auth'])->group(function () {
    Route::get('/', 'Canasta_v2\BarriosV2Controller@index')->name('index')->middelware('can:canasta.barrios.index');
    Route::get('search', 'Canasta_v2\BarriosV2Controller@search')->name('search')->middelware('can:canasta.barrios.index');
    Route::get('excel', 'Canasta_v2\BarriosV2Controller@excel')->name('excel')->middelware('can:canasta.barrios.excel');
    Route::get('create', 'Canasta_v2\BarriosV2Controller@create')->name('create')->middelware('can:canasta.barrios.create');
    Route::post('store', 'Canasta_v2\BarriosV2Controller@store')->name('store')->middelware('can:canasta.barrios.create');
    Route::get('editar/{id}', 'Canasta_v2\BarriosV2Controller@editar')->name('editar')->middelware('can:canasta.barrios.editar');
    Route::post('update', 'Canasta_v2\BarriosV2Controller@update')->name('update')->middelware('can:canasta.barrios.editar');
    Route::get('habilitar/{id}', 'Canasta_v2\BarriosV2Controller@habilitar')->name('habilitar');
    Route::get('deshabilitar/{id}', 'Canasta_v2\BarriosV2Controller@deshabilitar')->name('deshabilitar');
});
