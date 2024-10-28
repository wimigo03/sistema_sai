<?php

Route::prefix('paquetes-barriodisc')->name('paquetes.barriodisc.')->middleware(['auth'])->group(function () {
    Route::get('/{paquete_id}', 'Canasta_v2disc\PaqueteBarrioV2Controller@index')->name('index')->middleware('can:canastadisc.paquetes.barrio.index');
    Route::get('/get_barrios/{paquete_id}', 'Canasta_v2disc\PaqueteBarrioV2Controller@getBarrios')->name('get.barrios')->middleware('can:canastadisc.paquetes.barrio.index');
    Route::get('/search/{paquete_id}', 'Canasta_v2disc\PaqueteBarrioV2Controller@search')->name('search')->middleware('can:canastadisc.paquetes.barrio.index');
    Route::get('/pdf/{paquete_id}', 'Canasta_v2disc\PaqueteBarrioV2Controller@pdf')->name('pdf')->middleware('can:canastadisc.paquetes.barrio.pdf');
    Route::get('/excel/{paquete_id}', 'Canasta_v2disc\PaqueteBarrioV2Controller@excel')->name('excel')->middleware('can:canastadisc.paquetes.barrio.excel');
    Route::get('create/{paquete_id}', 'Canasta_v2disc\PaqueteBarrioV2Controller@create')->name('create')->middleware('can:canastadisc.paquetes.barrio.create');
    Route::post('store/{paquete_id}', 'Canasta_v2disc\PaqueteBarrioV2Controller@store')->name('store')->middleware('can:canastadisc.paquetes.barrio.create');
    Route::get('/editar/{paquete_barrio_id}', 'Canasta_v2disc\PaqueteBarrioV2Controller@editar')->name('editar')->middleware('can:canastadisc.paquetes.barrio.editar');
    Route::post('update', 'Canasta_v2disc\PaqueteBarrioV2Controller@update')->name('update')->middleware('can:canastadisc.paquetes.barrio.editar');
});
