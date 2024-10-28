<?php

Route::prefix('entregasdisc')->name('entregasdisc.')->middleware(['auth'])->group(function () {
    Route::get('/{paquete_barrio_id}', 'Canasta_v2disc\EntregasV2Controller@index')->name('index')->middleware('can:canastadisc.entregas.index');
    Route::get('search/{paquete_barrio_id}', 'Canasta_v2disc\EntregasV2Controller@search')->name('search')->middleware('can:canastadisc.entregas.index');
    Route::get('create/{paquete_barrio_id}', 'Canasta_v2disc\EntregasV2Controller@create')->name('create')->middleware('can:canastadisc.entregas.create');
    Route::post('store/{paquete_barrio_id}', 'Canasta_v2disc\EntregasV2Controller@store')->name('store')->middleware('can:canastadisc.entregas.create');
    Route::post('habilitar', 'Canasta_v2disc\EntregasV2Controller@habilitar')->name('habilitar')->middleware('can:canastadisc.entregas.habilitar');
    Route::get('deshabilitar/{entrega_id}', 'Canasta_v2disc\EntregasV2Controller@deshabilitar')->name('deshabilitar')->middleware('can:canastadisc.entregas.habilitar');
    Route::get('habilitar-todo/{paquete_barrio_id}', 'Canasta_v2disc\EntregasV2Controller@habilitar_todo')->name('habilitar.todo')->middleware('can:canastadisc.entregas.habilitar.todo');
    Route::get('deshabilitar-todo/{paquete_barrio_id}', 'Canasta_v2disc\EntregasV2Controller@deshabilitar_todo')->name('deshabilitar.todo')->middleware('can:canastadisc.entregas.habilitar.todo');
    Route::get('/get-boleta-entrega/{entrega_id}', 'Canasta_v2disc\EntregasV2Controller@get_boleta_entrega')->name('get.boleta.entrega')->middleware('can:canastadisc.entregas.get.boleta');
    Route::get('get-boletas-entrega/{paquete_barrio_id}', 'Canasta_v2disc\EntregasV2Controller@get_boletas_entrega')->name('get.boletas.entrega')->middleware('can:canastadisc.entregas.get.boletas');
    Route::get('get-listado-habilitados-sin/{paquete_barrio_id}', 'Canasta_v2disc\EntregasV2Controller@pdf_habilitados_sin_registro')->name('pdf.habilitados.sin.registro')->middleware('can:canastadisc.entregas.pdf.habilitados.sin');
    Route::get('get-listado-habilitados-con/{paquete_barrio_id}', 'Canasta_v2disc\EntregasV2Controller@pdf_habilitados_con_registro')->name('pdf.habilitados.con.registro')->middleware('can:canastadisc.entregas.pdf.habilitados.con');
    Route::get('excel/{paquete_barrio_id}', 'Canasta_v2disc\EntregasV2Controller@excel')->name('excel')->middleware('can:canastadisc.entregas.excel');
    Route::get('finalizar/{paquete_barrio_id}', 'Canasta_v2disc\EntregasV2Controller@finalizar')->name('finalizar')->middleware('can:canastadisc.entregas.finalizar');
    Route::get('restablecer/{paquete_barrio_id}', 'Canasta_v2disc\EntregasV2Controller@restablecer')->name('restablecer')->middleware('can:canastadisc.entregas.restablecer');
    Route::get('editar/{entrega_id}', 'Canasta_v2disc\EntregasV2Controller@editar')->name('editar')->middleware('can:canastadisc.entregas.editar');
    Route::post('update', 'Canasta_v2disc\EntregasV2Controller@update')->name('update')->middleware('can:canastadisc.entregas.editar');
});
