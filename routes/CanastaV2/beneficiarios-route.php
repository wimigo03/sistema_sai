<?php

Route::prefix('beneficiarios')->name('beneficiarios.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Canasta_v2\BeneficiariosV2Controller@index')->name('index');
    Route::get('search', 'Canasta_v2\BeneficiariosV2Controller@search')->name('search');
    Route::get('excel', 'Canasta_v2\BeneficiariosV2Controller@excel')->name('excel');
    Route::get('create', 'Canasta_v2\BeneficiariosV2Controller@create')->name('create');
    Route::post('store', 'Canasta_v2\BeneficiariosV2Controller@store')->name('store');
    Route::get('editar/{id}', 'Canasta_v2\BeneficiariosV2Controller@editar')->name('editar');
    Route::post('update', 'Canasta_v2\BeneficiariosV2Controller@update')->name('update');
    Route::get('habilitar/{id}', 'Canasta_v2\BeneficiariosV2Controller@habilitar')->name('habilitar');
    Route::get('deshabilitar/{id}', 'Canasta_v2\BeneficiariosV2Controller@deshabilitar')->name('deshabilitar');
});
