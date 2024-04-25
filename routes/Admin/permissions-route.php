<?php

Route::prefix('permissions')->name('permissions.')->middleware(['auth'])->group(function () {
    Route::get('/index', 'Admin\PermissionController@index')->name('index')->middleware('can:permissions.index');
    Route::get('/search', 'Admin\PermissionController@search')->name('search')->middleware('can:permissions.index');
    Route::get('/show/{id}', 'Admin\PermissionController@show')->name('show')->middleware('can:permissions.show');
    Route::get('/create/{dea_id}', 'Admin\PermissionController@create')->name('create')->middleware('can:permissions.create');
    Route::post('/store', 'Admin\PermissionController@store')->name('store')->middleware('can:permissions.create');
    Route::get('/edit/{id}', 'Admin\PermissionController@edit')->name('edit')->middleware('can:permissions.edit');
    Route::post('/update', 'Admin\PermissionController@update')->name('update')->middleware('can:permissions.edit');
    Route::get('/deshabilitar/{id}', 'Admin\PermissionController@deshabilitar')->name('deshabilitar')->middleware('can:permissions.habilitar');
    Route::get('/habilitar/{id}', 'Admin\PermissionController@habilitar')->name('habilitar')->middleware('can:permissions.habilitar');
});
