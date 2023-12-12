<?php

Route::prefix('expochaco')->name('expochaco.')->middleware(['auth'])->group(function () {
    Route::get('/index', 'Fexpo\SolicitudController@index')->name('index');
    Route::get('/rubro', 'ExpoController@rubro')->name('rubro');
    Route::get('/createrubro', 'ExpoController@createrubro')->name('createrubro');
    Route::post('/storerubro', 'ExpoController@storerubro')->name('storerubro');

    Route::get('expochaco/index2', [SolicitudController::class,'index2'])
->name('expochaco.index2');



Route::get('expochaco/{id}/editar', [SolicitudController::class,'editar'])
->name('expochaco.editar');


Route::get('expochaco/imprimir/{id}', [SolicitudController::class,'imprimirboleta'])
->name('expochaco.imprimir');

Route::post('expochaco/update', [SolicitudController::class,'update'])
->name('expochaco.update');

Route::get('expochaco/delete2/{id}', [SolicitudController::class,'delete'])
->name('expochaco.delete');

Route::get('expochaco/aprovar/{id}', [SolicitudController::class,'aprovar'])
->name('expochaco.aprovar');

Route::get('expochaco/credenciales/{id}', [SolicitudController::class,'credencial'])
->name('expochaco.credencial');

Route::get('expochaco/createcredencial/{id}', [SolicitudController::class,'createcredencial'])->name('credencial.create');
Route::POST('expochaco/insertarcredencial', [SolicitudController::class,'insertarcredencial'])->name('credencial.insertarcredencial');

Route::get('expochaco/generarqr/{id}', [SolicitudController::class,'codigoqr'])
->name('expochaco.generarqr');
});
