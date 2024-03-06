<?php

Route::prefix('adetalle')->name('adetalle.')->middleware(['auth'])->group(function () { 
 

    Route::get('index', 'Almacen\DetalleValeController@index')->name('index');
  Route::get('index2', 'Almacen\DetalleValeController@index2')->name('index2');
  Route::get('index3', 'Almacen\DetalleValeController@index3')->name('index3');
  
  Route::post('store', 'Almacen\DetalleValeController@store')->name('store');
  Route::get('principal/{id}', 'Almacen\DetalleValeController@crearOrdenxxx')->name('principal');
  Route::post('principal/store', 'Almacen\DetalleValeController@crearOrden')->name('principal.store');
  //Route::post('combustibles/detalle/principalorden', 'Almacen\DetalleValeController@crearOrdendoc')->name('DetalleValeController.crearOrdendoc');
  //Route::get('combustibles/detalle/{id}/destroyed2', 'Almacen\DetalleValeController@destroyed2')->name('DetalleValeController.eliminar2');
  Route::get('aprovar/{id}', 'Almacen\DetalleValeController@aprovar')->name('aprovar');
  Route::get('solicitud/{id}', 'Almacen\DetalleValeController@solicitud')->name('solicitud');
  
  Route::get('delete/{id}', 'Almacen\DetalleValeController@delete')->name('delete');
  Route::get('editar/{id}', 'Almacen\DetalleValeController@editar')->name('editar');
  
  Route::POST('update', 'Almacen\DetalleValeController@update')->name('update');
  
});