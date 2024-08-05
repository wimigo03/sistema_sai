<?php

Route::prefix('beneficiariosdisc')->name('beneficiariosdisc.')->middleware(['auth'])->group(function () {


    Route::get('indexdisc', 'Canasta_v2disc\BeneficiariosV2Controller@index')->name('index');
    //dd('hola ruta');
    Route::get('/get_barrios', 'Canasta_v2disc\BeneficiariosV2Controller@getBarrios')->name('get.barrios')->middleware('can:canasta.beneficiarios.index');
    Route::get('search', 'Canasta_v2disc\BeneficiariosV2Controller@search')->name('search')->middleware('can:canasta.beneficiarios.index');
    Route::get('create', 'Canasta_v2disc\BeneficiariosV2Controller@create')->name('create')->middleware('can:canasta.beneficiarios.create');
    Route::post('store', 'Canasta_v2disc\BeneficiariosV2Controller@store')->name('store')->middleware('can:canasta.beneficiarios.create');
    //dd('hola ruta');
    Route::get('editar/{id}', 'Canasta_v2disc\BeneficiariosV2Controller@editar')->name('editar')->middleware('can:canasta.beneficiarios.editar');

    Route::post('update', 'Canasta_v2disc\BeneficiariosV2Controller@update')->name('update')->middleware('can:canasta.beneficiarios.editar');
    Route::get('show/{id}', 'Canasta_v2disc\BeneficiariosV2Controller@show')->name('show')->middleware('can:canasta.beneficiarios.show');
    Route::get('pdf/{id}', 'Canasta_v2disc\BeneficiariosV2Controller@pdf')->name('pdf')->middleware('can:canasta.beneficiarios.pdf');
    Route::get('excel', 'Canasta_v2disc\BeneficiariosV2Controller@excel')->name('excel')->middleware('can:canasta.beneficiarios.excel');
});
