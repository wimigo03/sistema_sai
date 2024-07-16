<?php

Route::prefix('beneficiarios')->name('beneficiarios.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Canasta_v2\BeneficiariosV2Controller@index')->name('index')->middleware('can:canasta.beneficiarios.index');
    Route::get('/get_barrios', 'Canasta_v2\BeneficiariosV2Controller@getBarrios')->name('get.barrios')->middleware('can:canasta.beneficiarios.index');
    Route::get('search', 'Canasta_v2\BeneficiariosV2Controller@search')->name('search')->middleware('can:canasta.beneficiarios.index');
    Route::get('create', 'Canasta_v2\BeneficiariosV2Controller@create')->name('create')->middleware('can:canasta.beneficiarios.create');
    Route::post('store', 'Canasta_v2\BeneficiariosV2Controller@store')->name('store')->middleware('can:canasta.beneficiarios.create');
    Route::get('editar/{id}', 'Canasta_v2\BeneficiariosV2Controller@editar')->name('editar')->middleware('can:canasta.beneficiarios.editar');
    Route::post('update', 'Canasta_v2\BeneficiariosV2Controller@update')->name('update')->middleware('can:canasta.beneficiarios.editar');
    Route::get('show/{id}', 'Canasta_v2\BeneficiariosV2Controller@show')->name('show')->middleware('can:canasta.beneficiarios.show');
    Route::get('pdf/{id}', 'Canasta_v2\BeneficiariosV2Controller@pdf')->name('pdf')->middleware('can:canasta.beneficiarios.pdf');
    Route::get('excel', 'Canasta_v2\BeneficiariosV2Controller@excel')->name('excel')->middleware('can:canasta.beneficiarios.excel');
    Route::get('pdf-listar', 'Canasta_v2\BeneficiariosV2Controller@pdfListar')->name('pdf.listar')->middleware('can:canasta.beneficiarios.pdf.listar');
});
