<?php

Route::prefix('salida-almacen')->name('salida.almacen.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Compras\SalidaAlmacenController@index')->name('index')->middleware('can:salida.almacen.index');
    Route::get('search', 'Compras\SalidaAlmacenController@search')->name('search')->middleware('can:salida.almacen.index');
    Route::get('create', 'Compras\SalidaAlmacenController@create')->name('create')->middleware('can:salida.almacen.index');
    Route::post('store', 'Compras\SalidaAlmacenController@store')->name('store')->middleware('can:salida.almacen.index');

    /*Route::get('/insertar-producto', 'Compras\SolicitudCompraController@insertarProducto')->name('insertar.producto')->middleware('can:solicitud.compra.create');
    Route::get('/get_partidas_presupuestarias', 'Compras\SolicitudCompraController@getPartidasPresupuestarias')->name('get.partidas.presupuestarias')->middleware('can:solicitud.compra.create');
    Route::get('/get_items', 'Compras\SolicitudCompraController@getItems')->name('get.items')->middleware('can:solicitud.compra.create');
    Route::get('show/{solicitud_compra_id}', 'Compras\SolicitudCompraController@show')->name('show')->middleware('can:solicitud.compra.show');
    Route::get('editar/{solicitud_compra_id}', 'Compras\SolicitudCompraController@editar')->name('editar')->middleware('can:solicitud.compra.editar');
    Route::get('/eliminar_registro/{solicitud_compra_detalle_id}', 'Compras\SolicitudCompraController@eliminarRegistro')->name('eliminar_registro')->middleware('can:solicitud.compra.editar');
    Route::post('update', 'Compras\SolicitudCompraController@update')->name('update')->middleware('can:solicitud.compra.editar');
    Route::get('aprobar/{solicitud_compra_id}', 'Compras\SolicitudCompraController@aprobar')->name('aprobar')->middleware('can:solicitud.compra.aprobar');
    Route::get('rechazar/{solicitud_compra_id}', 'Compras\SolicitudCompraController@rechazar')->name('rechazar')->middleware('can:solicitud.compra.aprobar');
    Route::get('pendiente/{solicitud_compra_id}', 'Compras\SolicitudCompraController@pendiente')->name('pendiente')->middleware('can:solicitud.compra.pendiente');
    Route::get('pdf/{solicitud_compra_id}', 'Compras\SolicitudCompraController@pdf')->name('pdf')->middleware('can:solicitud.compra.pdf');*/
});
