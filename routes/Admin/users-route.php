<?php

Route::prefix('users')->name('users.')->middleware(['auth'])->group(function () { 
    Route::get('/index', 'Admin\UserController@index')->name('index');
    Route::get('/search', 'Admin\UserController@search')->name('search');
    Route::get('/excel', 'Admin\UserController@excel')->name('excel');
    Route::get('/create', 'Admin\UserController@create')->name('create');
    Route::post('/store', 'Admin\UserController@store')->name('store');
    Route::get('/edit/{id}', 'Admin\UserController@edit')->name('edit');
    Route::put('/update', 'Admin\UserController@update')->name('update');
    Route::get('/baja/{id}', 'Admin\UserController@baja')->name('baja');
    Route::get('/alta/{id}', 'Admin\UserController@alta')->name('alta');
});