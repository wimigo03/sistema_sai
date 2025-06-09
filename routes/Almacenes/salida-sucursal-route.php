<?php
use Illuminate\Support\Facades\Route;

Route::prefix('salida-sucursal')->name('salida.sucursal.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Almacenes\SalidaSucursalController@index')->name('index')->middleware('can:salida.sucursal.index');
    Route::get('search', 'Almacenes\SalidaSucursalController@search')->name('search')->middleware('can:salida.sucursal.index');
    Route::get('create', 'Almacenes\SalidaSucursalController@create')->name('create')->middleware('can:salida.sucursal.create');
    Route::get('/get_partidas_presupuestarias', 'Almacenes\SalidaSucursalController@getPartidasPresupuestarias')->name('get.partidas.presupuestarias')->middleware('can:salida.sucursal.create');
    Route::get('/get_productos', 'Almacenes\SalidaSucursalController@getProductos')->name('get.productos')->middleware('can:salida.sucursal.create');
    Route::get('/get_producto_data', 'Almacenes\SalidaSucursalController@getProductoData')->name('get.producto.data')->middleware('can:salida.sucursal.create');
    Route::get('/get_codigo', 'Almacenes\SalidaSucursalController@getCodigo')->name('get.codigo')->middleware('can:salida.sucursal.create');
    Route::get('/get_codigo_editar', 'Almacenes\SalidaSucursalController@getCodigo')->name('get.codigo_editar')->middleware('can:salida.sucursal.editar');
    Route::get('/get_stock_disponible', 'Almacenes\SalidaSucursalController@getStockDisponible')->name('get.stock.disponible')->middleware('can:salida.sucursal.create');
    Route::get('/get_stock_disponible_valido', 'Almacenes\SalidaSucursalController@getStockDisponibleValido')->name('get.stock.disponible.valido')->middleware('can:salida.sucursal.create');
    Route::post('store', 'Almacenes\SalidaSucursalController@store')->name('store')->middleware('can:salida.sucursal.create');
    Route::get('show/{salida_almacen_id}', 'Almacenes\SalidaSucursalController@show')->name('show')->middleware('can:salida.sucursal.show');
    Route::post('egresar', 'Almacenes\SalidaSucursalController@egresar')->name('egresar')->middleware('can:salida.sucursal.egresar');
    Route::get('pdf/{salida_almacen_id}', 'Almacenes\SalidaSucursalController@pdf')->name('pdf')->middleware('can:salida.sucursal.pdf');
    Route::get('editar/{salida_almacen_id}', 'Almacenes\SalidaSucursalController@editar')->name('editar')->middleware('can:salida.sucursal.editar');
    Route::get('eliminar_registro/{ingreso_almacen_detalle_id}', 'Almacenes\SalidaSucursalController@eliminarRegistro')->name('eliminar')->middleware('can:salida.sucursal.editar');
    Route::post('update', 'Almacenes\SalidaSucursalController@update')->name('update')->middleware('can:salida.sucursal.editar');
});
