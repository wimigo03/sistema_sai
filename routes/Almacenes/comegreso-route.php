<?php

Route::prefix('comegreso')->name('comegreso.')->middleware(['auth'])->group(function () { 
 

    Route::get('index', 'Almacen\Comprobante\ComegresoController@index')->name('index');
    Route::get('create', 'Almacen\Comprobante\ComegresoController@create')->name('create');
    Route::post('store', 'Almacen\Comprobante\ComegresoController@store')->name('store');

    //    Route::get('editardoc/{id}', 'Almacen\Comprobante\ComegresoController@editardoc')->name('editardoc');
   Route::get('editar/{id}', 'Almacen\Comprobante\ComegresoController@editar')->name('editar');
   Route::get('editarcinco/{id}', 'Almacen\Comprobante\ComegresoController@editarcinco')->name('editarcinco');
   Route::get('editarseis/{id}', 'Almacen\Comprobante\ComegresoController@editarseis')->name('editarseis');

   Route::get('editardos/{id}', 'Almacen\Comprobante\ComegresoController@editardos')->name('editardos');

   Route::post('update', 'Almacen\Comprobante\ComegresoController@update')->name('update');
   Route::post('updatedos', 'Almacen\Comprobante\ComegresoController@updatedos')->name('updatedos');

   Route::get('editardoc/{id}', 'Almacen\Comprobante\ComegresoController@editardoc')->name('editardoc');
   Route::get('editardoccinco/{id}', 'Almacen\Comprobante\ComegresoController@editardoccinco')->name('editardoccinco');
   Route::get('editardocseis/{id}', 'Almacen\Comprobante\ComegresoController@editardocseis')->name('editardocseis');
   Route::get('editardocsiete/{id}', 'Almacen\Comprobante\ComegresoController@editardocsiete')->name('editardocsiete');

   Route::get('editardetalle/{id}', 'Almacen\Comprobante\ComegresoController@editardetalle')->name('editardetalle');

   Route::get('editararchivo/{id}', 'Almacen\Comprobante\ComegresoController@editararchivo')->name('editararchivo');
   Route::post('updatearchivonota/{id}', 'Almacen\Comprobante\ComegresoController@updatearchivonota')->name('updatearchivonota');
   Route::get('editararchivoseis/{id}', 'Almacen\Comprobante\ComegresoController@editararchivoseis')->name('editararchivoseis');
   Route::post('updatearchivonotaseis/{id}', 'Almacen\Comprobante\ComegresoController@updatearchivonotaseis')->name('updatearchivonotaseis');
   
   Route::get('aprovar/{id}', 'Almacen\Comprobante\ComegresoController@aprovar')->name('aprovar');
   Route::get('aprovarseis/{id}', 'Almacen\Comprobante\ComegresoController@aprovarseis')->name('aprovarseis');

   Route::get('aprovardos/{id}', 'Almacen\Comprobante\ComegresoController@aprovardos')->name('aprovardos');
  Route::get('solicitud/{id}', 'Almacen\Comprobante\ComegresoController@solicitud')->name('solicitud');
  Route::get('solicitudseis/{id}', 'Almacen\Comprobante\ComegresoController@solicitudseis')->name('solicitudseis');

  Route::POST('insertar', 'Almacen\Comprobante\ComegresoController@insertar')->name('insertar');
  Route::post('insertarcinco', 'Almacen\Comprobante\ComegresoController@insertarcinco')->name('insertarcinco');


   //    Route::get('docuconsumo', 'Almacen\Comprobante\ComegresoController@docuconsumo')->name('docuconsumo');



//    Route::get('editararchivo/{id}', 'Almacen\Ingreso\IngresoController@editararchivo')->name('editararchivo');
//    Route::POST('updatearchivonota/{id}', 'Almacen\Ingreso\IngresoController@updatearchivonota')->name('updatearchivonota');
//    Route::get('createdocuconsumo/{id}', 'Almacen\Ingreso\IngresoController@createdoc')->name('createdoc');
//    Route::POST('insertar', 'Almacen\Ingreso\IngresoController@insertar')->name('insertar');
//    Route::get('grafico', 'Almacen\Ingreso\IngresoController@grafico')->name('grafico');
//    Route::get('detalle/{id}', 'Almacen\Ingreso\IngresoController@detalle')->name('detalle');
//    Route::get('solicitud/{id}', 'Almacen\Ingreso\IngresoController@solicitud')->name('solicitud');
//    Route::get('reporte', 'Almacen\Ingreso\IngresoController@reporte')->name('reporte');
//    Route::post('store2', 'Almacen\Ingreso\IngresoController@store2')->name('store2');
//    Route::get('delete2/{id}', 'Almacen\Ingreso\IngresoController@delete')->name('delete');
//    Route::get('delete3/{id}', 'Almacen\Ingreso\IngresoController@deletedos')->name('deletedos');
 
});