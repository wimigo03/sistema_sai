<?php
use Illuminate\Support\Facades\Route;

Route::prefix('recintos')->name('recintos.')->middleware(['auth'])->group(function () {
    Route::get('/','RecintoController@index')->name('index')->middleware('can:recintos.index');
    Route::post('/store','RecintoController@store')->name('store')->middleware('can:recintos.index');
    Route::get('show-mesas-electorales/{recinto_id}','RecintoController@showMesasElectorales')->name('show.mesas.electorales')->middleware('can:recintos.index');
    Route::get('show-detalle-mesas-electorales/{mesa_id}','RecintoController@showDetalleMesasElectorales')->name('show.detalle.mesas.electorales')->middleware('can:recintos.index');
    Route::post('update-registro-cantidad', 'RecintoController@updateRegistroCantidad')->name('update.registro.cantidad')->middleware('can:recintos.index');

    Route::get('deshabilitar/{recinto_id}','RecintoController@deshabilitarRecinto')->name('deshabilitar')->middleware('can:recintos.index');
    Route::get('habilitar/{recinto_id}','RecintoController@habilitarRecinto')->name('habilitar')->middleware('can:recintos.index');

    Route::get('mesas-deshabilitar/{mesa_id}','RecintoController@deshabilitarMesa')->name('mesas.deshabilitar')->middleware('can:recintos.index');
    Route::get('mesas-habilitar/{mesa_id}','RecintoController@habilitarMesa')->name('mesas.habilitar')->middleware('can:recintos.index');

    Route::get('mesas-detalle-deshabilitar/{mesa_detalle_id}','RecintoController@deshabilitarMesaDetalle')->name('mesas.detalle.deshabilitar')->middleware('can:recintos.index');
    Route::get('mesas-detalle-habilitar/{mesa_detalle_id}','RecintoController@habilitarMesaDetalle')->name('mesas.detalle.habilitar')->middleware('can:recintos.index');
});
