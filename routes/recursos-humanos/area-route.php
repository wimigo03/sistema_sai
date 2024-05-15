<?php

Route::prefix('area')->name('area.')->middleware(['auth'])->group(function () {
    Route::get('/', 'AreaController@index')->name('index')->middleware('can:areas.index');
    Route::get('/get_datos/{idarea}', 'AreaController@get_datos')->name('get.datos.area')->middleware('can:areas.index');
    Route::get('create/{area_id}', 'AreaController@create')->name('create')->middleware('can:areas.create');
    Route::post('store', 'AreaController@store')->name('store')->middleware('can:empleados.areas');
    Route::get('editar/{area_id}', 'AreaController@editar')->name('editar')->middleware('can:areas.editar');
    Route::post('update', 'AreaController@update')->name('update')->middleware('can:areas.editar');
    Route::get('eliminar/{area_id}', 'AreaController@eliminar')->name('eliminar')->middleware('can:areas.eliminar');
});
