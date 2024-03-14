<?php

Route::prefix('pedidocomb')->name('pedidocomb.')->middleware(['auth'])->group(function () { 


 
    Route::get('create', 'Compra\CompraCombController@create')->name('create');
    Route::post('store', 'Compra\CompraCombController@store')->name('store');
    
    Route::get('index', 'Compra\CompraCombController@index')->name('index')->middleware('can:pedidocomb.index');

    Route::get('edit/{id}', 'Compra\CompraCombController@edit')->name('edit')->middleware('can:pedidocomb.edit');
    Route::get('editabledos/{id}', 'Compra\CompraCombController@editabledos')->name('editabledos')->middleware('can:pedidocomb.editabledos');
    Route::get('editabletres/{id}', 'Compra\CompraCombController@editabletres')->name('editabletres')->middleware('can:pedidocomb.editabletres');


    Route::get('editar/{id}', 'Compra\CompraCombController@editar')->name('editar');
    Route::get('ver/{id}', 'Compra\CompraCombController@ver')->name('ver')->middleware('can:pedidocomb.ver');
    Route::get('verdos/{id}', 'Compra\CompraCombController@verdos')->name('verdos');
    Route::get('veruno/{id}', 'Compra\CompraCombController@veruno')->name('veruno');


    Route::post('update', 'Compra\CompraCombController@update')->name('update');

    Route::get('index2', 'Compra\CompraCombController@index2')->name('index2')->middleware('can:pedidocomb.index2');
    Route::get('editable/{id}', 'Compra\CompraCombController@editable')->name('editable')->middleware('can:pedidocomb.editable');

    Route::get('verr/{id}', 'Compra\CompraCombController@verr')->name('verr')->middleware('can:pedidocomb.verr');
    Route::get('vertres/{id}', 'Compra\CompraCombController@vertres')->name('vertres');
    Route::get('vercinco/{id}', 'Compra\CompraCombController@vercinco')->name('vercinco');

    Route::get('editablecuatro/{id}', 'Compra\CompraCombController@editablecuatro')->name('editablecuatro');
    
    // Route::get('combustibles/pedido/ver/{id}', 'Compra\CompraCombController@ver')->name('ver');

    Route::post('/ruta5', 'Compra\CompraCombController@respuesta5')->name('pregunta5');
    Route::post('/ruta6', 'Compra\CompraCombController@respuesta6')->name('pregunta6');
 



  
});