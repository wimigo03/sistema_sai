<?php

Route::prefix('ocupacion')->name('ocupacion.')->middleware(['auth'])->group(function () {
    Route::get('/', 'Canasta_v2\OcupacionV2Controller@index')->name('index')->middleware('can:canasta.barrios.index');
    Route::get('/index', 'Canasta_v2\OcupacionV2Controller@indexAjax')->name('indexAjax')->middleware('can:canasta.barrios.index');
    Route::get('search', 'Canasta_v2\OcupacionV2Controller@search')->name('search')->middleware('can:canasta.barrios.index');
    Route::get('create', 'Canasta_v2\OcupacionV2Controller@create')->name('create')->middleware('can:canasta.barrios.create');
    Route::post('store', 'Canasta_v2\OcupacionV2Controller@store')->name('store')->middleware('can:canasta.barrios.create');
    Route::get('editar/{id}', 'Canasta_v2\OcupacionV2Controller@editar')->name('editar')->middleware('can:canasta.barrios.editar');
    Route::post('update', 'Canasta_v2\OcupacionV2Controller@update')->name('update')->middleware('can:canasta.barrios.editar');
});
