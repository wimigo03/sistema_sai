<?php

Route::prefix('permissions')->name('permissions.')->middleware(['auth'])->group(function () {
    Route::get('/index', 'Admin\PermissionController@index')->name('index')->middleware('can:permissions.index');
    Route::get('/show/{id}', 'Admin\RoleController@show')->name('show')->middleware('can:permissions.show');
    Route::get('/search', 'Admin\RoleController@search')->name('search')->middleware('can:permissions.index');
    Route::get('/create', 'Admin\RoleController@create')->name('create')->middleware('can:permissions.create');
    Route::post('/store', 'Admin\RoleController@store')->name('store')->middleware('can:permissions.create');
    Route::get('/edit/{id}', 'Admin\RoleController@edit')->name('edit')->middleware('can:permissions.edit');
    Route::post('/update', 'Admin\RoleController@update')->name('update')->middleware('can:permissions.edit');
    Route::get('/deshabilitar/{id}', 'Admin\RoleController@deshabilitar')->name('deshabilitar')->middleware('can:permissions.habilitar');
    Route::get('/habilitar/{id}', 'Admin\RoleController@habilitar')->name('habilitar')->middleware('can:permissions.habilitar');
});
