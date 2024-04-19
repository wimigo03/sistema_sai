<?php

Route::prefix('entregas')->name('entregas.')->middleware(['auth'])->group(function () {
    Route::get('/', 'Canasta_v2\EntregasV2Controller@index')->name('index')->middleware('can:canasta.entregas.index');
    Route::get('search', 'Canasta_v2\EntregasV2Controller@search')->name('search')->middleware('can:canasta.entregas.index');
    Route::get('entrega_index/{id}', 'Canasta_v2\EntregasV2Controller@entrega_index')->name('entrega_index')->middleware('can:canasta.entregas.paquete.index');
    Route::post('create', 'Canasta_v2\EntregasV2Controller@create')->name('create')->middleware('can:canasta.entregas.create');
    Route::post('store', 'Canasta_v2\EntregasV2Controller@store')->name('store')->middleware('can:canasta.entregas.create');
    Route::get('edit_paquete/{id}', 'Canasta_v2\EntregasV2Controller@edit_paquete')->name('edit_paquete')->middleware('can:canasta.paquete.editar');
    Route::post('update_paquete', 'Canasta_v2\EntregasV2Controller@update_paquete')->name('update_paquete')->middleware('can:canasta.paquete.editar');
    Route::get('paquete_periodo/{id}', 'Canasta_v2\EntregasV2Controller@paquete_periodo')->name('paquete_periodo')->middleware('can:canasta.paquete.periodo');
    Route::post('paquete_periodo_agregar/{id}', 'Canasta_v2\EntregasV2Controller@paquete_periodo_agregar')->name('paquete_periodo_agregar')->middleware('can:canasta.paquete.periodo');
    Route::get('finalizar/{id}', 'Canasta_v2\EntregasV2Controller@finalizar')->name('finalizar')->middleware('can:canasta.entregas.finalizar');
    Route::get('eliminar_periodo/{id}', 'Canasta_v2\EntregasV2Controller@eliminar_periodo')->name('eliminar_periodo')->middleware('can:canasta.periodo.eliminar');
    //Route::get('editar/{id}', 'Canasta_v2\EntregasV2Controller@editar')->name('editar')->middleware('can:canasta.entregas.editar');
    //Route::post('update', 'Canasta_v2\EntregasV2Controller@update')->name('update')->middleware('can:canasta.entregas.editar');
    //Route::get('habilitar/{id}', 'Canasta_v2\EntregasV2Controller@habilitar')->name('habilitar');
    //Route::get('deshabilitar/{id}', 'Canasta_v2\EntregasV2Controller@deshabilitar')->name('deshabilitar');
    //Route::get('index_beneficiario1/{id1}', 'Canasta_v2\EntregasV2Controller@index_beneficiario1')->name('index_beneficiario1');
    //Route::get('index_beneficiario', 'Canasta_v2\EntregasV2Controller@index_beneficiario')->name('index_beneficiario');
    Route::get('search_entrega{id1}', 'Canasta_v2\EntregasV2Controller@search_entrega')->name('search_entrega');
    //Route::get('entrega_index/{id1}/{id2}', 'Canasta_v2\EntregasV2Controller@elegirBeneficiario')->name('elegirBeneficiario');
    Route::get('create_paquete', 'Canasta_v2\EntregasV2Controller@create_paquete')->name('create_paquete');
    Route::post('store_paquete', 'Canasta_v2\EntregasV2Controller@store_paquete')->name('store_paquete');


    Route::post('agregarporbarrio/{id}', 'Canasta_v2\EntregasV2Controller@agregarporbarrio')->name('agregarporbarrio');
    Route::get('generarboleta', 'Canasta_v2\EntregasV2Controller@generarboleta')->name('generarboleta');
    Route::get('generarboleta2/{id}', 'Canasta_v2\EntregasV2Controller@generarboleta2')->name('generarboleta2');
    //Route::get('imprimir_boleta', 'Canasta_v2\EntregasV2Controller@imprimirboleta')->name('imprimir_boleta');



});
