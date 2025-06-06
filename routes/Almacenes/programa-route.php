<?php
use Illuminate\Support\Facades\Route;

Route::prefix('programa')->name('programa.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Almacenes\ProgramaController@index')->name('index')->middleware('can:programa.index');
    Route::get('search', 'Almacenes\ProgramaController@search')->name('search')->middleware('can:programa.index');
    Route::get('create', 'Almacenes\ProgramaController@create')->name('create')->middleware('can:programa.create');
    Route::post('store', 'Almacenes\ProgramaController@store')->name('store')->middleware('can:programa.create');
    Route::get('habilitar/{categoria_programatica_id}', 'Almacenes\ProgramaController@habilitar')->name('habilitar')->middleware('can:programa.habilitar');
    Route::get('deshabilitar/{categoria_programatica_id}', 'Almacenes\ProgramaController@deshabilitar')->name('deshabilitar')->middleware('can:programa.habilitar');
    Route::get('editar/{categoria_programatica_id}', 'Almacenes\ProgramaController@editar')->name('editar')->middleware('can:programa.editar');
    Route::post('update', 'Almacenes\ProgramaController@update')->name('update')->middleware('can:programa.editar');
});
