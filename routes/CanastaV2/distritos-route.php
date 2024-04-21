<?php

Route::prefix('distritos')->name('distritos.')->middleware(['auth'])->group(function () {
    Route::get('/', 'Canasta_v2\DistritosV2Controller@index')->name('index')->middleware('can:canasta.distritos.index');
    Route::get('search', 'Canasta_v2\DistritosV2Controller@search')->name('search')->middleware('can:canasta.distritos.index');
    Route::get('excel', 'Canasta_v2\DistritosV2Controller@excel')->name('excel')->middleware('can:canasta.distritos.excel');
    Route::get('create', 'Canasta_v2\DistritosV2Controller@create')->name('create')->middleware('can:canasta.distritos.create');
    Route::post('store', 'Canasta_v2\DistritosV2Controller@store')->name('store')->middleware('can:canasta.distritos.create');
    Route::get('editar/{id}', 'Canasta_v2\DistritosV2Controller@editar')->name('editar')->middleware('can:canasta.distritos.editar');
    Route::post('update', 'Canasta_v2\DistritosV2Controller@update')->name('update')->middleware('can:canasta.distritos.editar');
    Route::get('habilitar/{id}', 'Canasta_v2\DistritosV2Controller@habilitar')->name('habilitar')->middleware('can:canasta.distritos.habilitar');
    Route::get('deshabilitar/{id}', 'Canasta_v2\DistritosV2Controller@deshabilitar')->name('deshabilitar')->middleware('can:canasta.distritos.habilitar');
});
