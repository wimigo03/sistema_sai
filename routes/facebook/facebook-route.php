<?php

Route::prefix('facebook')->name('facebook.')->middleware(['auth'])->group(function () {
    Route::get('/', 'FacebookController@index')->name('index')->middleware('can:facebook.index');
    Route::get('search', 'FacebookController@search')->name('search')->middleware('can:facebook.index');
    Route::get('create/{dea_id}', 'FacebookController@create')->name('create')->middleware('can:facebook.create');
    Route::post('store', 'FacebookController@store')->name('store')->middleware('can:facebook.create');
    Route::get('cargar-datos/{id}', 'FacebookController@cargar_datos')->name('cargar.datos')->middleware('can:facebook.cargar.datos');
    Route::post('actualizar-datos', 'FacebookController@actualizar_datos')->name('actualizar.datos')->middleware('can:facebook.cargar.datos');
    //Route::get('editar/{id}', 'FacebookController@editar')->name('editar');
    //Route::get('agregarEmpleados/{id}', 'FacebookController@agregarEmpleados')->name('agregarEmpleados');
    //Route::post('deshabilitar/{id}', 'FacebookController@deshabilitar')->name('deshabilitar');
});
