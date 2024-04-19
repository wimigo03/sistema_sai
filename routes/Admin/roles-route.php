<?php

Route::prefix('roles')->name('roles.')->middleware(['auth'])->group(function () {
    Route::get('/index', 'Admin\RoleController@index')->name('index')->middleware('can:roles.index');
    Route::get('/search', 'Admin\RoleController@search')->name('search')->middleware('can:roles.index');
    Route::get('/show/{id}', 'Admin\RoleController@show')->name('show')->middleware('can:roles.show');
    Route::get('/create', 'Admin\RoleController@create')->name('create')->middleware('can:roles.create');
    Route::post('/store', 'Admin\RoleController@store')->name('store')->middleware('can:roles.create');
    Route::get('/edit/{id}', 'Admin\RoleController@edit')->name('edit')->middleware('can:roles.edit');
    Route::post('/update', 'Admin\RoleController@update')->name('update')->middleware('can:roles.edit');
    Route::get('/deshabilitar/{id}', 'Admin\RoleController@deshabilitar')->name('deshabilitar')->middleware('can:roles.habilitar');
    Route::get('/habilitar/{id}', 'Admin\RoleController@habilitar')->name('habilitar')->middleware('can:roles.habilitar');
});
