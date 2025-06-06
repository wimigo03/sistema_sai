<?php
use Illuminate\Support\Facades\Route;

Route::prefix('categoria-programatica')->name('categoria.programatica.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Almacenes\CategoriaProgramaticaController@index')->name('index')->middleware('can:categoria.programatica.index');
    Route::get('search', 'Almacenes\CategoriaProgramaticaController@search')->name('search')->middleware('can:categoria.programatica.index');
    Route::get('create', 'Almacenes\CategoriaProgramaticaController@create')->name('create')->middleware('can:categoria.programatica.create');
    Route::post('store', 'Almacenes\CategoriaProgramaticaController@store')->name('store')->middleware('can:categoria.programatica.create');
    Route::get('habilitar/{categoria_programatica_id}', 'Almacenes\CategoriaProgramaticaController@habilitar')->name('habilitar')->middleware('can:categoria.programatica.habilitar');
    Route::get('deshabilitar/{categoria_programatica_id}', 'Almacenes\CategoriaProgramaticaController@deshabilitar')->name('deshabilitar')->middleware('can:categoria.programatica.habilitar');
    Route::get('editar/{categoria_programatica_id}', 'Almacenes\CategoriaProgramaticaController@editar')->name('editar')->middleware('can:categoria.programatica.editar');
    Route::post('update', 'Almacenes\CategoriaProgramaticaController@update')->name('update')->middleware('can:categoria.programatica.editar');
    Route::get('show/{categoria_programatica_id}', 'Almacenes\CategoriaProgramaticaController@show')->name('show')->middleware('can:categoria.programatica.create');
    Route::post('show-procesar', 'Almacenes\CategoriaProgramaticaController@show_procesar')->name('show.procesar')->middleware('can:categoria.programatica.create');
    Route::get('show-habilitar/{categoria_presupuestaria_id}', 'Almacenes\CategoriaProgramaticaController@show_habilitar')->name('show.habilitar')->middleware('can:categoria.programatica.create');
    Route::get('show-deshabilitar/{categoria_presupuestaria_id}', 'Almacenes\CategoriaProgramaticaController@show_deshabilitar')->name('show.deshabilitar')->middleware('can:categoria.programatica.create');
});
