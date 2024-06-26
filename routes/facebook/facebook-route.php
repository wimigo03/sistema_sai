<?php

Route::prefix('facebook')->name('facebook.')->middleware(['auth'])->group(function () {
    Route::get('/', 'FacebookController@index')->name('index')->middleware('can:facebook.index');
    Route::get('search', 'FacebookController@search')->name('search')->middleware('can:facebook.index');
    Route::get('create/{dea_id}', 'FacebookController@create')->name('create')->middleware('can:facebook.create');
    Route::post('store', 'FacebookController@store')->name('store')->middleware('can:facebook.create');
    Route::get('cargar-datos/{id}', 'FacebookController@cargar_datos')->name('cargar.datos')->middleware('can:facebook.cargar.datos');
    Route::post('actualizar-datos', 'FacebookController@actualizar_datos')->name('actualizar.datos')->middleware('can:facebook.cargar.datos');
    Route::get('habilitar/{id}', 'FacebookController@habilitar')->name('habilitar')->middleware('can:facebook.cargar.datos');
    Route::get('deshabilitar/{id}', 'FacebookController@deshabilitar')->name('deshabilitar')->middleware('can:facebook.cargar.datos');
    Route::get('eliminar/{id}', 'FacebookController@eliminar')->name('eliminar')->middleware('can:facebook.cargar.datos');
    Route::get('excel/{id}', 'FacebookController@excel')->name('excel')->middleware('can:facebook.cargar.datos');
    Route::get('entre-fechas/{dea_id}', 'FacebookController@entre_fechas')->name('entre.fechas')->middleware('can:facebook.cargar.datos');
    Route::get('search-entre-fechas', 'FacebookController@search_entre_fechas')->name('search.entre.fechas')->middleware('can:facebook.cargar.datos');
    Route::get('excel-entre-fechas', 'FacebookController@excel_entre_fechas')->name('excel.entre.fechas')->middleware('can:facebook.cargar.datos');
});
