<?php

Route::prefix('reportes-canasta')->name('reportes.canasta.')->middleware(['auth'])->group(function () {
    Route::get('index', 'Canasta_v2\ReportesController@index')->name('index')->middleware('can:reportes.canasta.index');
    Route::get('beneficiarios-entre-fechas', 'Canasta_v2\ReportesController@BeneficiariosEntreFechas')->name('beneficiarios.entre.fechas')->middleware('can:reportes.canasta.index');
    Route::get('exportar-beneficiarios-entre-fechas', 'Canasta_v2\ReportesController@ExportarBeneficiariosEntreFechas')->name('exportar.beneficiarios.entre.fechas')->middleware('can:reportes.canasta.index');
});
