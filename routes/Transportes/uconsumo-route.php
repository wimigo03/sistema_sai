

<?php 
Route::prefix('uconsumo')->name('uconsumo.')->middleware(['auth'])->group(function () { 

Route::get('index', 'Transporte\UnidaddConsumoController@index')->name('index');
Route::get('index2', 'Transporte\UnidaddConsumoController@index2')->name('index2');
Route::get('editar/{id}', 'Transporte\UnidaddConsumoController@editar')->name('editar');
Route::POST('update', 'Transporte\UnidaddConsumoController@update')->name('update');
Route::get('create', 'Transporte\UnidaddConsumoController@create')->name('create');
Route::POST('store', 'Transporte\UnidaddConsumoController@store')->name('store');
Route::get('editardoc/{id}', 'Transporte\UnidaddConsumoController@editardoc')->name('editdoc');
Route::get('createdocuconsumo/{id}', 'Transporte\UnidaddConsumoController@createdoc')->name('createdoc');
Route::POST('insertar', 'Transporte\UnidaddConsumoController@insertar')->name('insertar');
Route::get('aprovar/{id}', 'Transporte\UnidaddConsumoController@aprovar')->name('aprovar');
Route::post('/ruta9', 'Transporte\UnidaddConsumoController@respuesta9')->name('pregunta9');

});