<?php

Route::prefix('pedidocomb')->name('pedidocomb.')->middleware(['auth'])->group(function () { 


    Route::get('index', 'Compra\CompraCombController@index')->name('index');
    Route::get('index2', 'Compra\CompraCombController@index2')->name('index2');
    Route::get('create', 'Compra\CompraCombController@create')->name('create');
    Route::post('store', 'Compra\CompraCombController@store')->name('store');
    Route::get('edit/{id}', 'Compra\CompraCombController@edit')->name('edit');
    Route::get('editar/{id}', 'Compra\CompraCombController@editar')->name('editar');
    Route::post('update', 'Compra\CompraCombController@update')->name('update');
    Route::get('editable/{id}', 'Compra\CompraCombController@editable')->name('editable');
    Route::get('editabledos/{id}', 'Compra\CompraCombController@editabledos')->name('editabledos');
    Route::get('editabletres/{id}', 'Compra\CompraCombController@editabletres')->name('editabletres');
    Route::get('editablecuatro/{id}', 'Compra\CompraCombController@editablecuatro')->name('editablecuatro');
    Route::get('combustibles/pedido/ver/{id}', 'CompraCombController@ver')->name('ver');
    Route::post('/ruta5', 'Compra\CompraCombController@respuesta5')->name('pregunta5');
    Route::post('/ruta6', 'Compra\CompraCombController@respuesta6')->name('pregunta6');
    Route::get('ver/{id}', 'Compra\CompraCombController@ver')->name('ver');
    Route::get('verr/{id}', 'Compra\CompraCombController@verr')->name('verr');

    Route::get('veruno/{id}', 'Compra\CompraCombController@veruno')->name('veruno');
    Route::get('verdos/{id}', 'Compra\CompraCombController@verdos')->name('verdos');
    Route::get('vertres/{id}', 'Compra\CompraCombController@vertres')->name('vertres');
    Route::get('vercinco/{id}', 'Compra\CompraCombController@vercinco')->name('vercinco');



  
});