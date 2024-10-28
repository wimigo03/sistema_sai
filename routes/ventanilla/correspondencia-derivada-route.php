<?php

Route::prefix('correspondencia-derivada')->name('correspondencia.derivada.')->middleware(['auth'])->group(function () {
    Route::get('/', 'CorrespondenciaDerivadaController@index')->name('index')->middleware('can:correspondencia_local.index');
    Route::get('createRecepcion', 'CorrespondenciaDerivadaController@createRecepcion')->name('crear')->middleware('can:correspondencia_local.crear');
    Route::get('buscarRemitentes', 'CorrespondenciaDerivadaController@buscarRemitentes')->name('remitente.buscar.crear')->middleware('can:correspondencia_local.crear');
    Route::post('storeRecepcion', 'CorrespondenciaDerivadaController@storeRecepcion')->name('guardar')->middleware('can:correspondencia_local.crear');
    Route::get('indexRemitente', 'CorrespondenciaDerivadaController@indexRemitente')->name('remitente.index')->middleware('can:correspondencia_local.remitente.index');
    Route::get('indexUnidad', 'CorrespondenciaDerivadaController@indexUnidad')->name('unidadIndex')->middleware('can:correspondencia_local.unidad.index');
    Route::get('createTipo', 'CorrespondenciaDerivadaController@createTipo')->name('tipo.crear')->middleware('can:correspondencia_local.tipo.crear');
    Route::post('storeTipo', 'CorrespondenciaDerivadaController@storeTipo')->name('tipo.guardar')->middleware('can:correspondencia_local.tipo.crear');
    Route::get('createRemitente', 'CorrespondenciaDerivadaController@createRemitente')->name('remitente.crear')->middleware('can:correspondencia_local.remitente.crear');
    Route::post('storeRemitente', 'CorrespondenciaDerivadaController@storeRemitente')->name('remitente.guardar')->middleware('can:correspondencia_local.remitente.crear');
    Route::get('createUnidad', 'CorrespondenciaDerivadaController@createLugar')->name('lugar.crear')->middleware('can:correspondencia_local.lugar.crear');
    Route::post('storeLugar', 'CorrespondenciaDerivadaController@storeLugar')->name('lugar.guardar')->middleware('can:correspondencia_local.lugar.crear');
    Route::get('{id}/gestionarCorrespondencia', 'CorrespondenciaDerivadaController@gestionarCorrespondencia')->name('gestionar')->middleware('can:correspondencia_local.gestionar');
    Route::get('urlfile/{id}', 'CorrespondenciaDerivadaController@urlfile')->name('urlfile')->middleware('can:correspondencia_local.urlfile');
    Route::get('{id}/cargarpdf', 'CorrespondenciaDerivadaController@cargarpdf')->name('cargarpdf')->middleware('can:correspondencia_local.cargarpdf');
    Route::post('storepdf', 'CorrespondenciaDerivadaController@storepdf')->name('storepdf')->middleware('can:correspondencia_local.cargarpdf');
    Route::get('{id}/actualizarpdf', 'CorrespondenciaDerivadaController@actualizarpdf')->name('actualizarpdf')->middleware('can:correspondencia_local.cargarpdf');
    Route::post('updatepdf', 'CorrespondenciaDerivadaController@updatepdf')->name('updatepdf')->middleware('can:correspondencia_local.cargarpdf');
    Route::get('{id}/edit', 'CorrespondenciaDerivadaController@editarCodigo')->name('edit')->middleware('can:correspondencia_local.edit');
    Route::post('{id}/updateCodigo', 'CorrespondenciaDerivadaController@updateCodigo')->name('update')->middleware('can:correspondencia_local.edit');
    Route::get('{id}/derivar', 'CorrespondenciaDerivadaController@derivar')->name('derivar')->middleware('can:correspondencia_local.derivar');
    Route::get('derivar2', 'CorrespondenciaDerivadaController@guardarderivacion')->name('guardarderivacion')->middleware('can:correspondencia_local.derivar');
    Route::get('delete{id}', 'CorrespondenciaDerivadaController@delete')->name('delete')->middleware('can:correspondencia_local.derivar');
    Route::post('/ruta', 'CorrespondenciaDerivadaController@respuesta')->name('pregunta')->middleware('can:correspondencia_local.derivar');
    Route::get('derivacion/index', 'CorrespondenciaDerivadaController@indexderivacion')->name('derivacion.index')->middleware('can:correspondencia_local.derivar');
    Route::get('derivacion/{id}/gestionarCorrespondencia', 'CorrespondenciaDerivadaController@gestionarCorrespondencia2')->name('derivacion.gestionar')->middleware('can:correspondencia_local.derivar');
    Route::get('/generar-qr/{id}','CorrespondenciaDerivadaController@generar_qr')->name('generar.qr')->middleware('can:correspondencia_local.generar.qr');

    Route::post('/ruta', 'CorrespondenciaDerivadaController@respuesta')->name('pregunta');
});
