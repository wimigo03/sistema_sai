<?php

Route::prefix('proveedor')->name('proveedor.')->middleware(['auth'])->group(function () { 
 

    Route::get('index', 'Compra\ProveedorController@index')->name('index');
    Route::get('create', 'Compra\ProveedorController@create')->name('create');
    Route::post('store', 'Compra\ProveedorController@store')->name('store');
    Route::get('list', 'Compra\ProveedorController@list')->name('list');
    Route::get('edit/{id}', 'Compra\ProveedorController@editar')->name('edit');
    Route::POST('update/{id}', 'Compra\ProveedorController@update')->name('update');
    Route::get('editardoc/{id}', 'Compra\ProveedorController@editardoc')->name('editardoc');

    Route::get('createdocproveedor/{id}', 'Compra\ProveedorController@createdoc')->name('createdoc');
    Route::POST('insertar', 'Compra\ProveedorController@insertar')->name('insertar');
    Route::get('editararchivo/{id}', 'Compra\ProveedorController@editararchivo')->name('editararchivo');
    Route::POST('updatearchivoproveedor/{id}', 'Compra\ProveedorController@updatearchivoproveedor')->name('updatearchivoproveedor');
    Route::post('/ruta2', 'Compra\ProveedorController@respuesta2')->name('pregunta2');

 
});