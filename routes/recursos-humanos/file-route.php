<?php

Route::prefix('file')->name('file.')->middleware(['auth'])->group(function () {
    Route::get('/', 'FileController@index')->name('index')->middleware('can:files.index');
    Route::get('search', 'FileController@search')->name('search')->middleware('can:files.index');
    Route::get('create/{dea_id}', 'FileController@create')->name('create')->middleware('can:files.create');
    Route::post('store', 'FileController@store')->name('store')->middleware('can:files.create');
    Route::get('editar/{file_id}', 'FileController@editar')->name('editar')->middleware('can:files.editar');
    Route::post('update', 'FileController@update')->name('update')->middleware('can:files.editar');
    Route::get('excel', 'FileController@excel')->name('excel')->middleware('can:files.excel');
});
