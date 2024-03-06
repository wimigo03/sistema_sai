<?php

Route::prefix('pedidoparcialcomb')->name('pedidoparcialcomb.')->middleware(['auth'])->group(function () { 

Route::get('index', 'Compra\CompraCombController2@index')->name('index');
Route::get('index2', 'Compra\CompraCombController2@index2')->name('index2');
Route::get('create', 'Compra\CompraCombController2@create')->name('create');
Route::post('store', 'Compra\CompraCombController2@store')->name('store');
Route::post('update', 'Compra\CompraCombController2@update')->name('update');
Route::get('editar/{id}', 'Compra\CompraCombController2@editar')->name('editar');
Route::get('editaruno/{id}', 'Compra\CompraCombController2@editaruno')->name('editaruno');

Route::get('editable/{id}', 'Compra\CompraCombController2@editable')->name('editable');
Route::get('edit/{id}', 'Compra\CompraCombController2@edit')->name('edit');
Route::post('/ruta4', 'Compra\CompraCombController2@respuesta4')->name('pregunta4');
Route::get('ver/{id}', 'Compra\CompraCombController2@ver')->name('ver');
Route::get('vercinco/{id}', 'Compra\CompraCombController2@vercinco')->name('vercinco');
Route::get('verdiez/{id}', 'Compra\CompraCombController2@verdiez')->name('verdiez');

Route::get('editrecha/{id}', 'Compra\CompraCombController2@editrecha')->name('editrecha');
Route::get('editalma/{id}', 'Compra\CompraCombController2@editalma')->name('editalma');


  
});