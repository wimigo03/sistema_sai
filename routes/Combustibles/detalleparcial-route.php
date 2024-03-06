<?php

Route::prefix('detalleparcial')->name('detalleparcial.')->middleware(['auth'])->group(function () { 

Route::get('index', 'Compra\DetalleCompraCombController2@index')->name('index');
Route::get('index2', 'Compra\DetalleCompraCombController2@index2')->name('index2');
Route::get('index3', 'Compra\DetalleCompraCombController2@index3')->name('index3');
Route::get('index4', 'Compra\DetalleCompraCombController2@index4')->name('index4');
Route::post('store', 'Compra\DetalleCompraCombController2@store')->name('store');
Route::get('show/{id}', 'Compra\DetalleCompraCombController2@show')->name('show');
Route::get('destroyed2/{id}', 'Compra\DetalleCompraCombController2@destroyed2')->name('DetalleCompraController2.eliminar2');
Route::get('delete2/{id}', 'Compra\DetalleCompraCombController2@delete')->name('delete');

});