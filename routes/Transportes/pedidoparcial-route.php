<?php

Route::prefix('upedidoparcial')->name('upedidoparcial.')->middleware(['auth'])->group(function () { 
 
    Route::get('index', 'Transporte\SoluconsumoController2@index')->name('index');
    Route::get('index2', 'Transporte\SoluconsumoController2@index2')->name('index2');
    Route::get('index3', 'Transporte\SoluconsumoController2@index3')->name('index3');
    Route::get('create', 'Transporte\SoluconsumoController2@create')->name('create');
    Route::post('store', 'Transporte\SoluconsumoController2@store')->name('store');
    Route::get('editar/{id}', 'Transporte\SoluconsumoController2@editar')->name('editar');
    Route::get('editrechazado/{id}', 'Transporte\SoluconsumoController2@editrechazado')->name('editrechazado');
    Route::get('editaprobado/{id}', 'Transporte\SoluconsumoController2@editaprobado')->name('editaprobado');

    Route::POST('update', 'Transporte\SoluconsumoController2@update')->name('update');
    Route::GET('pdf', 'Transporte\SoluconsumoController2@pdf')->name('pdf');
    Route::get('solicitud/{id}', 'Transporte\SoluconsumoController2@solicitud')->name('solicitud');
    Route::get('solicituduno/{id}', 'Transporte\SoluconsumoController2@solicituduno')->name('solicituduno');

    Route::post('/ruta7', 'Transporte\SoluconsumoController2@respuesta7')->name('pregunta7');

    
 
});

