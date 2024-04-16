<?php

Route::prefix('item')->name('item.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Compras\ItemController@index')->name('index')->middleware('can:item.index');
    Route::get('search', 'Compras\ItemController@search')->name('search')->middleware('can:item.index');
    Route::get('create/{dea_id}', 'Compras\ItemController@create')->name('create')->middleware('can:item.create');
    Route::post('store', 'Compras\ItemController@store')->name('store')->middleware('can:item.create');
    Route::get('habilitar/{item_id}', 'Compras\ItemController@habilitar')->name('habilitar')->middleware('can:item.habilitar');
    Route::get('deshabilitar/{item_id}', 'Compras\ItemController@deshabilitar')->name('deshabilitar')->middleware('can:item.habilitar');
    Route::get('editar/{item_id}', 'Compras\ItemController@editar')->name('editar')->middleware('can:item.editar');
    Route::post('update', 'Compras\ItemController@update')->name('update')->middleware('can:item.editar');
});
