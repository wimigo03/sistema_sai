<?php

Route::prefix('categoria-programatica')->name('categoria.programatica.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Compras\CategoriaProgramaticaController@index')->name('index')->middleware('can:categoria.programatica.index');
    Route::get('search', 'Compras\CategoriaProgramaticaController@search')->name('search')->middleware('can:categoria.programatica.index');
    Route::get('create', 'Compras\CategoriaProgramaticaController@create')->name('create')->middleware('can:categoria.programatica.create');
    Route::post('store', 'Compras\CategoriaProgramaticaController@store')->name('store')->middleware('can:categoria.programatica.create');
    Route::get('habilitar/{categoria_programatica_id}', 'Compras\CategoriaProgramaticaController@habilitar')->name('habilitar')->middleware('can:categoria.programatica.habilitar');
    Route::get('deshabilitar/{categoria_programatica_id}', 'Compras\CategoriaProgramaticaController@deshabilitar')->name('deshabilitar')->middleware('can:categoria.programatica.habilitar');
    Route::get('editar/{categoria_programatica_id}', 'Compras\CategoriaProgramaticaController@editar')->name('editar')->middleware('can:categoria.programatica.editar');
    Route::post('update', 'Compras\CategoriaProgramaticaController@update')->name('update')->middleware('can:categoria.programatica.editar');
});
