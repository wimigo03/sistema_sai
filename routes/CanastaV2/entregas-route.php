<?php

Route::prefix('entregas')->name('entregas.')->middleware(['auth'])->group(function () {
    Route::get('/', 'Canasta_v2\EntregasV2Controller@index')->name('index');
    Route::get('search', 'Canasta_v2\EntregasV2Controller@search')->name('search');
    Route::get('entrega_index/{id}', 'Canasta_v2\EntregasV2Controller@entrega_index')->name('entrega_index');
    Route::post('create', 'Canasta_v2\EntregasV2Controller@create')->name('create');
    Route::post('store', 'Canasta_v2\EntregasV2Controller@store')->name('store');
    Route::get('editar/{id}', 'Canasta_v2\EntregasV2Controller@editar')->name('editar');
    Route::post('update', 'Canasta_v2\EntregasV2Controller@update')->name('update');
    Route::get('habilitar/{id}', 'Canasta_v2\EntregasV2Controller@habilitar')->name('habilitar');
    Route::get('deshabilitar/{id}', 'Canasta_v2\EntregasV2Controller@deshabilitar')->name('deshabilitar');

    //Route::get('index_beneficiario1/{id1}', 'Canasta_v2\EntregasV2Controller@index_beneficiario1')->name('index_beneficiario1');
    //Route::get('index_beneficiario', 'Canasta_v2\EntregasV2Controller@index_beneficiario')->name('index_beneficiario');
    Route::get('search_entrega{id1}', 'Canasta_v2\EntregasV2Controller@search_entrega')->name('search_entrega');
    //Route::get('entrega_index/{id1}/{id2}', 'Canasta_v2\EntregasV2Controller@elegirBeneficiario')->name('elegirBeneficiario');
    Route::post('entrega_index', 'Canasta_v2\EntregasV2Controller@createEntrega')->name('createEntrega');

    Route::post('agregarporbarrio/{id}', 'Canasta_v2\EntregasV2Controller@agregarporbarrio')->name('agregarporbarrio');
    Route::get('generarboleta', 'Canasta_v2\EntregasV2Controller@generarboleta')->name('generarboleta');
    //Route::get('imprimir_boleta', 'Canasta_v2\EntregasV2Controller@imprimirboleta')->name('imprimir_boleta');
    Route::get('paquete_periodo/{id}', 'Canasta_v2\EntregasV2Controller@paquete_periodo')->name('paquete_periodo');
    Route::post('paquete_periodo_agregar/{id}', 'Canasta_v2\EntregasV2Controller@paquete_periodo_agregar')->name('paquete_periodo_agregar');
    Route::get('finalizar/{id}', 'Canasta_v2\EntregasV2Controller@finalizar')->name('finalizar');
    Route::get('eliminar_periodo/{id}', 'Canasta_v2\EntregasV2Controller@eliminar_periodo')->name('eliminar_periodo');
});
