<?php

Route::prefix('empleado')->name('empleado.')->middleware(['auth'])->group(function () {
    Route::get('/', 'EmpleadoController@index')->name('index')->middleware('can:empleados.index');
    Route::get('search', 'EmpleadoController@search')->name('search')->middleware('can:empleados.index');
    Route::get('create/{dea_id}', 'EmpleadoController@create')->name('create')->middleware('can:empleados.create');
    Route::post('store', 'EmpleadoController@store')->name('store')->middleware('can:empleados.create');
    Route::get('editar/{idemp}', 'EmpleadoController@editar')->name('editar')->middleware('can:empleados.editar');
    Route::post('update', 'EmpleadoController@update')->name('update')->middleware('can:empleados.editar');
    Route::get('retirar/{idemp}', 'EmpleadoController@retirar')->name('retirar')->middleware('can:empleados.retirar');
    Route::post('procesar-retiro', 'EmpleadoController@procesar_retiro')->name('procesar.retiro')->middleware('can:empleados.retirar');
    Route::get('recontratar/{idemp}', 'EmpleadoController@recontratar')->name('recontratar')->middleware('can:empleados.recontratar');
    Route::post('procesar-recontrato', 'EmpleadoController@procesar_recontrato')->name('procesar.recontrato')->middleware('can:empleados.recontratar');
    Route::get('show/{idemp}', 'EmpleadoController@show')->name('show')->middleware('can:empleados.show');
    Route::get('pdf-show/{idemp}', 'EmpleadoController@pdf_show')->name('pdf.show')->middleware('can:empleados.show');
    Route::get('imprimir-credenciales/{dea_id}', 'EmpleadoController@imprimir_credenciales')->name('imprimir.credenciales')->middleware('can:empleados.show');
    Route::get('procesar-credenciales', 'EmpleadoController@procesar_credenciales')->name('procesar.credenciales')->middleware('can:empleados.show');
    Route::get('excel', 'EmpleadoController@excel')->name('excel')->middleware('can:empleados.index');
});
