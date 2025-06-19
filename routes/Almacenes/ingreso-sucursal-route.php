<?php
use Illuminate\Support\Facades\Route;

Route::prefix('ingreso-sucursal')->name('ingreso.sucursal.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Almacenes\IngresoSucursalController@index')->name('index')->middleware('can:ingreso.sucursal.index');
    Route::get('search', 'Almacenes\IngresoSucursalController@search')->name('search')->middleware('can:ingreso.sucursal.index');
    Route::get('create', 'Almacenes\IngresoSucursalController@create')->name('create')->middleware('can:ingreso.sucursal.create');
    Route::get('/get_partidas_presupuestarias', 'Almacenes\IngresoSucursalController@getPartidasPresupuestarias')->name('get.partidas.presupuestarias')->middleware('can:ingreso.sucursal.create');
    Route::get('/get_productos', 'Almacenes\IngresoSucursalController@getProductos')->name('get.productos')->middleware('can:ingreso.sucursal.create');
    Route::get('/get_producto_data', 'Almacenes\IngresoSucursalController@getProductoData')->name('get.producto.data')->middleware('can:ingreso.sucursal.create');
    Route::get('/get_nro_preventivo', 'Almacenes\IngresoSucursalController@getNroPreventivo')->name('get.nro_preventivo')->middleware('can:ingreso.sucursal.create');
    Route::get('/get_nro_preventivo_editar', 'Almacenes\IngresoSucursalController@getNroPreventivo')->name('get.nro_preventivo_editar')->middleware('can:ingreso.sucursal.editar');
    Route::get('/get_nro_orden_compra', 'Almacenes\IngresoSucursalController@getNroOrdenCompra')->name('get.nro_orden_compra')->middleware('can:ingreso.sucursal.create');
    Route::get('/get_nro_orden_compra_editar', 'Almacenes\IngresoSucursalController@getNroOrdenCompra')->name('get.nro_orden_compra_editar')->middleware('can:ingreso.sucursal.editar');
    Route::get('/get_codigo', 'Almacenes\IngresoSucursalController@getCodigo')->name('get.codigo')->middleware('can:ingreso.sucursal.create');
    Route::get('/get_codigo_editar', 'Almacenes\IngresoSucursalController@getCodigo')->name('get.codigo_editar')->middleware('can:ingreso.sucursal.editar');
    Route::post('store', 'Almacenes\IngresoSucursalController@store')->name('store')->middleware('can:ingreso.sucursal.create');
    Route::get('show/{ingreso_almacen_id}', 'Almacenes\IngresoSucursalController@show')->name('show')->middleware('can:ingreso.sucursal.show');
    Route::post('ingresar', 'Almacenes\IngresoSucursalController@ingresar')->name('ingresar')->middleware('can:ingreso.sucursal.ingresar');
    Route::get('pdf/{ingreso_almacen_id}', 'Almacenes\IngresoSucursalController@pdf')->name('pdf')->middleware('can:ingreso.sucursal.pdf');
    Route::get('editar/{ingreso_almacen_id}', 'Almacenes\IngresoSucursalController@editar')->name('editar')->middleware('can:ingreso.sucursal.editar');
    Route::get('eliminar_registro/{ingreso_almacen_detalle_id}', 'Almacenes\IngresoSucursalController@eliminarRegistro')->name('eliminar')->middleware('can:ingreso.sucursal.editar');
    Route::post('insertar-productos', 'Almacenes\IngresoSucursalController@insertarProducto')->name('insertar.producto')->middleware('can:ingreso.sucursal.editar');
    Route::post('update', 'Almacenes\IngresoSucursalController@update')->name('update')->middleware('can:ingreso.sucursal.editar');
});
