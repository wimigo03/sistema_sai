<?php

Route::prefix('barrios')->name('barrios.')->middleware(['auth'])->group(function () { 
    Route::get('/', 'Canasta_v2\BarriosV2Controller@index')->name('index');
});