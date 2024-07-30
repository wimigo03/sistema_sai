<?php

Route::prefix('solicitud-compra')->name('solicitud.compra.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Compras\SolicitudCompraController@index')->name('index')->middleware('can:solicitud.compra.index');
    Route::get('search', 'Compras\SolicitudCompraController@search')->name('search')->middleware('can:solicitud.compra.index');
    Route::get('create', 'Compras\SolicitudCompraController@create')->name('create')->middleware('can:solicitud.compra.create');
    Route::get('/insertar-producto', 'Compras\SolicitudCompraController@insertarProducto')->name('insertar.producto')->middleware('can:solicitud.compra.create');
    Route::get('/get_partidas_presupuestarias', 'Compras\SolicitudCompraController@getPartidasPresupuestarias')->name('get.partidas.presupuestarias')->middleware('can:solicitud.compra.create');
    Route::get('/get_items', 'Compras\SolicitudCompraController@getItems')->name('get.items')->middleware('can:solicitud.compra.create');
    Route::post('store', 'Compras\SolicitudCompraController@store')->name('store')->middleware('can:solicitud.compra.create');
    Route::get('show/{solicitud_compra_id}', 'Compras\SolicitudCompraController@show')->name('show')->middleware('can:solicitud.compra.show');
    Route::get('editar/{solicitud_compra_id}', 'Compras\SolicitudCompraController@editar')->name('editar')->middleware('can:solicitud.compra.editar');
    Route::get('/eliminar_registro/{solicitud_compra_detalle_id}', 'Compras\SolicitudCompraController@eliminarRegistro')->name('eliminar_registro')->middleware('can:solicitud.compra.editar');
    Route::post('update', 'Compras\SolicitudCompraController@update')->name('update')->middleware('can:solicitud.compra.editar');
    Route::get('aprobar/{solicitud_compra_id}', 'Compras\SolicitudCompraController@aprobar')->name('aprobar')->middleware('can:solicitud.compra.aprobar');
    Route::get('rechazar/{solicitud_compra_id}', 'Compras\SolicitudCompraController@rechazar')->name('rechazar')->middleware('can:solicitud.compra.aprobar');
    Route::get('pendiente/{solicitud_compra_id}', 'Compras\SolicitudCompraController@pendiente')->name('pendiente')->middleware('can:solicitud.compra.pendiente');
    Route::get('pdf/{solicitud_compra_id}', 'Compras\SolicitudCompraController@pdf')->name('pdf')->middleware('can:solicitud.compra.pdf');
});
