<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*use App\Http\Controllers\MedidaController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\PrartidaController;
use App\Http\Controllers\ProdServController;
use App\Http\Controllers\PlantaController;
use App\Http\Controllers\DetalleCompraController;*/

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return view('/auth/login');
});

Auth::routes();



Route::group(['prefix' => "admin", 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth', 'AdminPanelAccess']], function () {

    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('/users', 'UserController');
    Route::resource('/roles', 'RoleController');
    Route::resource('/permissions', 'PermissionController')->except(['show']);
});


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('compras/medidas/index', 'MedidaController@index')->name('medidas.index')->middleware('can:medidas_access');
    Route::get('compras/medidas/list', 'MedidaController@listado')->name('medidas.list');
    Route::get('compras/medidas/{id}/edit', 'MedidaController@editar')->name('medidas.edit');
    Route::post('compras/medidas/{id}/update', 'MedidaController@update')->name('medidas.update');
    Route::get('compras/medidas/create', 'MedidaController@create')->name('medidas.create');
    Route::post('compras/medidas/store', 'MedidaController@store')->name('medidas.store');


    Route::get('admin/users/baja/{id}', 'Admin\UserController@baja')->name('users.baja');
    Route::get('admin/users/alta/{id}', 'Admin\UserController@alta')->name('users.alta');
    Route::get('admin/users//index', 'Admin\UserController@index')->name('users.index');


    /////////////////////////--COMPRAS PEDIDO--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('compras/pedido/index', 'CompraController@index')->name('compras.pedido.index');
    Route::get('compras/pedido/index2', 'CompraController@index2')->name('compras.pedido.index2');
    Route::get('compras/pedido/create', 'CompraController@create')->name('compras.pedido.create');
    Route::post('compras/pedido/store', 'CompraController@store')->name('compras.pedido.store');
    Route::get('compras/pedido/edit/{id}', 'CompraController@edit')->name('compras.pedido.edit');
    Route::get('compras/pedido/editar/{id}', 'CompraController@editar')->name('compras.pedido.editar');
    Route::post('compras/pedido/update', 'CompraController@update')->name('compras.pedido.update');
    Route::get('compras/enviar/{id}', 'CompraController@enviar')->name('compras.pedido.enviar');

    /////////////////////////--COMPRAS PEDIDO PARCIAL--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    Route::get('compras/pedidoparcial/index', 'CompraController2@index')->name('compras.pedidoparcial.index');
    Route::get('compras/pedidoparcial/create', 'CompraController2@create')->name('compras.pedidoparcial.create');
    Route::post('compras/pedidoparcial/store', 'CompraController2@store')->name('compras.pedidoparcial.store');
    Route::get('compras/pedidoparcial/editar/{id}', 'CompraController2@editar')->name('compras.pedidoparcial.editar');
    Route::post('compras/pedidoparcial/update', 'CompraController2@update')->name('compras.pedidoparcial.update');
    Route::get('compras/pedidoparcial/edit/{id}', 'CompraController2@edit')->name('compras.pedidoparcial.edit');

    ///////////////////////////////--COMPRAS DETALLE--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('compras/detalle/index', 'DetalleCompraController@index')->name('compras.detalle.index');
    Route::post('compras/detalle/store', 'DetalleCompraController@store')->name('compras.detalle.store');
    Route::get('compras/detalle/principal/{id}', 'DetalleCompraController@crearOrdenxxx')->name('compras.detalle.principal');
    Route::post('compras/detalle/principal/store', 'DetalleCompraController@crearOrden')->name('compras.detalle.principal.store');
    Route::get('compras/detalle/{id}/principalorden', 'DetalleCompraController@crearOrdendocxx')->name('compras.detalle.principalorden');
    Route::get('compras/detalle/show', 'DetalleCompraController@show')->name('compras.detalle.show');
    Route::post('compras/detalle/principalorden', 'DetalleCompraController@crearOrdendoc')->name('DetalleCompraController.crearOrdendoc');
    Route::get('compras/detalle/{id}/destroyed2', 'DetalleCompraController@destroyed2')->name('DetalleCompraController.eliminar2');
    Route::get('compras/delete/{id}', 'DetalleCompraController@delete')->name('compras.detalle.delete');
    Route::get('compras/aprovar/{id}', 'DetalleCompraController@aprovar')->name('compras.detalle.aprovar');

    Route::get('compras/detalle/invitacion/{id}', 'DetalleCompraController@invitacion')->name('compras.detalle.principal.invitacion');
    Route::get('compras/detalle/aceptacion/{id}', 'DetalleCompraController@aceptacion')->name('compras.detalle.principal.aceptacion');
    Route::get('compras/detalle/cotizacion/{id}', 'DetalleCompraController@cotizacion')->name('compras.detalle.principal.cotizacion');
    Route::get('compras/detalle/adjudicacion/{id}', 'DetalleCompraController@adjudicacion')->name('compras.detalle.principal.adjudicacion');
    Route::get('compras/detalle/orden/{id}', 'DetalleCompraController@orden')->name('compras.detalle.principal.orden');


    ///////////////////////////////--COMPRAS DETALLE PARCIAL--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    Route::get('compras/detalleparcial/index', 'DetalleCompraController2@index')->name('compras.detalleparcial.index');
    Route::post('compras/detalleparcial/store', 'DetalleCompraController2@store')->name('compras.detalleparcial.store');
    Route::get('compras/detalleparcial/principal/{id}', 'DetalleCompraController2@crearOrdenxxx')->name('compras.detalleparcial.principal');
    Route::post('compras/detalleparcial/principal/store', 'DetalleCompraController2@crearOrden')->name('compras.detalleparcial.principal.store');
    Route::get('compras/detalleparcial/{id}/principalorden', 'DetalleCompraController2@crearOrdendocxx')->name('compras.detalleparcial.principalorden');
    Route::get('compras/detalleparcial/show', 'DetalleCompraController2@show')->name('compras.detalleparcial.show');
    Route::post('compras/detalleparcial/principalorden', 'DetalleCompraController@crearOrdendoc')->name('DetalleCompraController2.crearOrdendoc');
    Route::get('compras/detalleparcial/{id}/destroyed2', 'DetalleCompraController2@destroyed2')->name('DetalleCompraController2.eliminar2');
    Route::get('compras/delete2/{id}', 'DetalleCompraController2@delete')->name('compras.detalleparcial.delete');

    Route::get('compras/detalleparcial/invitacion/{id}', 'DetalleCompraController2@invitacion')->name('compras.detalleparcial.principal.invitacion');
    Route::get('compras/detalleparcial/aceptacion/{id}', 'DetalleCompraController2@aceptacion')->name('compras.detalleparcial.principal.aceptacion');
    Route::get('compras/detalleparcial/cotizacion/{id}', 'DetalleCompraController2@cotizacion')->name('compras.detalleparcial.principal.cotizacion');
    Route::get('compras/detalleparcial/adjudicacion/{id}', 'DetalleCompraController2@adjudicacion')->name('compras.detalleparcial.principal.adjudicacion');
    Route::get('compras/detalleparcial/orden/{id}', 'DetalleCompraController2@orden')->name('compras.detalleparcial.principal.orden');

    ///////////////////////////--COMPRAS PARTIDA--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    Route::get('compras/partida/index', 'PartidaController@index')->name('partida.index');
    Route::get('compras/partida/listado', 'PartidaController@listado')->name('partida.list');

    ////////////////////////////--COMPRAS PRODUCTO--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('compras/productos/index', 'ProdServController@index')->name('productos.index');
    Route::get('compras/productos/list', 'ProdServController@list')->name('producto.list');
    Route::get('compras/productos/{id}/edit', 'ProdServController@editar')->name('productos.edit');
    Route::POST('compras/productos/{id}/update', 'ProdServController@update')->name('productos.update');
    Route::get('compras/productos/create', 'ProdServController@create')->name('productos.create');
    Route::POST('compras/productos/store', 'ProdServController@store')->name('productos.store');

    ///////////////////////////--EMPLEADOS--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('compras/empleados/index', 'EmpleadosController@index')->name('empleados.index');
    Route::get('compras/empleados/list', 'EmpleadosController@list')->name('empleados.list');


    /*RECURSOS HUMANOS PLANTA*/
    Route::get('rechumanos/planta', 'PlantaController@index')->name('planta.index');
    Route::get('rechumanos/planta/list', 'PlantaController@list')->name('planta.list');
    Route::get('rechumanos/planta/detalle/{id}', 'PlantaController@detalle')->name('planta_detalle');
    Route::get('rechumanos/planta/edit/{id}', 'PlantaController@edit')->name('planta.edit');
    Route::get('rechumanos/planta/lista/{id}', 'PlantaController@lista')->name('planta.lista');
    Route::get('rechumanos/planta/create/{id}', 'PlantaController@plantanuevo')->name('planta.crear');
    Route::get('rechumanos/planta/edit/{id}', 'PlantaController@editarplanta')->name('planta.editar');
    Route::post('rechumanos/planta/guardarplanta', 'PlantaController@guardarplanta')->name('planta.guardar');
    Route::post('rechumanos/planta/actualizarplanta', 'PlantaController@actualizarPlanta')->name('planta.actualizar');
    Route::get('rechumanos/planta/lista2', 'PlantaController@detallePlanta')->name('planta.listageneral');
    Route::get('rechumanos/planta/delete/{id}', 'PlantaController@editarplanta2')->name('planta.editar2');
    Route::post('rechumanos/planta/deletePlanta', 'PlantaController@deletePlanta')->name('planta.delete');


    /*RECURSOS HUMANOS CONTRATO*/
    Route::get('rechumanos/contrato/index', 'ContratoController@index')->name('contrato.index');
    Route::get('rechumanos/contrato/list', 'ContratoController@list')->name('contrato.list');
    Route::get('rechumanos/contrato/detalle/{id}', 'ContratoController@detalle')->name('contrato_detalle');
    Route::get('rechumanos/contrato/edit/{id}', 'ContratoController@edit')->name('contrato.edit');
    Route::get('rechumanos/contrato/lista/{id}', 'ContratoController@lista')->name('contrato.lista');
    Route::get('rechumanos/contrato/create/{id}', 'ContratoController@contratonuevo')->name('contrato.crear');
    Route::get('rechumanos/contrato/edit/{id}', 'ContratoController@editarcontrato')->name('contrato.editar');
    Route::POST('rechumanos/contrato/guardarcontrato', 'ContratoController@guardarcontrato')->name('contrato.guardar');
    Route::POST('rechumanos/contrato/actualizarcontrato', 'ContratoController@actualizarcontrato')->name('contrato.actualizar');
    Route::GET('rechumanos/contrato/lista2', 'ContratoController@detallecontrato')->name('contrato.listageneral');


    /*COMPRAS PROVEEDORES*/
    Route::get('compras/proveedores/index', 'ProveedoresController@index')->name('proveedores.index')->middleware('can:proveedores_access');
    Route::get('compras/proveedores/list', 'ProveedoresController@list')->name('proveedores.list')->middleware('can:proveedores_access');
    Route::get('compras/proveedores/{id}/edit', 'ProveedoresController@edit')->name('proveedores.edit')->middleware('can:proveedores_access');
    Route::POST('compras/proveedores/{id}/update', 'ProveedoresController@update')->name('proveedores.update')->middleware('can:proveedores_access');
    Route::get('compras/proveedores/create', 'ProveedoresController@create')->name('proveedores.create')->middleware('can:proveedores_access');
    Route::POST('compras/proveedores/store', 'ProveedoresController@store')->name('proveedores.store')->middleware('can:proveedores_access');
    Route::get('compras/proveedores/{id}/editardoc', ['uses' => 'ProveedoresController@editardoc', 'as' => 'Proveedores.editdoc'])->middleware('can:proveedores_access');
    Route::get('compras/proveedores/{id}/createdocproveedor', 'ProveedoresController@createdoc')->name('ProveedoresController.createdoc')->middleware('can:proveedores_access');
    Route::POST('compras/proveedores/insertar', 'ProveedoresController@insertar')->name('ProveedoresController.insertar')->middleware('can:proveedores_access');

    /*COMPRAS AREAS*/
    Route::get('compras/areas/index', 'AreasController@index')->name('areas.index')->middleware('can:areas_access');
    Route::get('compras/areas/list', 'AreasController@listado')->name('areas.list')->middleware('can:areas_access');
    Route::get('compras/areas/create', 'AreasController@create')->name('areas.create')->middleware('can:areas_access');
    Route::get('compras/areas/{id}/edit', 'AreasController@edit')->name('areas.edit')->middleware('can:areas_access');
    Route::POST('compras/areas/{id}/update', 'AreasController@update')->name('areas.update')->middleware('can:areas_access');
    Route::POST('compras/areas/store', 'AreasController@store')->name('areas.store')->middleware('can:areas_access');
    Route::get('compras/areas/{id}/file', 'AreasController@file')->name('areas.file')->middleware('can:areas_access');
    Route::get('compras/areas/{id}/crearFile', 'AreasController@crearFile')->name('areas.crearFile')->middleware('can:areas_access');
    Route::POST('compras/areas/guardarfile', 'AreasController@guardarfile')->name('areas.guardarfile')->middleware('can:areas_access');
    Route::get('compras/areas/{id}/actualizarfile', 'AreasController@editfile')->name('file.edit')->middleware('can:areas_access');
    Route::POST('compras/areas/updatefile', 'AreasController@updatefile')->name('file.update')->middleware('can:areas_access');
    Route::get('compras/areas/{id}/file2', 'AreasController@file2')->name('areas.file2')->middleware('can:areas_access');
    Route::get('compras/areas/{id}/crearFile2', 'AreasController@crearFile2')->name('areas.crearFile2')->middleware('can:areas_access');
    Route::POST('compras/areas/guardarfile2', 'AreasController@guardarfile2')->name('areas.guardarfile2')->middleware('can:areas_access');
    Route::get('compras/areas/{id}/actualizarfile2', 'AreasController@editfile2')->name('file2.edit')->middleware('can:areas_access');
    Route::POST('compras/areas/updatefile2', 'AreasController@updatefile2')->name('file2.update')->middleware('can:areas_access');

    //////////////////////////////--COMPRAS PROGRAMAS--////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('compras/programas/index', 'ProgramaController@index')->name('programas.index')->middleware('can:programas_access');
    Route::get('compras/programas/list', 'ProgramaController@listado')->name('programas.list')->middleware('can:programas_access');
    Route::get('compras/programas/{id}/edit', 'ProgramaController@edit')->name('programas.edit')->middleware('can:programas_access');
    Route::POST('compras/programas/{id}/update', 'ProgramaController@update')->name('programas.update')->middleware('can:programas_access');
    Route::get('compras/programas/create', 'ProgramaController@create')->name('programas.create')->middleware('can:programas_access');
    Route::POST('compras/programas/store', 'ProgramaController@store')->name('programas.store')->middleware('can:programas_access');

    ////////////////////////////////--COMPRAS CATEGORIAS PROGRAMATICAS--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('compras/catprog/index', 'CatProgController@index')->name('catprog.index')->middleware('can:catprog_access');
    Route::get('compras/catprog/list', 'CatProgController@listado')->name('catprog.list')->middleware('can:catprog_access');
    Route::get('compras/catprog/{id}/edit', 'CatProgController@editar')->name('catprog.edit')->middleware('can:catprog_access');
    Route::POST('compras/catprog/{id}/update', 'CatProgController@update')->name('catprog.update')->middleware('can:catprog_access');
    Route::get('compras/catprog/create', 'CatProgController@create')->name('catprog.create')->middleware('can:catprog_access');
    Route::POST('compras/catprog/store', 'CatProgController@store')->name('catprog.store')->middleware('can:catprog_access');


    ////////////////////////////////--ACTIVOS FIJOS--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    Route::get('activosFijos/activos', 'ActivosController@index')->name('activos.index');

    ////////////////////////////////--DISCAPACIDAD--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('canasta/entrega/index', 'CanastaEntregaController@index')->name('canasta.entrega.index'); //->middleware('can:canasta.entrega.index');
    Route::get('canasta/entrega/search', 'CanastaEntregaController@search')->name('canasta.entrega.search'); //->middleware('can:canasta.entrega.index');
    Route::get('canasta/pendientes/index', 'CanastaPendientesController@index')->name('canasta.pendientes.index'); //->middleware('can:canasta.entrega.index');
    Route::get('canasta/pendientes/search', 'CanastaPendientesController@search')->name('canasta.pendientes.search'); //->middleware('can:canasta.entrega.index');
    Route::get('canasta/pendientes/search-detalle', 'CanastaPendientesController@searchdetalle')->name('canasta.pendientes.search.detalle'); //->middleware('can:canasta.entrega.index');
    Route::get('canasta/pendientes/search-detalle-pdf', 'CanastaPendientesController@searchdetallepdf')->name('canasta.pendientes.search.detallepdf'); //->middleware('can:canasta.entrega.index');

    Route::get('activosvsiaf/index', 'ActivosVsiafController@index')->name('activos.vsiaf.index'); //->middleware('can:canasta.entrega.index');
    Route::get('activosvsiaf/search', 'ActivosVsiafController@search')->name('activos.vsiaf.search'); //->middleware('can:canasta.entrega.index');

    /////////////////////////--ENCARGADOS--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('compras/pedidoparcial/responsable', 'CompraController2@listadoResponsables')->name('compras.pedidoparcial.listadoResponsables');
    Route::get('compras/pedidoparcial/responsableCreate', 'CompraController2@crearEncargado')->name('compras.pedidoparcial.crearEncargado')->middleware('can:compras_encargados_create');
    Route::POST('compras/pedidoparcial/store2', 'CompraController2@storeEncargado')->name('compras.pedidoparcial.storeEncargado')->middleware('can:compras_encargados_create');
    Route::get('compras/pedidoparcial/responsableEdit/{id}', 'CompraController2@responsableEdit')->name('compras.pedidoparcial.responsableEdit')->middleware('can:compras_encargados_edit');
    Route::post('compras/pedidoparcial/responsableUpdate', 'CompraController2@UpdateResponsable')->name('compras.pedidoparcial.UpdateResponsable')->middleware('can:compras_encargados_edit');


    ////////////////////////////--ARCHIVOS--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('archivos/index', 'ArchivosController@index')->name('archivos.index');
    Route::get('archivos/createArchivo', 'ArchivosController@createArchivo')->name('archivos.create');
    Route::get('archivos/create', 'ArchivosController@create')->name('archivos.create');
    Route::POST('archivos/insertar', 'ArchivosController@insertar')->name('archivos.insertar');

    Route::get('archivos/{id}/edit', 'ArchivosController@editar')->name('archivos.edit');
    Route::POST('archivos/{id}/update', 'ArchivosController@update')->name('archivos.update');


    ////////////////////////////--ARCHIVOS2--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('archivos2/index', 'ArchivosController2@index')->name('archivos2.index');
    Route::get('archivos2/createArchivo', 'ArchivosController2@createArchivo')->name('archivos2.create');
    Route::get('archivos2/create', 'ArchivosController2@create')->name('archivos2.create');
    Route::POST('archivos2/insertar', 'ArchivosController2@insertar')->name('archivos2.insertar');

    Route::get('archivos2/{id}/edit', 'ArchivosController2@editar')->name('archivos2.edit');
    Route::POST('archivos2/{id}/update', 'ArchivosController2@update')->name('archivos2.update');

    Route::get('archivos2/index2', 'ArchivosController2@index2')->name('archivos2.index2');
    Route::get('/archivos2/datatable', 'ArchivosController2@index22')->name('archivos2.index22');
    Route::get('/archivos2/tipoarchivo', 'ArchivosController2@tipo')->name('archivos2.tipo');
    Route::POST('/archivos2/tipoarchivo', 'ArchivosController2@guardartipoarea')->name('archivos2.guardartipo');
    Route::get('/archivos2/delete{id}', 'ArchivosController2@delete')->name('archivos2.delete');


    Route::get('archivos2/createtipo', 'ArchivosController2@createtipoarchivo')->name('archivos2.createtipo');
    Route::POST('archivos2/createtipoarchivo', 'ArchivosController2@guardartipoarchivo')->name('archivos2.storecreatetipo');


    /////////////////////////--ALMACEN--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('almacen/index', 'AlmacenController@index')->name('almacen.index');
    Route::get('almacen/detalle/{id}', 'AlmacenController@detalle')->name('almacen.detalle');
    //Route::get('compras/pedido/index2', 'CompraController@index2')->name('compras.pedido.index2');
    //oute::get('compras/pedido/create', 'CompraController@create')->name('compras.pedido.create');
    //Route::post('compras/pedido/store', 'CompraController@store')->name('compras.pedido.store');
    Route::get('almacen/temporal/{id}', 'AlmacenController@temporal')->name('almacen.temporal');
    //Route::get('compras/pedido/editar/{id}', 'CompraController@editar')->name('compras.pedido.editar');
    //Route::post('compras/pedido/update', 'CompraController@update')->name('compras.pedido.update');

    /////////////////////////--CORRESPONDENCIA--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('correspondencia/index', 'RecepcionController@index')->name('recepcion.index');
    Route::get('correspondencia/createRecepcion', 'RecepcionController@create')->name('recepcion.create');
    Route::get('correspondencia/indexUnidad', 'RecepcionController@indexUnidad')->name('recepcion.unidadIndex');
    Route::get('correspondencia/indexRemitente', 'RecepcionController@indexRemitente')->name('recepcion.remitenteIndex');
    Route::get('correspondencia/createUnidad', 'RecepcionController@createLugar')->name('crear.lugar');
    Route::post('correspondencia/storeLugar', 'RecepcionController@storeLugar')->name('guardar.lugar');
    Route::get('correspondencia/createRemitente', 'RecepcionController@createRemitente')->name('crear.remitente');
    Route::post('correspondencia/storeRemitente', 'RecepcionController@storeRemitente')->name('guardar.remitente');
    Route::get('correspondencia/createRecepcion', 'RecepcionController@createRecepcion')->name('crear.recepcion');
    Route::post('correspondencia/storeRecepcion', 'RecepcionController@storeRecepcion')->name('guardar.recepcion');
    Route::get('correspondencia/{id}/edit', 'RecepcionController@editarCodigo')->name('correspondencia.edit');
    Route::POST('correspondencia/{id}/updateCodigo', 'RecepcionController@updateCodigo')->name('correspondencia.update');

    ////////////////////////////--AGENDA--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('agenda/index', 'AgendaController@index')->name('agenda.index');
    Route::get('archivos2/createArchivo', 'ArchivosController@createArchivo')->name('agenda.create');
    Route::get('agenda/create', 'AgendaController@create')->name('agenda.create');
    Route::POST('agenda/insertar', 'AgendaController@insertar')->name('agenda.insertar');

    Route::get('agenda/{id}/edit', 'AgendaController@editar')->name('agenda.edit');
    Route::POST('agenda/{id}/update', 'AgendaController@update')->name('agenda.update');

    Route::get('agenda/{id}/edit2', 'AgendaController@editar2')->name('agenda.edit2');
    Route::POST('agenda/{id}/update2', 'AgendaController@update2')->name('agenda.update2');

    Route::get('agenda/indexayer', 'AgendaController@indexayer')->name('agenda.indexayer');
    Route::get('agenda/indexhoy', 'AgendaController@indexhoy')->name('agenda.indexhoy');
    Route::get('agenda/indexmaniana', 'AgendaController@indexmaniana')->name('agenda.indexmaniana');
    Route::get('agenda/delete/{id}', 'AgendaController@delete')->name('agenda.delete');
    Route::get('agenda/indextotal', 'AgendaController@indextotal')->name('agenda.indextotal');

    ////evento////
    Route::get('Calendar/event', 'ControllerCalendar@index');
    Route::get('Calendar/event/{mes}', 'ControllerCalendar@index_month');

    // formulario
    Route::get('Evento/form/{mes}', 'ControllerEvent@form');
    Route::post('Evento/create', 'ControllerEvent@create');
    // Detalles de evento
    Route::get('Evento/details/{id},{id2},{id3}', 'ControllerEvent@details');
    Route::get('Evento/details2/{id}', 'ControllerEvent@details2');
    // Calendario
    Route::get('Evento/index', 'ControllerEvent@index');
    Route::get('Evento/index/{month}', 'ControllerEvent@index_month');

    // editar
    Route::get('Evento/actualizar/{id}', 'ControllerEvent@editar');
    Route::post('Evento/actualizar2/{id}', 'ControllerEvent@actualizar');

    /////////////////////////--CORRESPONDENCIA 2--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('correspondencia2/index', 'Recepcion2Controller@index')->name('recepcion2.index');
    Route::get('correspondencia2/{id}/edit', 'Recepcion2Controller@editarCodigo')->name('correspondencia2.edit');
    Route::POST('correspondencia2/{id}/updateCodigo', 'Recepcion2Controller@updateCodigo')->name('correspondencia2.update');
    Route::get('correspondencia2/createRecepcion', 'Recepcion2Controller@createRecepcion')->name('crear2.recepcion');
    Route::post('correspondencia2/storeRecepcion', 'Recepcion2Controller@storeRecepcion')->name('guardar2.recepcion');
    Route::get('correspondencia2/indexUnidad', 'Recepcion2Controller@indexUnidad')->name('recepcion2.unidadIndex');
    Route::get('correspondencia2/createUnidad', 'Recepcion2Controller@createLugar')->name('crear2.lugar');
    Route::post('correspondencia2/storeLugar', 'Recepcion2Controller@storeLugar')->name('guardar2.lugar');
    Route::get('correspondencia2/indexRemitente', 'Recepcion2Controller@indexRemitente')->name('recepcion2.remitenteIndex');
    Route::get('correspondencia2/createRemitente', 'Recepcion2Controller@createRemitente')->name('crear2.remitente');
    Route::post('correspondencia2/storeRemitente', 'Recepcion2Controller@storeRemitente')->name('guardar2.remitente');
    Route::get('correspondencia2/createTipo', 'Recepcion2Controller@createTipo')->name('crear2.tipo');
    Route::post('correspondencia2/storeTipo', 'Recepcion2Controller@storeTipo')->name('guardar2.tipo');
    //////////////////
    Route::get('correspondencia2/{id}/gestionarCorrespondencia', 'Recepcion2Controller@gestionarCorrespondencia')->name('correspondencia2.gestionar');
    Route::get('correspondencia2/{id}/cargarpdf', 'Recepcion2Controller@cargarpdf')->name('correspondencia2.cargarpdf');
    Route::post('correspondencia2/storepdf', 'Recepcion2Controller@storepdf')->name('correspondencia2.storepdf');
    Route::get('correspondencia2/{id}/derivar', 'Recepcion2Controller@derivar')->name('correspondencia2.derivar');
    Route::get('correspondencia2/derivar2', 'Recepcion2Controller@guardarderivacion')->name('correspondencia2.guardarderivacion');
    Route::get('correspondencia2/delete{id}', 'Recepcion2Controller@delete')->name('correspondencia2.delete');
    Route::get('correspondencia2/urlfile/{id}', 'Recepcion2Controller@urlfile')->name('correspondencia2.urlfile');
    Route::get('correspondencia2/{id}/actualizarpdf', 'Recepcion2Controller@actualizarpdf')->name('correspondencia2.actualizarpdf');
    Route::post('correspondencia2/updatepdf', 'Recepcion2Controller@updatepdf')->name('correspondencia2.updatepdf');
    Route::get('correspondencia2/notificacion', 'Recepcion2Controller@notificacion')->name('correspondencia2.notificacion');
    ///////////
    Route::get('derivacion/index', 'Recepcion2Controller@indexderivacion')->name('derivacion.index');
    Route::get('derivacion/{id}/gestionarCorrespondencia', 'Recepcion2Controller@gestionarCorrespondencia2')->name('derivacion.gestionar');



    ////evento2////

    // formulario
    Route::get('Evento2/form/{mes}', 'ControllerEvent2@form');
    Route::post('Evento2/create', 'ControllerEvent2@create');
    // Detalles de evento
    Route::get('Evento2/details/{id},{id2},{id3}', 'ControllerEvent2@details');
    Route::get('Evento2/details2/{id}', 'ControllerEvent2@details2');
    // Calendario
    Route::get('Evento2/index', 'ControllerEvent2@index');
    Route::get('Evento2/index/{month}', 'ControllerEvent2@index_month');

    // editar
    Route::get('Evento2/actualizar/{id}', 'ControllerEvent2@editar');
    Route::post('Evento2/actualizar2/{id}', 'ControllerEvent2@actualizar');

    Route::get('Evento2/{id}/cargarpdf', 'ControllerEvent2@cargarpdf')->name('evento2.cargarpdf');
    Route::post('Evento2/storepdf', 'ControllerEvent2@storepdf')->name('evento2.storepdf');
    Route::get('Evento2/{id}/actualizarpdf', 'ControllerEvent2@actualizarpdf')->name('evento2.actualizarpdf');
    Route::POST('Evento2/updatepdf', 'ControllerEvent2@updatepdf')->name('evento2.updatepdf');
    Route::get('Evento2/urlfile/{id}', 'ControllerEvent2@urlfile')->name('evento2.urlfile');





    /////////////////////////--CANASTA--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('canasta/index', 'CanastaBeneficiariosController@index')->name('canasta.index');
    Route::get('canasta/search', 'CanastaBeneficiariosController@search')->name('canasta.search');
    Route::get('almacen/detalle/{id}', 'AlmacenController@detalle')->name('almacen.detalle');


    //Route::get('compras/pedido/index2', 'CompraController@index2')->name('compras.pedido.index2');
    //oute::get('compras/pedido/create', 'CompraController@create')->name('compras.pedido.create');
    //Route::post('compras/pedido/store', 'CompraController@store')->name('compras.pedido.store');
    //Route::get('almacen/temporal/{id}','AlmacenController@temporal')->name('almacen.temporal');
    //Route::get('compras/pedido/editar/{id}', 'CompraController@editar')->name('compras.pedido.editar');
    //Route::post('compras/pedido/update', 'CompraController@update')->name('compras.pedido.update');


    ///////////////////REGISTRO DE ASISTENCIAS/////////////////

    Route::get('/estado-expiraciones/index', 'EstadoExpiracionesController@index')->name('notificacion.index')->middleware('can:estado_exp_access');
    Route::get('/estado-expiraciones/{id}', 'EstadoExpiracionesController@show')->name('lista.index')->middleware('can:estado_exp_access');
    Route::get('estado-expiraciones-exp/', 'EstadoExpiracionesController@expira')->name('lista2.exp')->middleware('can:estado_exp_access');
    Route::get('estado-expiraciones-exp/lista', 'EstadoExpiracionesController@planta')->name('planta')->middleware('can:estado_exp_access');
    Route::get('estado-expiraciones-exp/lista2', 'EstadoExpiracionesController@contrato')->name('contrato')->middleware('can:estado_exp_access');



 
    Route::get('horarios/cambio/{empleado}', 'HorarioController@cambio')->name('horarios.cambio')->middleware('can:horario_access');

    Route::put('/horarios/{horario}/updatehora', 'HorarioController@updatehora')->name('horarios.updatehora')->middleware('can:update_horario_access');


    Route::get('horarios/index', 'HorarioController@index')->name('horarios.index')->middleware('can:horario_access');
    Route::get('horarios/create', 'HorarioController@create')->name('horarios.create')->middleware('can:horario_crear_access');
    Route::post('horarios/store', 'HorarioController@store')->name('horarios.store')->middleware('can:horario_guardar_access');

    //Route::get('horarios/show/{horario}', 'HorarioController@show')->name('horarios.show')->middleware('can:horario_access');
    //Route::get('horarios/destroy/{horario}', 'HorarioController@destroy')->name('horarios.destroy')->middleware('can:horario_access');
    Route::get('horarios/{horario}/edit', 'HorarioController@edit')->name('horarios.edit')->middleware('can:horario_editar_access');
    Route::put('horarios/update/{horario}', 'HorarioController@update')->name('horarios.update')->middleware('can:update_horario_access');
    
    Route::put('horarios/guardar/{empleado}', 'HorarioController@guardar')->name('horarios.guardar')->middleware('can:horario_access');
    Route::put('horarios/pin/{empleado}', 'HorarioController@pinguardar')->name('pin.guardar')->middleware('can:update_pin_access');
   
    //activar-Desactivar Horario
    Route::put('/horarios/{id}/updateEstado', 'HorarioController@updateEstado')->name('horarios.updateEstado')->middleware('can:update_horario_access');

    //Programar-Horario-Fechas
    Route::get('horarios/fechas', 'HorarioController@fechas')->name('horarios.fechas')->middleware('can:asistencias_access');

    Route::get('asistencia/{id}', 'AsistenciaController@edit')->name('asistencia.edit')->middleware('can:asistencias_fechas_edit_access');
    Route::get('asistencia/crear/{fecha}', 'AsistenciaController@crear')->name('asistencia.crear')->middleware('can:asistencias_fechas_crear_access');
    Route::post('asistencia/store', 'AsistenciaController@store')->name('asistencia.store')->middleware('can:asistencias_fechas_guardar_access');
    Route::put('asistencia/update/{asistencia}', 'AsistenciaController@update')->name('asistencia.update')->middleware('can:asistencias_fechas_update_access');


    Route::get('empleadoasistencias/', 'EmpleadoAsistenciasController@index')->name('empleadoasistencias.index')->middleware('can:asistencias_access');
    Route::get('empleadoasistencias/show/{id}', 'EmpleadoAsistenciasController@show')->name('empleadoasistencias.show')->middleware('can:asistencias_access');

    Route::get('empleadoasistencias/lista', 'EmpleadoAsistenciasController@planta')->name('empleadoasistencias.planta')->middleware('can:asistencias_access');
    Route::get('empleadoasistencias/lista2', 'EmpleadoAsistenciasController@contrato')->name('empleadoasistencias.contrato')->middleware('can:asistencias_access');


    Route::get('descuentos/index', 'DescuentosController@index')->name('descuentos.index')->middleware('can:horario_access');
    Route::get('descuentos/create', 'DescuentosController@create')->name('descuentos.create')->middleware('can:horario_access');
    Route::post('descuentos/store', 'DescuentosController@store')->name('descuentos.store')->middleware('can:horario_access');
    Route::get('descuentos/show/{id}', 'DescuentosController@show')->name('descuentos.show')->middleware('can:horario_access');
    Route::put('descuentos/update/{descuento}', 'DescuentosController@update')->name('descuentos.update')->middleware('can:horario_access');
    Route::get('descuentos/{descuento}/edit', 'DescuentosController@edit')->name('descuentos.edit')->middleware('can:horario_access');


    Route::get('registroasistencia', 'RegistroAsistenciaController@index')->name('registroasistencia.index')->middleware('can:asistencias_access');
    Route::get('registroasistencia/create', 'RegistroAsistenciaController@create')->name('registroasistencia.create')->middleware('can:asistencias_access');
    Route::post('registroasistencia/store', 'RegistroAsistenciaController@store')->name('registroasistencia.store')->middleware('can:asistencias_access');


    /////////////
    Route::get('retrasosempleado', 'RetrasoController@index')->name('retrasos.index')->middleware('can:reporte_access');
    Route::get('ausencias', 'AusenciasController@index')->name('ausencias.index')->middleware('can:asistencias_access');

    Route::get('agregar-regulacion/{id}', 'EmpleadoAsistenciasController@agregarRegulacion')->name('agregar.regulacion')->middleware('can:horario_access');;
    Route::get('regularizar-nuevo', 'AusenciasController@regularizar2')->name('regularizarCrear')->middleware('can:horario_access');;
    Route::get('regularizar-fecha/{fecha}/{id}', 'AusenciasController@crear')->name('fecha.crear')->middleware('can:regularizar_access_crear');

    Route::get('regularizar-ausencia/{id}', 'AusenciasController@regularizar')->name('regularizar.ausencia')->middleware('can:asistencias_access');
    
    Route::put('regularizar-asistencia/{id}', 'AusenciasController@update')->name('regularizar_asistencia.update')->middleware('can:asistencias_access');
    Route::get('historial-cambios-asistencia', 'HistorialAsistenciasController@index')->name('historial_asistencia.index')->middleware('can:asistencias_access');
    Route::get('restaurar-datos/{id}', 'HistorialAsistenciasController@restore')->name('restaurar-datos.restore')->middleware('can:asistencias_access');
    Route::get('historial-cambios-personal', 'HistorialAsistenciasController@personalHistorial')->name('personalHistorial')->middleware('can:asistencias_access');


    // Route::get('reportes', 'ReporteController@index')->name('reportes.index')->middleware('can:reporte_access');
    Route::get('reportes/create', 'ReporteController@create')->name('reportes.create')->middleware('can:reporte_access');
    // Route::post('reportes/store', 'ReporteController@store')->name('reportes.store')->middleware('can:reporte_access');
    // Route::get('reportes/show/{reporte}', 'ReporteController@show')->name('reportes.show')->middleware('can:reporte_access');
    //Route::get('reportes/getReporte', 'ReporteController@getReporte')->name('reportes.getReporte')->middleware('can:reporte_access');

    Route::get('reportes/personalgetReporte', 'ReporteController@personalgetReporte')->name('personalreportes.getReporte')->middleware('can:reporte_access');
    Route::get('reportes/areaGetReporte', 'ReporteController@areaGetReporte')->name('areaGetReportes.getReporte')->middleware('can:reporte_access');
    Route::get('reportes/allGetReporte', 'ReporteController@allGetReporte')->name('allGetReportes.getReporte')->middleware('can:reporte_access');
    
    Route::post('reportes/registros-personales', 'ReporteController@registro')->name('registro.visualizar')->middleware('can:reporte_access');

    Route::post('reportes/personales', 'ReporteController@visualizar')->name('reportes.visualizar')->middleware('can:reporte_access');
    Route::post('reportes/unidades', 'ReporteController@visualizar2')->name('reportes.visualizar2')->middleware('can:reporte_access');
    Route::post('reportes/general', 'ReporteController@visualizar3')->name('reportes.visualizar3')->middleware('can:reporte_access');
     Route::get('reportes/asistenciapersonalReporte', 'ReporteController@asistenciapersonalreportes')->name('asistenciapersonalreportes.getReporte')->middleware('can:reporte_access');

    Route::get('reportes/detalle/{id}/{fecha_i}/{fecha_f}', 'ReporteController@detalle')->name('reportespersonales.detalle')->middleware('can:reporte_access');
    Route::get('reportes/personalReporte-pdf', 'ReporteController@previsualizarPdf')->name('previsualizarPdf')->middleware('can:reporte_access');
    Route::get('reportes/areasReporte-pdf', 'ReporteController@areaprevisualizarPdf')->name('areaprevisualizarPdf')->middleware('can:reporte_access');
    Route::get('reportes/generalReporte-pdf', 'ReporteController@generalReportePdf')->name('generalReportePdf')->middleware('can:reporte_access');
    Route::get('reportes/asistencia-personalReporte-pdf', 'ReporteController@asistenciaPdf')->name('asistenciaPdf')->middleware('can:reporte_access');


    //Permisos Mensuales
    Route::get('permisos/id', 'PermisosPersonalesController@getID')->name('permisospersonales.getID')->middleware('can:permisos_access');
    Route::get('permisos', 'PermisosPersonalesController@index')->name('permisospersonales.index')->middleware('can:permisos_access');

    Route::get('permisos/nuevo/{id}/{permiso_id}', 'PermisosPersonalesController@nuevo')->name('permisospersonales.nuevo')->middleware('can:permisos_access');
    Route::get('permisos/get', 'PermisosPersonalesController@getEmpleados')->name('permisosempleados.get')->middleware('can:permisos_access');
    Route::get('permisos/create/', 'PermisosPersonalesController@create')->name('permisospersonales.create')->middleware('can:permisos_access');
    Route::post('permisos/store/', 'PermisosPersonalesController@store')->name('permisospersonales.store')->middleware('can:permisos_access');
    Route::get('permisos/detalle/{id}/{permiso_id}', 'PermisosPersonalesController@detalle')->name('permisospersonales.detalle')->middleware('can:permisos_access');
    Route::get('permisos/show', 'PermisosPersonalesController@show')->name('permisospersonales.show')->middleware('can:permisos_access');
    Route::get('editar-permiso/{id}', 'PermisosPersonalesController@editarPermiso')->name('editar.permiso')->middleware('can:permisos_access');
    Route::put('actualizar-permiso/{id}', 'PermisosPersonalesController@actualizarPermiso')->name('update.permiso')->middleware('can:permisos_access');
    Route::get('listar-permisos/{id}', 'PermisosPersonalesController@listarPermiso')->name('listar.permiso')->middleware('can:permisos_access');

    //Registro de Licencias
    Route::get('licencias', 'LicenciasPersonalesController@index')->name('licenciaspersonales.index')->middleware('can:licencias_access');

    Route::get('licencias/id', 'LicenciasPersonalesController@getID')->name('licenciaspersonales.getID')->middleware('can:licencias_access');
    Route::get('licencias/nuevo/{id}/{licencia_id}', 'LicenciasPersonalesController@nuevo')->name('licenciaspersonales.nuevo')->middleware('can:licencias_access');
    Route::get('licencias/get', 'LicenciasPersonalesController@getEmpleados')->name('licenciasempleados.get')->middleware('can:licencias_access');
    Route::get('licencias/create/', 'LicenciasPersonalesController@create')->name('licenciaspersonales.create')->middleware('can:licencias_access');
    Route::post('licencias/store/', 'LicenciasPersonalesController@store')->name('licenciaspersonales.store')->middleware('can:licencias_access');
    Route::get('licencias/detalle/{id}/{licencia_id}', 'LicenciasPersonalesController@detalle')->name('licenciaspersonales.detalle')->middleware('can:licencias_access');
    Route::get('licencias/show', 'LicenciasPersonalesController@show')->name('licenciaspersonales.show')->middleware('can:licencias_access');
    Route::get('editar-licencia/{id}', 'LicenciasPersonalesController@editarLicencias')->name('editar.licencia')->middleware('can:licencias_access');;
    Route::put('actualizar-licencia/{id}', 'LicenciasPersonalesController@actualizarLicencias')->name('update.licencia')->middleware('can:licencias_access');;
    Route::get('listar-licencia/{id}', 'LicenciasPersonalesController@listarLicencias')->name('listar.licencias')->middleware('can:licencias_access');;
    //movimientos Planta
    Route::get('rechumanos/planta/movimientos/list', 'MovimientosPlantaController@index')->name('movimientosplanta.index');
    Route::get('rechumanos/contrato/movimientos/list', 'MovimientosContratoController@index')->name('movimientoscontrato.index');
    //lector Dactilar
    Route::get('lectordactilar', 'LectorDactilarController@index')->name('lectordactilar.index')->middleware('can:dactilar_access');
});
