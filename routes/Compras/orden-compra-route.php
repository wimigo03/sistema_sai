<?php

Route::prefix('orden-compra')->name('orden.compra.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Compras\OrdenCompraController@index')->name('index')->middleware('can:orden.compra.index');
    Route::get('search', 'Compras\OrdenCompraController@search')->name('search')->middleware('can:orden.compra.index');
    Route::get('create', 'Compras\OrdenCompraController@create')->name('create')->middleware('can:orden.compra.create');/*** */
    Route::get('show/{orden_compra_id}', 'Compras\OrdenCompraController@show')->name('show')->middleware('can:orden.compra.show');
    Route::get('editar/{orden_compra_id}', 'Compras\OrdenCompraController@editar')->name('editar')->middleware('can:orden.compra.editar');
    Route::post('update', 'Compras\OrdenCompraController@update')->name('update')->middleware('can:orden.compra.editar');
    Route::get('aprobar/{orden_compra_id}', 'Compras\OrdenCompraController@aprobar')->name('aprobar')->middleware('can:orden.compra.aprobar');
    Route::get('rechazar/{orden_compra_id}', 'Compras\OrdenCompraController@rechazar')->name('rechazar')->middleware('can:orden.compra.aprobar');
    Route::get('pdf/{orden_compra_id}', 'Compras\OrdenCompraController@pdf')->name('pdf')->middleware('can:orden.compra.pdf');
});
