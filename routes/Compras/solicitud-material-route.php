<?php

Route::prefix('solicitud-material')->name('solicitud.material.')->middleware(['auth'])->group(function () {
    Route::get('/', 'Compras\SolicitudMaterialController@index')->name('index')->middleware('can:solicitud.material.index');
    Route::get('search', 'Compras\SolicitudMaterialController@search')->name('search')->middleware('can:solicitud.material.index');
    Route::get('create', 'Compras\SolicitudMaterialController@create')->name('create')->middleware('can:solicitud.material.create');
    Route::post('store', 'Compras\SolicitudMaterialController@store')->name('store')->middleware('can:solicitud.material.create');
    Route::get('show/{id}', 'Compras\SolicitudMaterialController@show')->name('show')->middleware('can:solicitud.material.show');
    Route::get('editar/{id}', 'Compras\SolicitudMaterialController@editar')->name('editar')->middleware('can:solicitud.material.editar');
    Route::get('eliminar_registro/{detalle_id}', 'Compras\SolicitudMaterialController@eliminarRegistro')->name('eliminar')->middleware('can:solicitud.material.editar');
    Route::post('update', 'Compras\SolicitudMaterialController@update')->name('update')->middleware('can:solicitud.material.editar');
    Route::get('pdf/{id}', 'Compras\SolicitudMaterialController@pdf')->name('pdf')->middleware('can:solicitud.material.pdf');
    Route::post('aprobar', 'Compras\SolicitudMaterialController@aprobar')->name('aprobar')->middleware('can:solicitud.material.aprobar');
    Route::get('rechazar/{id}', 'Compras\SolicitudMaterialController@rechazar')->name('rechazar')->middleware('can:solicitud.material.aprobar');
    Route::get('pendiente/{id}', 'Compras\SolicitudMaterialController@pendiente')->name('pendiente')->middleware('can:solicitud.material.pendiente');
});
