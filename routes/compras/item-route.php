<?php

Route::prefix('materiales')->name('item.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Compras\ItemController@index')->name('index')->middleware('can:item.index');
    Route::get('search', 'Compras\ItemController@search')->name('search')->middleware('can:item.index');
    Route::get('create', 'Compras\ItemController@create')->name('create')->middleware('can:item.create');
    Route::get('/get_partidas_presupuestarias', 'Compras\ItemController@getPartidasPresupuestarias')->name('get.partidas.presupuestarias')->middleware('can:item.create');
    Route::post('store', 'Compras\ItemController@store')->name('store')->middleware('can:item.create');
    Route::get('editar/{item_id}', 'Compras\ItemController@editar')->name('editar')->middleware('can:item.editar');
    Route::post('update', 'Compras\ItemController@update')->name('update')->middleware('can:item.editar');
    Route::get('habilitar/{item_id}', 'Compras\ItemController@habilitar')->name('habilitar')->middleware('can:item.habilitar');
    Route::get('inhabilitar/{item_id}', 'Compras\ItemController@inhabilitar')->name('inhabilitar')->middleware('can:item.habilitar');
});
