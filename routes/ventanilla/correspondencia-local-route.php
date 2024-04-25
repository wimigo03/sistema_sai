<?php

Route::prefix('correspondencia-local')->name('correspondencia.local.')->middleware(['auth'])->group(function () {
    Route::get('/', 'CorrespondenciaLocalController@index')->name('index')->middleware('can:correspondencia_local.index');
    Route::get('createRecepcion', 'CorrespondenciaLocalController@createRecepcion')->name('crear')->middleware('can:correspondencia_local.crear');
    Route::get('buscarRemitentes', 'CorrespondenciaLocalController@buscarRemitentes')->name('remitente.buscar.crear')->middleware('can:correspondencia_local.crear');
    Route::post('storeRecepcion', 'CorrespondenciaLocalController@storeRecepcion')->name('guardar')->middleware('can:correspondencia_local.crear');
    Route::get('indexRemitente', 'CorrespondenciaLocalController@indexRemitente')->name('remitente.index')->middleware('can:correspondencia_local.remitente.index');
    Route::get('indexUnidad', 'CorrespondenciaLocalController@indexUnidad')->name('unidadIndex')->middleware('can:correspondencia_local.unidad.index');
    Route::get('createTipo', 'CorrespondenciaLocalController@createTipo')->name('tipo.crear')->middleware('can:correspondencia_local.tipo.crear');
    Route::post('storeTipo', 'CorrespondenciaLocalController@storeTipo')->name('tipo.guardar')->middleware('can:correspondencia_local.tipo.crear');
    Route::get('createRemitente', 'CorrespondenciaLocalController@createRemitente')->name('remitente.crear')->middleware('can:correspondencia_local.remitente.crear');
    Route::post('storeRemitente', 'CorrespondenciaLocalController@storeRemitente')->name('remitente.guardar')->middleware('can:correspondencia_local.remitente.crear');
    Route::get('createUnidad', 'CorrespondenciaLocalController@createLugar')->name('lugar.crear')->middleware('can:correspondencia_local.lugar.crear');
    Route::post('storeLugar', 'CorrespondenciaLocalController@storeLugar')->name('lugar.guardar')->middleware('can:correspondencia_local.lugar.crear');
    Route::get('{id}/gestionarCorrespondencia', 'CorrespondenciaLocalController@gestionarCorrespondencia')->name('gestionar')->middleware('can:correspondencia_local.gestionar');
    Route::get('urlfile/{id}', 'CorrespondenciaLocalController@urlfile')->name('urlfile')->middleware('can:correspondencia_local.urlfile');
    Route::get('{id}/cargarpdf', 'CorrespondenciaLocalController@cargarpdf')->name('cargarpdf')->middleware('can:correspondencia_local.cargarpdf');
    Route::post('storepdf', 'CorrespondenciaLocalController@storepdf')->name('storepdf')->middleware('can:correspondencia_local.cargarpdf');
    Route::get('{id}/actualizarpdf', 'CorrespondenciaLocalController@actualizarpdf')->name('actualizarpdf')->middleware('can:correspondencia_local.cargarpdf');
    Route::post('updatepdf', 'CorrespondenciaLocalController@updatepdf')->name('updatepdf')->middleware('can:correspondencia_local.cargarpdf');
    Route::get('{id}/edit', 'CorrespondenciaLocalController@editarCodigo')->name('edit')->middleware('can:correspondencia_local.edit');
    Route::post('{id}/updateCodigo', 'CorrespondenciaLocalController@updateCodigo')->name('update')->middleware('can:correspondencia_local.edit');
    Route::get('{id}/derivar', 'CorrespondenciaLocalController@derivar')->name('derivar')->middleware('can:correspondencia_local.derivar');
    Route::get('derivar2', 'CorrespondenciaLocalController@guardarderivacion')->name('guardarderivacion')->middleware('can:correspondencia_local.derivar');

    Route::get('delete{id}', 'CorrespondenciaLocalController@delete')->name('delete')->middleware('can:correspondencia_local.derivar');
    Route::post('/ruta', 'CorrespondenciaLocalController@respuesta')->name('pregunta')->middleware('can:correspondencia_local.derivar');
    Route::get('derivacion/index', 'CorrespondenciaLocalController@indexderivacion')->name('derivacion.index')->middleware('can:correspondencia_local.derivar');
    Route::get('derivacion/{id}/gestionarCorrespondencia', 'CorrespondenciaLocalController@gestionarCorrespondencia2')->name('derivacion.gestionar')->middleware('can:correspondencia_local.derivar');
    //Route::get('correspondencia2/urlfilederivacion/{id}', 'CorrespondenciaLocalController@urlfile')->name('derivacion.urlfilederivacion');
    //Route::get('correspondencia2/pregunta', 'CorrespondenciaLocalController@pregunta2')->name('derivacion.pregunta');
    //Route::get('/get-users', 'CorrespondenciaLocalController@getUsers')->name('get-users');
    //Route::post('/ruta', 'CorrespondenciaLocalController@respuesta')->name('pregunta');
});
