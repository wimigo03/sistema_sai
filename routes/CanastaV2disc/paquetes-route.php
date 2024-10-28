<?php

Route::prefix('paquetesdisc')->name('paquetesdisc.')->middleware(['auth'])->group(function () {
    Route::get('/', 'Canasta_v2disc\PaquetesV2Controller@index')->name('index')->middleware('can:canastadisc.paquetes.index');
    Route::get('search', 'Canasta_v2disc\PaquetesV2Controller@search')->name('search')->middleware('can:canastadisc.paquetes.index');
    Route::get('create', 'Canasta_v2disc\PaquetesV2Controller@create')->name('create')->middleware('can:canastadisc.paquetes.create');
    Route::post('store', 'Canasta_v2disc\PaquetesV2Controller@store')->name('store')->middleware('can:canastadisc.paquetes.create');
    Route::get('editar/{id}', 'Canasta_v2disc\PaquetesV2Controller@editar')->name('editar')->middleware('can:canastadisc.paquetes.editar');
    Route::post('update', 'Canasta_v2disc\PaquetesV2Controller@update')->name('update')->middleware('can:canastadisc.paquetes.editar');
    Route::get('beneficiarios/{paquete_id}', 'Canasta_v2disc\PaquetesV2Controller@beneficiarios')->name('beneficiarios')->middleware('can:canastadisc.paquetes.beneficiarios');
    Route::get('beneficiarios-search/{paquete_id}', 'Canasta_v2disc\PaquetesV2Controller@beneficiariosSearch')->name('beneficiarios.search')->middleware('can:canastadisc.paquetes.beneficiarios');
    Route::get('beneficiarios-excel/{paquete_id}', 'Canasta_v2disc\PaquetesV2Controller@beneficiariosExcel')->name('beneficiarios.excel')->middleware('can:canastadisc.paquetes.beneficiarios');
    Route::get('beneficiarios-pdf/{paquete_id}', 'Canasta_v2disc\PaquetesV2Controller@beneficiariosPdf')->name('beneficiarios.pdf')->middleware('can:canastadisc.paquetes.beneficiarios');
});
