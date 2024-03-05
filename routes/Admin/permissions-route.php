<?php

Route::prefix('permissions')->name('permissions.')->middleware(['auth'])->group(function () {
    Route::get('/index', 'Admin\PermissionController@index')->name('index');
    Route::get('/show/{id}', 'Admin\RoleController@show')->name('show');
    Route::get('/search', 'Admin\RoleController@search')->name('search');
    Route::get('/create', 'Admin\RoleController@create')->name('create');
    Route::post('/store', 'Admin\RoleController@store')->name('store');
    Route::get('/edit/{id}', 'Admin\RoleController@edit')->name('edit');
    Route::post('/update', 'Admin\RoleController@update')->name('update');
    Route::get('/deshabilitar/{id}', 'Admin\RoleController@deshabilitar')->name('deshabilitar');
    Route::get('/habilitar/{id}', 'Admin\RoleController@habilitar')->name('habilitar');
});
