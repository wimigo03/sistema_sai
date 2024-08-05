<?php

Route::prefix('entrega-beneficiario')->name('entrega.beneficiario.')->middleware(['auth'])->group(function () {
    Route::get('/', 'Canasta_v2\EntregaBeneficiarioV2Controller@index')->name('index')->middleware('can:canasta.entregas.beneficiario.index');
    Route::get('search', 'Canasta_v2\EntregaBeneficiarioV2Controller@search')->name('search')->middleware('can:canasta.entregas.beneficiario.index');
});
