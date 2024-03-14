<?php

  Route::prefix('users')->name('users.')->middleware(['auth'])->group(function () { 
     Route::get('/index', 'Admin\UserController@index')->name('index');
    
     Route::get('/search', 'Admin\UserController@search')->name('search');

      Route::get('/excel', 'Admin\UserController@excel')->name('excel');
      Route::get('/create', 'Admin\UserController@create')->name('create');
      Route::post('/store', 'Admin\UserController@store')->name('store');
      Route::get('/edit/{id}', 'Admin\UserController@edit')->name('edit');
      Route::post('/update', 'Admin\UserController@update')->name('update');
      Route::get('/baja/{id}', 'Admin\UserController@baja')->name('baja');
      Route::get('/alta/{id}', 'Admin\UserController@alta')->name('alta');
  });



//  Route::prefix('users')->name('users.')->middleware(['auth'])->group(function () { 
  
//       Route::get('/index', 'Admin\UserController@index')->name('index')->middleware('can:users.index');
//       Route::get('/search', 'Admin\UserController@search')->name('search')->middleware('can:users.index');
//      Route::get('/excel', 'Admin\UserController@excel')->name('excel')->middleware('can:users.excel');
//      Route::get('/create', 'Admin\UserController@create')->name('create')->middleware('can:users.create');
//      Route::post('/store', 'Admin\UserController@store')->name('store')->middleware('can:users.create');
//      Route::get('/edit/{id}', 'Admin\UserController@edit')->name('edit')->middleware('can:users.editar');
//      Route::post('/update', 'Admin\UserController@update')->name('update')->middleware('can:users.editar');
//      Route::get('/baja/{id}', 'Admin\UserController@baja')->name('baja')->middleware('can:users.deshabilitar');
//      Route::get('/alta/{id}', 'Admin\UserController@alta')->name('alta')->middleware('can:users.habilitar');
//  });
