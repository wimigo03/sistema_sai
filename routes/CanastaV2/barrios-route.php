<?php

Route::prefix('barrios')->name('barrios.')->middleware(['auth'])->group(function () {
    Route::get('/', 'Canasta_v2\BarriosV2Controller@index')->name('index')->middleware('can:canasta.barrios.index');
    Route::get('search', 'Canasta_v2\BarriosV2Controller@search')->name('search')->middleware('can:canasta.barrios.index');
    Route::get('create', 'Canasta_v2\BarriosV2Controller@create')->name('create')->middleware('can:canasta.barrios.create');
    Route::post('store', 'Canasta_v2\BarriosV2Controller@store')->name('store')->middleware('can:canasta.barrios.create');
    Route::get('editar/{id}', 'Canasta_v2\BarriosV2Controller@editar')->name('editar')->middleware('can:canasta.barrios.editar');
    Route::post('update', 'Canasta_v2\BarriosV2Controller@update')->name('update')->middleware('can:canasta.barrios.editar');
    Route::get('habilitar/{id}', 'Canasta_v2\BarriosV2Controller@habilitar')->name('habilitar')->middleware('can:canasta.barrios.habilitar');
    Route::get('deshabilitar/{id}', 'Canasta_v2\BarriosV2Controller@deshabilitar')->name('deshabilitar')->middleware('can:canasta.barrios.habilitar');
    Route::get('excel', 'Canasta_v2\BarriosV2Controller@excel')->name('excel')->middleware('can:canasta.barrios.excel');
});
