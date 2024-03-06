<?php

Route::prefix('ingreso')->name('ingreso.')->middleware(['auth'])->group(function () { 
 

    Route::get('index', 'Almacen\Ingreso\IngresoController@index')->name('index');
   Route::get('editardoc/{id}', 'Almacen\Ingreso\IngresoController@editardoc')->name('editardoc');
   Route::get('editararchivo/{id}', 'Almacen\Ingreso\IngresoController@editararchivo')->name('editararchivo');
   Route::POST('updatearchivonota/{id}', 'Almacen\Ingreso\IngresoController@updatearchivonota')->name('updatearchivonota');
   Route::get('createdocuconsumo/{id}', 'Almacen\Ingreso\IngresoController@createdoc')->name('createdoc');
   Route::POST('insertar', 'Almacen\Ingreso\IngresoController@insertar')->name('insertar');
   Route::get('grafico', 'Almacen\Ingreso\IngresoController@grafico')->name('grafico');
   Route::get('detalle/{id}', 'Almacen\Ingreso\IngresoController@detalle')->name('detalle');
   Route::get('solicitud/{id}', 'Almacen\Ingreso\IngresoController@solicitud')->name('solicitud');
   Route::get('reporte', 'Almacen\Ingreso\IngresoController@reporte')->name('reporte');
   Route::post('store2', 'Almacen\Ingreso\IngresoController@store2')->name('store2');
   Route::get('delete2/{id}', 'Almacen\Ingreso\IngresoController@delete')->name('delete');
   Route::get('delete3/{id}', 'Almacen\Ingreso\IngresoController@deletedos')->name('deletedos');
 
});