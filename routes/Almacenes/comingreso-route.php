<?php

Route::prefix('comingreso')->name('comingreso.')->middleware(['auth'])->group(function () { 
 

    Route::get('index', 'Almacen\Comprobante\ComingresoController@index')->name('index');
    Route::get('create', 'Almacen\Comprobante\ComingresoController@create')->name('create');
    Route::post('store', 'Almacen\Comprobante\ComingresoController@store')->name('store');
    Route::get('createdoc/{id}', 'Almacen\Comprobante\ComingresoController@createdoc')->name('createdoc');
    Route::POST('insertar', 'Almacen\Comprobante\ComingresoController@insertar')->name('insertar');
    Route::get('almacendos/{id}', 'Almacen\Comprobante\ComingresoController@almacendos')->name('almacendos');

  
    Route::get('editardoc/{id}', 'Almacen\Comprobante\ComingresoController@editardoc')->name('editardoc');
    Route::get('editardocn/{id}', 'Almacen\Comprobante\ComingresoController@editardocn')->name('editardocn');

    Route::get('editar/{id}', 'Almacen\Comprobante\ComingresoController@editar')->name('editar');
   Route::get('editarn/{id}', 'Almacen\Comprobante\ComingresoController@editarn')->name('editarn');

   Route::post('update', 'Almacen\Comprobante\ComingresoController@update')->name('update');
   Route::post('updaten', 'Almacen\Comprobante\ComingresoController@updaten')->name('updaten');

   Route::get('editararchivo/{id}', 'Almacen\Comprobante\ComingresoController@editararchivo')->name('editararchivo');
   Route::post('updatearchivonota/{id}', 'Almacen\Comprobante\ComingresoController@updatearchivonota')->name('updatearchivonota');

   Route::get('editararchivon/{id}', 'Almacen\Comprobante\ComingresoController@editararchivon')->name('editararchivon');
   Route::post('updatearchivonotan/{id}', 'Almacen\Comprobante\ComingresoController@updatearchivonotan')->name('updatearchivonotan');

   Route::get('solicitud/{id}', 'Almacen\Comprobante\ComingresoController@solicitud')->name('solicitud');


//    Route::get('editararchivo/{id}', 'Almacen\Ingreso\IngresoController@editararchivo')->name('editararchivo');
//    Route::POST('updatearchivonota/{id}', 'Almacen\Ingreso\IngresoController@updatearchivonota')->name('updatearchivonota');

//    Route::get('grafico', 'Almacen\Ingreso\IngresoController@grafico')->name('grafico');
//    Route::get('detalle/{id}', 'Almacen\Ingreso\IngresoController@detalle')->name('detalle');
//    Route::get('solicitud/{id}', 'Almacen\Ingreso\IngresoController@solicitud')->name('solicitud');
//    Route::get('reporte', 'Almacen\Ingreso\IngresoController@reporte')->name('reporte');
//    Route::post('store2', 'Almacen\Ingreso\IngresoController@store2')->name('store2');
//    Route::get('delete2/{id}', 'Almacen\Ingreso\IngresoController@delete')->name('delete');
//    Route::get('delete3/{id}', 'Almacen\Ingreso\IngresoController@deletedos')->name('deletedos');
 
});