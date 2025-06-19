<?php
use Illuminate\Support\Facades\Route;

Route::prefix('balance-inicial')->name('balance.inicial.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Almacenes\BalanceInicialController@index')->name('index')->middleware('can:balance.inicial.index');
    Route::get('search', 'Almacenes\BalanceInicialController@search')->name('search')->middleware('can:balance.inicial.index');
    Route::get('create', 'Almacenes\BalanceInicialController@create')->name('create')->middleware('can:balance.inicial.create');
    Route::post('store', 'Almacenes\BalanceInicialController@store')->name('store')->middleware('can:balance.inicial.create');
    Route::get('show/{ingreso_almacen_id}', 'Almacenes\BalanceInicialController@show')->name('show')->middleware('can:balance.inicial.show');
    Route::get('pdf/{ingreso_almacen_id}', 'Almacenes\BalanceInicialController@pdf')->name('pdf')->middleware('can:balance.inicial.pdf');
    Route::get('editar/{ingreso_almacen_id}', 'Almacenes\BalanceInicialController@editar')->name('editar')->middleware('can:balance.inicial.editar');
    Route::post('insertar-productos', 'Almacenes\BalanceInicialController@insertarProducto')->name('insertar.producto')->middleware('can:balance.inicial.editar');
});
