<?php

Route::prefix('paquetes')->name('paquetes.')->middleware(['auth'])->group(function () {
    Route::get('/', 'Canasta_v2\PaquetesV2Controller@index')->name('index')->middleware('can:canasta.paquetes.index');
    Route::get('search', 'Canasta_v2\PaquetesV2Controller@search')->name('search')->middleware('can:canasta.paquetes.index');
    Route::get('create', 'Canasta_v2\PaquetesV2Controller@create')->name('create')->middleware('can:canasta.paquetes.create');
    Route::post('store', 'Canasta_v2\PaquetesV2Controller@store')->name('store')->middleware('can:canasta.paquetes.create');
    Route::get('editar/{id}', 'Canasta_v2\PaquetesV2Controller@editar')->name('editar')->middleware('can:canasta.paquetes.editar');
    Route::post('update', 'Canasta_v2\PaquetesV2Controller@update')->name('update')->middleware('can:canasta.paquetes.editar');
});
