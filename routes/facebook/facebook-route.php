<?php

Route::prefix('facebook')->name('facebook.')->middleware(['auth'])->group(function () {
    Route::get('/', 'FacebookController@index')->name('index');
    Route::get('search/{id}', 'FacebookController@search')->name('search');
    //Route::get('excel', 'Canasta_v2\BarriosV2Controller@excel')->name('excel');
    Route::get('create', 'FacebookController@create')->name('create');
    //Route::post('store', 'Canasta_v2\BarriosV2Controller@store')->name('store');
    Route::get('editar/{id}', 'FacebookController@editar')->name('editar');
    Route::get('agregarEmpleados/{id}', 'FacebookController@agregarEmpleados')->name('agregarEmpleados');
   //Route::post('update', 'Canasta_v2\BarriosV2Controller@update')->name('update');
   //Route::get('habilitar/{id}', 'Canasta_v2\BarriosV2Controller@habilitar')->name('habilitar');
    Route::post('deshabilitar/{id}', 'FacebookController@deshabilitar')->name('deshabilitar');
});
