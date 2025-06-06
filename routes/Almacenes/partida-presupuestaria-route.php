<?php
use Illuminate\Support\Facades\Route;

Route::prefix('partida-presupuestaria')->name('partida.presupuestaria.')->middleware(['auth'])->group(function () {
    Route::get('/', 'Almacenes\PartidaPresupuestariaController@index')->name('index')->middleware('can:partida.presupuestaria.index');
    Route::get('/get_datos', 'Almacenes\PartidaPresupuestariaController@getDatos')->name('get.datos')->middleware('can:partida.presupuestaria.index');
    Route::get('search', 'Almacenes\PartidaPresupuestariaController@search')->name('search')->middleware('can:partida.presupuestaria.index');
    Route::get('excel', 'Almacenes\PartidaPresupuestariaController@excel')->name('excel')->middleware('can:partida.presupuestaria.index');
    Route::get('create', 'Almacenes\PartidaPresupuestariaController@create')->name('create')->middleware('can:partida.presupuestaria.create');
    Route::post('store', 'Almacenes\PartidaPresupuestariaController@store')->name('store')->middleware('can:partida.presupuestaria.create');
    Route::get('editar', 'Almacenes\PartidaPresupuestariaController@editar')->name('editar')->middleware('can:partida.presupuestaria.editar');
    Route::post('update', 'Almacenes\PartidaPresupuestariaController@update')->name('update')->middleware('can:partida.presupuestaria.editar');
});
