<?php

Route::prefix('informatica')->name('informatica.')->middleware(['auth'])->group(function () {

    ///// REGISTRO ///
    Route::get('/registro_index', 'informatica\InformaticaController@index')->name('registro_index');
    //Route::get('/registro_index2', 'sereges\SeregesController@registro_index')->name('registro_index');
    //Route::post('/registro_create', 'sereges\SeregesController@createRegistro')->name('registro_create');
    //Route::post('/registro_update/{id}', 'sereges\SeregesController@updateRegistro')->name('registro_update');
    //////FOTOS/////////
   // Route::get('/foto_index/{id}', 'sereges\SeregesController@foto_index')->name('foto_index');
    //Route::post('/insertarFoto/{id}', 'sereges\SeregesController@insertarFoto')->name('registro_insertarFoto');

     //////INGRESO/////////
     //Route::get('/ingreso_index/{id}', 'sereges\SeregesController@ingreso_index')->name('ingreso_index');
    //Route::post('/insertarpdfingreso/{id}', 'sereges\SeregesController@insertarpdfingreso')->name('ingreso_insertarpdf');
});
