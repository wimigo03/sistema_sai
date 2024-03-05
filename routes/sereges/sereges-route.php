<?php

Route::prefix('sereges')->name('sereges.')->middleware(['auth'])->group(function () {
    ///// ALBERGUE ////
    Route::get('/albergue_index', 'sereges\SeregesController@index')->name('albergue_index');
    Route::post('/update/{id}', 'sereges\SeregesController@update')->name('albergue_update');
    Route::post('/create', 'sereges\SeregesController@create')->name('albergue_create');
    ///// REGISTRO ///
    Route::get('/registro_index', 'sereges\SeregesController@registro_index')->name('registro_index');
    Route::get('/registro_index2', 'sereges\SeregesController@registro_index')->name('registro_index');
    Route::post('/registro_create', 'sereges\SeregesController@createRegistro')->name('registro_create');
    Route::post('/registro_update/{id}', 'sereges\SeregesController@updateRegistro')->name('registro_update');
    //////FOTOS/////////
    Route::get('/foto_index/{id}', 'sereges\SeregesController@foto_index')->name('foto_index');
    Route::post('/insertarFoto/{id}', 'sereges\SeregesController@insertarFoto')->name('registro_insertarFoto');

     //////INGRESO/////////
     Route::get('/ingreso_index/{id}', 'sereges\SeregesController@ingreso_index')->name('ingreso_index');
    Route::post('/insertarpdfingreso/{id}', 'sereges\SeregesController@insertarpdfingreso')->name('ingreso_insertarpdf');
});
