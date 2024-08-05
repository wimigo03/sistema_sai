<?php

Route::prefix('paquetesdisc')->name('paquetesdisc.')->middleware(['auth'])->group(function () {
    Route::get('/', 'Canasta_v2disc\PaquetesV2Controller@index')->name('index')->middleware('can:canasta.paquetes.index');
    Route::get('search', 'Canasta_v2disc\PaquetesV2Controller@search')->name('search')->middleware('can:canasta.paquetes.index');
    Route::get('create', 'Canasta_v2disc\PaquetesV2Controller@create')->name('create')->middleware('can:canasta.paquetes.create');
    Route::post('store', 'Canasta_v2disc\PaquetesV2Controller@store')->name('store')->middleware('can:canasta.paquetes.create');
    Route::get('editar/{id}', 'Canasta_v2disc\PaquetesV2Controller@editar')->name('editar')->middleware('can:canasta.paquetes.editar');
    Route::post('update', 'Canasta_v2disc\PaquetesV2Controller@update')->name('update')->middleware('can:canasta.paquetes.editar');
    Route::get('beneficiarios/{paquete_id}', 'Canasta_v2disc\PaquetesV2Controller@beneficiarios')->name('beneficiarios')->middleware('can:canasta.paquetes.beneficiarios');
    Route::get('beneficiarios-search/{paquete_id}', 'Canasta_v2disc\PaquetesV2Controller@beneficiariosSearch')->name('beneficiarios.search')->middleware('can:canasta.paquetes.beneficiarios');
    Route::get('beneficiarios-excel/{paquete_id}', 'Canasta_v2disc\PaquetesV2Controller@beneficiariosExcel')->name('beneficiarios.excel')->middleware('can:canasta.paquetes.beneficiarios');
    Route::get('beneficiarios-pdf/{paquete_id}', 'Canasta_v2disc\PaquetesV2Controller@beneficiariosPdf')->name('beneficiarios.pdf')->middleware('can:canasta.paquetes.beneficiarios');
});
