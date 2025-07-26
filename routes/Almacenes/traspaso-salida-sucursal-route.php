<?php
use Illuminate\Support\Facades\Route;

Route::prefix('traspaso-salida-sucursal')->name('traspaso.salida.sucursal.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Almacenes\TraspasoSalidaSucursalController@index')->name('index')->middleware('can:traspaso.sucursal.index');
    Route::get('search', 'Almacenes\TraspasoSalidaSucursalController@search')->name('search')->middleware('can:traspaso.sucursal.index');
    Route::get('create', 'Almacenes\TraspasoSalidaSucursalController@create')->name('create')->middleware('can:traspaso.sucursal.create');
    Route::get('/get_ingresos_materiales', 'Almacenes\TraspasoSalidaSucursalController@getIngresoMateriales')->name('get.ingreso.material')->middleware('can:traspaso.sucursal.create');
    Route::post('store', 'Almacenes\TraspasoSalidaSucursalController@store')->name('store')->middleware('can:traspaso.sucursal.create');
    Route::get('show/{id}', 'Almacenes\TraspasoSalidaSucursalController@show')->name('show')->middleware('can:traspaso.sucursal.show');
    Route::get('pdf/{id}', 'Almacenes\TraspasoSalidaSucursalController@pdf')->name('pdf')->middleware('can:traspaso.sucursal.pdf');
    Route::post('aprobar', 'Almacenes\TraspasoSalidaSucursalController@aprobar')->name('aprobar')->middleware('can:traspaso.sucursal.aprobar');
    Route::get('rechazar/{id}', 'Almacenes\TraspasoSalidaSucursalController@rechazar')->name('rechazar')->middleware('can:traspaso.sucursal.aprobar');
});
