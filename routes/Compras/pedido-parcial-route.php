<?php

Route::prefix('compras/pedidoparcial')->name('compras.pedidoparcial.')->middleware(['auth'])->group(function () {
    Route::get('index', 'CompraController2@index')->name('index');
    Route::get('create', 'CompraController2@create')->name('create');
    Route::post('store', 'CompraController2@store')->name('store');
    Route::get('editar/{id}', 'CompraController2@editar')->name('editar');
    Route::post('update', 'CompraController2@update')->name('update');
    Route::get('edit/{id}', 'CompraController2@edit')->name('edit');
});