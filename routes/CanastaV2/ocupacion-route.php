<?php

Route::prefix('ocupacion')->name('ocupacion.')->middleware(['auth'])->group(function () {
    Route::get('/', 'Canasta_v2\OcupacionV2Controller@index')->name('index')->middleware('can:canasta.ocupacion.index');
    Route::get('/index', 'Canasta_v2\OcupacionV2Controller@indexAjax')->name('indexAjax')->middleware('can:canasta.ocupacion.index');
    Route::get('search', 'Canasta_v2\OcupacionV2Controller@search')->name('search')->middleware('can:canasta.ocupacion.index');
    Route::get('create', 'Canasta_v2\OcupacionV2Controller@create')->name('create')->middleware('can:canasta.ocupacion.create');
    Route::post('store', 'Canasta_v2\OcupacionV2Controller@store')->name('store')->middleware('can:canasta.ocupacion.create');
    Route::get('editar/{id}', 'Canasta_v2\OcupacionV2Controller@editar')->name('editar')->middleware('can:canasta.ocupacion.editar');
    Route::post('update', 'Canasta_v2\OcupacionV2Controller@update')->name('update')->middleware('can:canasta.ocupacion.editar');
});
