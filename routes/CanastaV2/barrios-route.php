<?php

Route::prefix('barrios')->name('barrios.')->middleware(['auth'])->group(function () { 
    Route::get('/', 'Canasta_v2\BarriosV2Controller@index')->name('index');
    Route::get('search', 'Canasta_v2\BarriosV2Controller@search')->name('search');
    Route::get('excel', 'Canasta_v2\BarriosV2Controller@excel')->name('excel');
    Route::get('create', 'Canasta_v2\BarriosV2Controller@create')->name('create');
    Route::post('store', 'Canasta_v2\BarriosV2Controller@store')->name('store');
    Route::get('editar/{id}', 'Canasta_v2\BarriosV2Controller@editar')->name('editar');
    Route::post('update', 'Canasta_v2\BarriosV2Controller@update')->name('update');
    Route::get('habilitar/{id}', 'Canasta_v2\BarriosV2Controller@habilitar')->name('habilitar');
    Route::get('deshabilitar/{id}', 'Canasta_v2\BarriosV2Controller@deshabilitar')->name('deshabilitar');
});