<?php

Route::prefix('beneficiariosdisc')->name('beneficiariosdisc.')->middleware(['auth'])->group(function () {


    Route::get('indexdisc', 'Canasta_v2disc\BeneficiariosV2Controller@index')->name('index');
    //dd('hola ruta');
    Route::get('/get_barrios', 'Canasta_v2disc\BeneficiariosV2Controller@getBarrios')->name('get.barrios')->middleware('can:canastadisc.beneficiarios.index');
    Route::get('search', 'Canasta_v2disc\BeneficiariosV2Controller@search')->name('search')->middleware('can:canastadisc.beneficiarios.index');
    Route::get('create', 'Canasta_v2disc\BeneficiariosV2Controller@create')->name('create')->middleware('can:canastadisc.beneficiarios.create');
    Route::post('store', 'Canasta_v2disc\BeneficiariosV2Controller@store')->name('store')->middleware('can:canastadisc.beneficiarios.create');
    //dd('hola ruta');
    Route::get('editar/{id}', 'Canasta_v2disc\BeneficiariosV2Controller@editar')->name('editar')->middleware('can:canastadisc.beneficiarios.editar');

    Route::post('update', 'Canasta_v2disc\BeneficiariosV2Controller@update')->name('update')->middleware('can:canastadisc.beneficiarios.editar');
    Route::get('show/{id}', 'Canasta_v2disc\BeneficiariosV2Controller@show')->name('show')->middleware('can:canastadisc.beneficiarios.show');
    Route::get('pdf/{id}', 'Canasta_v2disc\BeneficiariosV2Controller@pdf')->name('pdf')->middleware('can:canastadisc.beneficiarios.pdf');
    Route::get('excel', 'Canasta_v2disc\BeneficiariosV2Controller@excel')->name('excel')->middleware('can:canastadisc.beneficiarios.excel');
});
