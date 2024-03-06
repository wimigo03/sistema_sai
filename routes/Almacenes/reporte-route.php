<?php

Route::prefix('reporte')->name('reporte.')->middleware(['auth'])->group(function () { 
 

    Route::get('index', 'Almacen\Ingreso\ReporteAreasController@index')->name('index');
   Route::post('store', 'Almacen\Ingreso\ReporteAreasController@store')->name('store');
   Route::get('solicitud/{id}', 'Almacen\Ingreso\ReporteAreasController@solicitud')->name('solicitud');
   Route::get('index2', 'Almacen\Ingreso\ReporteAreasController@index2')->name('index2');
   Route::post('store2', 'Almacen\Ingreso\ReporteAreasController@store2')->name('store2');
   Route::get('solicituddos/{id}', 'Almacen\Ingreso\ReporteAreasController@solicituddos')->name('solicituddos');
  
 
});