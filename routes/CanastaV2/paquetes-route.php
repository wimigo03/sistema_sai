<?php

Route::prefix('paquetes')->name('paquetes.')->middleware(['auth'])->group(function () {
    Route::get('/', 'Canasta_v2\PaquetesV2Controller@index')->name('index')->middleware('can:canasta.paquetes.index');
    /*Route::get('search', 'Canasta_v2\EntregasV2Controller@search')->name('search')->middleware('can:canasta.entregas.index');
    Route::get('entrega-index/{id}', 'Canasta_v2\EntregasV2Controller@entrega_index')->name('entrega_index')->middleware('can:canasta.entregas.paquete.index');
    Route::get('search_entrega{id1}', 'Canasta_v2\EntregasV2Controller@search_entrega')->name('search_entrega')->middleware('can:canasta.entregas.paquete.index');
    Route::get('create-paquete', 'Canasta_v2\EntregasV2Controller@create_paquete')->name('create_paquete')->middleware('can:canasta.entregas.paquete.create');
    Route::post('store_paquete', 'Canasta_v2\EntregasV2Controller@store_paquete')->name('store_paquete')->middleware('can:canasta.entregas.paquete.create');
    Route::get('edit_paquete/{id}', 'Canasta_v2\EntregasV2Controller@edit_paquete')->name('edit_paquete')->middleware('can:canasta.paquete.editar');
    Route::post('update_paquete', 'Canasta_v2\EntregasV2Controller@update_paquete')->name('update_paquete')->middleware('can:canasta.paquete.editar');
    Route::get('paquete-periodo/{id}', 'Canasta_v2\EntregasV2Controller@paquete_periodo')->name('paquete_periodo')->middleware('can:canasta.paquete.periodo');
    Route::post('paquete_periodo_agregar/{id}', 'Canasta_v2\EntregasV2Controller@paquete_periodo_agregar')->name('paquete_periodo_agregar')->middleware('can:canasta.paquete.periodo');
    Route::get('finalizar/{id}', 'Canasta_v2\EntregasV2Controller@finalizar')->name('finalizar')->middleware('can:canasta.entregas.finalizar');
    Route::get('eliminar_periodo/{id}', 'Canasta_v2\EntregasV2Controller@eliminar_periodo')->name('eliminar_periodo')->middleware('can:canasta.periodo.eliminar');
    Route::post('agregarporbarrio/{id}', 'Canasta_v2\EntregasV2Controller@agregarporbarrio')->name('agregarporbarrio')->middleware('can:canasta.entregas.agregar.porbarrio');
    Route::get('generarboleta', 'Canasta_v2\EntregasV2Controller@generarboleta')->name('generarboleta')->middleware('can:canasta.entregas.generar.boleta');
    Route::get('generarboleta2/{id}', 'Canasta_v2\EntregasV2Controller@generarboleta2')->name('generarboleta2')->middleware('can:canasta.entregas.generar.boleta');
    Route::get('impDetallebarrio', 'Canasta_v2\EntregasV2Controller@detalleBarrio')->name('detalleBarrio')->middleware('can:canasta.entregas.generar.boleta');
    Route::get('impDetallebarrio2', 'Canasta_v2\EntregasV2Controller@detalleBarrio2')->name('detalleBarrio2')->middleware('can:canasta.entregas.generar.boleta');
    Route::get('habilitar/{id}/{id2}', 'Canasta_v2\EntregasV2Controller@habilitar')->name('habilitar');
    Route::get('deshabilitar/{id3}/{id4}', 'Canasta_v2\EntregasV2Controller@deshabilitar')->name('deshabilitar');
    Route::get('confirmar_entrega', 'Canasta_v2\EntregasV2Controller@confirmar_entrega')->name('confirmar_entrega');
    Route::get('entrega_index2/{id}', 'Canasta_v2\EntregasV2Controller@entrega_index2')->name('entrega_index2');
    Route::get('createEntrega', 'Canasta_v2\EntregasV2Controller@createEntrega')->name('createEntrega');*/


});
