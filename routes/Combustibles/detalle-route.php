<?php

Route::prefix('detalle')->name('detalle.')->middleware(['auth'])->group(function () { 

    Route::get('index', 'Compra\DetalleCompraCombController@index')->name('index');
    Route::get('index2', 'Compra\DetalleCompraCombController@index2')->name('index2');
    Route::get('index3', 'Compra\DetalleCompraCombController@index3')->name('index3');
    Route::get('index4', 'Compra\DetalleCompraCombController@index4')->name('index4');
    Route::get('index5', 'Compra\DetalleCompraCombController@index5')->name('index5');
    Route::post('store', 'Compra\DetalleCompraCombController@store')->name('store');
    Route::get('principal/{id}', 'Compra\DetalleCompraCombController@crearOrdenxxx')->name('principal');
    Route::post('principal/store', 'Compra\DetalleCompraCombController@crearOrden')->name('principal.store');
    Route::get('principalorden/{id}', 'Compra\DetalleCompraCombController@crearOrdendocxx')->name('principalorden');
    Route::get('show', 'Compra\DetalleCompraCombController@show')->name('show');
    Route::post('principalorden', 'Compra\DetalleCompraCombController@crearOrdendoc')->name('DetalleCompraCombController.crearOrdendoc');
    Route::get('destroyed2/{id}', 'Compra\DetalleCompraCombController@destroyed2')->name('DetalleCompraCombController.eliminar2');
    Route::get('invitacion/{id}', 'Compra\DetalleCompraCombController@invitacion')->name('principal.invitacion');
    Route::get('aceptacion/{id}', 'Compra\DetalleCompraCombController@aceptacion')->name('principal.aceptacion');
    Route::get('cotizacion/{id}', 'Compra\DetalleCompraCombController@cotizacion')->name('principal.cotizacion');
    Route::get('adjudicacion/{id}', 'Compra\DetalleCompraCombController@adjudicacion')->name('principal.adjudicacion');
    Route::get('orden/{id}', 'Compra\DetalleCompraCombController@orden')->name('principal.orden');

    Route::get('delete/{id}', 'Compra\DetalleCompraCombController@delete')->name('delete');
    Route::get('aprovar/{id}', 'Compra\DetalleCompraCombController@aprovar')->name('aprovar');
    Route::get('rechazar/{id}', 'Compra\DetalleCompraCombController@rechazar')->name('rechazar');
    Route::get('almacen/{id}', 'Compra\DetalleCompraCombController@almacen')->name('almacen');
    Route::get('almacendos/{id}', 'Compra\DetalleCompraCombController@almacendos')->name('almacendos');

});