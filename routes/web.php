<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedidaController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PlantaController;

/*use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\PrartidaController;
use App\Http\Controllers\ProdServController;
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

Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('admin/users/index', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('admin/users/search', [UserController::class, 'search'])->name('admin.users.search');
    Route::get('admin/users/excel', [UserController::class, 'excel'])->name('admin.users.excel');
    Route::get('admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('admin/users/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('admin/users/edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('admin/users/update', [UserController::class, 'update'])->name('admin.users.update');
    Route::get('admin/users/baja/{id}', [UserController::class, 'baja'])->name('admin.users.baja');
    Route::get('admin/users/alta/{id}', [UserController::class, 'alta'])->name('admin.users.alta');

    Route::get('/compras/medidas/create', [MedidaController::class, 'create'])->name('medidas.create');

    Route::get('rechumanos/planta/lista2', [PlantaController::class, 'detallePlanta'])->name('planta.listageneral');
    Route::get('rechumanos/planta/lista2/show/{id}', [PlantaController::class, 'detallePlantaShow'])->name('planta.listageneral.show');
});

Auth::routes();

Route::group(['prefix'=>"admin/",
                'as' => 'admin.',
                'namespace' => 'App\Http\Controllers\Admin',
                'middleware' => ['auth','AdminPanelAccess']],
function () {
    //Route::get('/', 'HomeController@index')->name('home');
    //Route::resource('/users', 'UserController');
    //Route::get('users/index', 'UserController@index')->name('users.index');
    //Route::get('users/search', 'UserController@search')->name('users.search');
    //Route::get('users/create', 'Admin\UserController@create')->name('users.create');
    Route::resource('/roles', 'RoleController');
    Route::resource('/permissions', 'PermissionController')->except(['show']);

    //Route::get('compras/medidas/create', 'MedidaController@create')->name('medidas.create');

    /*Route::group(['namespace' => 'App\Http\Controllers'], function() {
        Route::get('compras/medidas/index', 'MedidaController@index')->name('medidas.index')->middleware('can:medidas_access');
    });*/
});


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::group(['namespace' => 'App\Http\Controllers'], function() {
    Route::get('compras/medidas/index', 'MedidaController@index')->name('medidas.index')->middleware('can:medidas_access');
    Route::get('compras/medidas/list', 'MedidaController@listado')->name('medidas.list');
    Route::get('compras/medidas/{id}/edit', 'MedidaController@editar')->name('medidas.edit');
    Route::post('compras/medidas/{id}/update', 'MedidaController@update')->name('medidas.update');
   // Route::get('compras/medidas/create', 'MedidaController@create')->name('medidas.create');
    //Route::get('compras/medidas/create', 'MedidaController@create')->name('medidas.create');
    Route::post('compras/medidas/store', 'MedidaController@store')->name('medidas.store');


    //Route::get('admin/users/baja/{id}', 'Admin\UserController@baja')->name('users.baja');
    //Route::get('admin/users/alta/{id}', 'Admin\UserController@alta')->name('users.alta');
    //Route::get('admin/users/index', 'Admin\UserController@index')->name('users.index');
    //Route::get('admin/users/search', 'Admin\UserController@search')->name('users.search');

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
    //Route::get('rechumanos/planta/lista2', 'PlantaController@detallePlanta')->name('planta.listageneral');
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
    Route::get('compras/proveedores/{id}/editardoc', ['uses' => 'ProveedoresController@editardoc','as' => 'Proveedores.editdoc'])->middleware('can:proveedores_access');
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

    Route::get('canasta/entrega/index', 'CanastaEntregaController@index')->name('canasta.entrega.index');//->middleware('can:canasta.entrega.index');
    Route::get('canasta/entrega/search', 'CanastaEntregaController@search')->name('canasta.entrega.search');//->middleware('can:canasta.entrega.index');
    Route::get('canasta/pendientes/index', 'CanastaPendientesController@index')->name('canasta.pendientes.index');//->middleware('can:canasta.entrega.index');
    Route::get('canasta/pendientes/search', 'CanastaPendientesController@search')->name('canasta.pendientes.search');//->middleware('can:canasta.entrega.index');
    Route::get('canasta/pendientes/search-detalle', 'CanastaPendientesController@searchdetalle')->name('canasta.pendientes.search.detalle');//->middleware('can:canasta.entrega.index');
    Route::get('canasta/pendientes/search-detalle-pdf', 'CanastaPendientesController@searchdetallepdf')->name('canasta.pendientes.search.detallepdf');//->middleware('can:canasta.entrega.index');

    Route::get('activosvsiaf/index', 'ActivosVsiafController@index')->name('activos.vsiaf.index');//->middleware('can:canasta.entrega.index');
    Route::get('activosvsiaf/search', 'ActivosVsiafController@search')->name('activos.vsiaf.search');//->middleware('can:canasta.entrega.index');

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
Route::get('almacen/detalle/{id}','AlmacenController@detalle')->name('almacen.detalle');
//Route::get('compras/pedido/index2', 'CompraController@index2')->name('compras.pedido.index2');
//oute::get('compras/pedido/create', 'CompraController@create')->name('compras.pedido.create');
//Route::post('compras/pedido/store', 'CompraController@store')->name('compras.pedido.store');
Route::get('almacen/temporal/{id}','AlmacenController@temporal')->name('almacen.temporal');
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
Route::get('Calendar/event','ControllerCalendar@index');
Route::get('Calendar/event/{mes}','ControllerCalendar@index_month');

// formulario
Route::get('Evento/form/{mes}','ControllerEvent@form');
Route::post('Evento/create','ControllerEvent@create');
// Detalles de evento
Route::get('Evento/details/{id},{id2},{id3}','ControllerEvent@details');
Route::get('Evento/details2/{id}','ControllerEvent@details2');
// Calendario
Route::get('Evento/index','ControllerEvent@index');
Route::get('Evento/index/{month}','ControllerEvent@index_month');

// editar
Route::get('Evento/actualizar/{id}','ControllerEvent@editar');
Route::post('Evento/actualizar2/{id}','ControllerEvent@actualizar');

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
Route::get('correspondencia2/urlfilederivacion/{id}', 'Recepcion2Controller@urlfile')->name('derivacion.urlfilederivacion');
Route::get('correspondencia2/pregunta', 'Recepcion2Controller@pregunta2')->name('derivacion.pregunta');
Route::get('/get-users', 'Recepcion2Controller@getUsers')->name('get-users');
Route::post('/ruta', 'Recepcion2Controller@respuesta')->name('pregunta');
//Route::post('product-data', 'HomeController@postform');
////evento2////

// formulario
Route::get('Evento2/form/{mes}','ControllerEvent2@form');
Route::post('Evento2/create','ControllerEvent2@create');
// Detalles de evento
Route::get('Evento2/details/{id},{id2},{id3}','ControllerEvent2@details');
Route::get('Evento2/details2/{id}','ControllerEvent2@details2');
// Calendario
Route::get('Evento2/index','ControllerEvent2@index');
Route::get('Evento2/index/{month}','ControllerEvent2@index_month');

// editar
Route::get('Evento2/actualizar/{id}','ControllerEvent2@editar');
Route::post('Evento2/actualizar2/{id}','ControllerEvent2@actualizar');

Route::get('Evento2/{id}/cargarpdf', 'ControllerEvent2@cargarpdf')->name('evento2.cargarpdf');
Route::post('Evento2/storepdf', 'ControllerEvent2@storepdf')->name('evento2.storepdf');
Route::get('Evento2/{id}/actualizarpdf', 'ControllerEvent2@actualizarpdf')->name('evento2.actualizarpdf');
Route::POST('Evento2/updatepdf', 'ControllerEvent2@updatepdf')->name('evento2.updatepdf');
Route::get('Evento2/urlfile/{id}', 'ControllerEvent2@urlfile')->name('evento2.urlfile');





/////////////////////////--CANASTA--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('canasta/index', 'CanastaBeneficiariosController@index')->name('canasta.index');
Route::get('canasta/search', 'CanastaBeneficiariosController@search')->name('canasta.search');
Route::get('almacen/detalle/{id}','AlmacenController@detalle')->name('almacen.detalle');


//Route::get('compras/pedido/index2', 'CompraController@index2')->name('compras.pedido.index2');
//Route::get('compras/pedido/create', 'CompraController@create')->name('compras.pedido.create');
//Route::post('compras/pedido/store', 'CompraController@store')->name('compras.pedido.store');
//Route::get('almacen/temporal/{id}','AlmacenController@temporal')->name('almacen.temporal');
//Route::get('compras/pedido/editar/{id}', 'CompraController@editar')->name('compras.pedido.editar');
//Route::post('compras/pedido/update', 'CompraController@update')->name('compras.pedido.update');

/////////////////////////--EXPOCHACO SUDAMERICANO--//////////////////////
    Route::get('expochaco/index', 'ExpoController@index')->name('expochaco.index');
    Route::get('expochaco/rubro', 'ExpoController@rubro')->name('expochaco.rubro');

    Route::get('expochaco/create', 'ExpoController@create')->name('expochaco.rubro.create');
    Route::post('expochaco/store', 'ExpoController@store')->name('expochaco.rubro.store');
});




Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/compras/medidas/create', [MedidaController::class, 'create'])->name('medidas.create');

/////////////////////////--EXPOCHACO SUDAMERICANO--//////////////////////
    //Route::get('expochaco/rubro', 'ExpoController@rubro')->name('expochaco.rubro');

});


Route::group(['namespace' => 'App\Http\Controllers\Fexpo'], function() {

    Route::get('expochaco/index', 'SolicitudController@index')
    ->name('expochaco.index');

    Route::get('expochaco/create', 'SolicitudController@create')
    ->name('expochaco.create');

    Route::post('expochaco/store', 'SolicitudController@store')
    ->name('expochaco.store');

    Route::get('expochaco/{id}/editar', 'SolicitudController@editar')
    ->name('expochaco.editar');

    Route::post('expochaco/update', 'SolicitudController@update')
    ->name('expochaco.update');

    Route::get('expochaco/delete2/{id}', 'SolicitudController@delete')
    ->name('expochaco.delete');

    Route::get('expochaco/aprovar/{id}', 'SolicitudController@aprovar')
    ->name('expochaco.aprovar');
});



Route::group(['namespace' => 'App\Http\Controllers\Compra'], function() {

    Route::get('combustibles/producto/index', 'ProdCombController@index')->name('producto.index')->middleware('can:productocomb_access');
    Route::get('combustibles/producto/create', 'ProdCombController@create')->name('producto.create');
    Route::post('combustibles/producto/store', 'ProdCombController@store')->name('producto.store');
    Route::get('combustibles/producto/list', 'ProdCombController@list')->name('producto.list');
    Route::get('combustibles/producto/{id}/edit', 'ProdCombController@editar')->name('producto.edit');
    Route::POST('combustibles/producto/{id}/update', 'ProdCombController@update')->name('producto.update');

    Route::post('/ruta3', 'ProdCombController@respuesta3')->name('pregunta3');


    Route::get('combustibles/proveedor/index', 'ProveedorController@index')->name('proveedor.index')->middleware('can:proveedorcomb_access');
    Route::get('combustibles/proveedor/create', 'ProveedorController@create')->name('proveedor.create');
    Route::post('combustibles/proveedor/store', 'ProveedorController@store')->name('proveedor.store');
    Route::get('combustibles/proveedor/list', 'ProveedorController@list')->name('proveedor.list');
    Route::get('combustibles/proveedor/{id}/edit', 'ProveedorController@editar')->name('proveedor.edit');
    Route::POST('combustibles/proveedor/{id}/update', 'ProveedorController@update')->name('proveedor.update');


    Route::get('combustibles/proveedor/{id}/editardoc', ['uses' => 'ProveedorController@editardoc','as' => 'proveedor.editdoc'])->middleware('can:proveedorcomb_access');
    Route::get('combustibles/proveedor/{id}/createdocproveedor', 'ProveedorController@createdoc')->name('ProveedorController.createdoc')->middleware('can:proveedores_access');
    Route::POST('combustibles/proveedor/insertar', 'ProveedorController@insertar')->name('ProveedorController.insertar')->middleware('can:proveedores_access');

    Route::post('/ruta2', 'ProveedorController@respuesta2')->name('pregunta2');


     Route::get('combustibles/programa/index', 'ProgramaCombController@index')->name('programa.index')->middleware('can:programacomb_access');
     Route::get('combustibles/programa/list', 'ProgramaCombController@listado')->name('programa.list')->middleware('can:programacomb_access');
     Route::get('combustibles/programa/{id}/edit', 'ProgramaCombController@edit')->name('programa.edit')->middleware('can:programacomb_access');
    Route::POST('combustibles/programa/{id}/update', 'ProgramaCombController@update')->name('programa.update')->middleware('can:programacomb_access');
     Route::get('combustibles/programa/create', 'ProgramaCombController@create')->name('programa.create')->middleware('can:programacomb_access');
    Route::POST('combustibles/programa/store', 'ProgramaCombController@store')->name('programa.store')->middleware('can:programacomb_access');

    Route::get('combustibles/partida/index', 'PartidaCombController@index')->name('partidacomb.index');
    Route::get('combustibles/partida/listado', 'PartidaCombController@listado')->name('partidacomb.list');


    Route::get('combustibles/catprog/index', 'CatProgController@index')->name('catprogcomb.index');
    Route::get('combustibles/catprogc/list', 'CatProgController@listado')->name('catprogcomb.list');
    Route::get('combustibles/catprog/{id}/edit', 'CatProgController@editar')->name('catprogcomb.edit');
    Route::POST('combustibles/catprog/{id}/update', 'CatProgController@update')->name('catprogcomb.update');
    Route::get('combustibles/catprog/create', 'CatProgController@create')->name('catprogcomb.create')->middleware('can:catprog_create');
    Route::POST('combustibles/catprog/store', 'CatProgController@store')->name('catprogcomb.store');


    Route::get('combustibles/pedido/index', 'CompraCombController@index')->name('combustibles.pedido.index');
    Route::get('combustibles/pedido/index2', 'CompraCombController@index2')->name('combustibles.pedido.index2');
    Route::get('combustibles/pedido/create', 'CompraCombController@create')->name('combustibles.pedido.create');
    Route::post('combustibles/pedido/store', 'CompraCombController@store')->name('combustibles.pedido.store');
    Route::get('combustibles/pedido/edit/{id}', 'CompraCombController@edit')->name('combustibles.pedido.edit');
    Route::get('combustibles/pedido/editar/{id}', 'CompraCombController@editar')->name('combustibles.pedido.editar');
    Route::post('combustibles/pedido/update', 'CompraCombController@update')->name('combustibles.pedido.update');
    Route::get('combustibles/pedido/editable/{id}', 'CompraCombController@editable')->name('combustibles.pedido.editable');

    Route::post('/ruta5', 'CompraCombController@respuesta5')->name('pregunta5');
    Route::post('/ruta6', 'CompraCombController@respuesta6')->name('pregunta6');



    Route::get('combustibles/pedidoparcial/index', 'CompraCombController2@index')
    ->name('combustibles.pedidoparcial.index');

    Route::get('combustibles/pedidoparcial/index2', 'CompraCombController2@index2')
    ->name('combustibles.pedidoparcial.index2');

    Route::get('combustibles/pedidoparcial/create', 'CompraCombController2@create')
    ->name('combustibles.pedidoparcial.create');

    Route::post('combustibles/pedidoparcial/store', 'CompraCombController2@store')
    ->name('combustibles.pedidoparcial.store');

    
    Route::post('combustibles/pedidoparcial/update', 'CompraCombController2@update')
    ->name('combustibles.pedidoparcial.update');
    
    Route::get('combustibles/pedidoparcial/editar/{id}', 'CompraCombController2@editar')
    ->name('combustibles.pedidoparcial.editar');

    Route::get('combustibles/pedidoparcial/editable/{id}', 'CompraCombController2@editable')
    ->name('combustibles.pedidoparcial.editable');

     Route::get('combustibles/pedidoparcial/edit/{id}', 'CompraCombController2@edit')
     ->name('combustibles.pedidoparcial.edit');

    Route::post('/ruta4', 'CompraCombController2@respuesta4')->name('pregunta4');



    Route::get('combustibles/detalle/index', 'DetalleCompraCombController@index')->name('combustibles.detalle.index');
    Route::get('combustibles/detalle/index2', 'DetalleCompraCombController@index2')->name('combustibles.detalle.index2');
    Route::post('combustibles/detalle/store', 'DetalleCompraCombController@store')->name('combustibles.detalle.store');
    Route::get('combustibles/detalle/principal/{id}', 'DetalleCompraCombController@crearOrdenxxx')->name('combustibles.detalle.principal');
    Route::post('combustibles/detalle/principal/store', 'DetalleCompraCombController@crearOrden')->name('combustibles.detalle.principal.store');
    Route::get('combustibles/detalle/{id}/principalorden', 'DetalleCompraCombController@crearOrdendocxx')->name('combustibles.detalle.principalorden');
    Route::get('combustibles/detalle/show', 'DetalleCompraCombController@show')->name('combustibles.detalle.show');
    Route::post('combustibles/detalle/principalorden', 'DetalleCompraCombController@crearOrdendoc')->name('DetalleCompraCombController.crearOrdendoc');
    Route::get('combustibles/detalle/{id}/destroyed2', 'DetalleCompraCombController@destroyed2')->name('DetalleCompraCombController.eliminar2');
    Route::get('combustibles/delete/{id}', 'DetalleCompraCombController@delete')->name('combustibles.detalle.delete');
    Route::get('combustibles/aprovar/{id}', 'DetalleCompraCombController@aprovar')->name('combustibles.detalle.aprovar');

    Route::get('combustibles/almacen/{id}', 'DetalleCompraCombController@almacen')->name('combustibles.detalle.almacen');

    Route::get('combustibles/detalle/invitacion/{id}', 'DetalleCompraCombController@invitacion')->name('combustibles.detalle.principal.invitacion');
    Route::get('combustibles/detalle/aceptacion/{id}', 'DetalleCompraCombController@aceptacion')->name('combustibles.detalle.principal.aceptacion');
    Route::get('combustibles/detalle/cotizacion/{id}', 'DetalleCompraCombController@cotizacion')->name('combustibles.detalle.principal.cotizacion');
    Route::get('combustibles/detalle/adjudicacion/{id}', 'DetalleCompraCombController@adjudicacion')->name('combustibles.detalle.principal.adjudicacion');
    Route::get('combustibles/detalle/orden/{id}', 'DetalleCompraCombController@orden')->name('combustibles.detalle.principal.orden');




    

    Route::get('combustibles/detalleparcial/index', 'DetalleCompraCombController2@index')
    ->name('combustibles.detalleparcial.index');

    Route::get('combustibles/detalleparcial/index2', 'DetalleCompraCombController2@index2')
    ->name('combustibles.detalleparcial.index2');

    Route::post('combustibles/detalleparcial/store', 'DetalleCompraCombController2@store')
    ->name('combustibles.detalleparcial.store');

    Route::get('combustibles/detalleparcial/show', 'DetalleCompraCombController2@show')
    ->name('combustibles.detalleparcial.show');

    Route::get('combustibles/detalleparcial/{id}/destroyed2', 'DetalleCompraCombController2@destroyed2')
    ->name('DetalleCompraController2.eliminar2');

    Route::get('combustibles/delete2/{id}', 'DetalleCompraCombController2@delete')
    ->name('combustibles.detalleparcial.delete');



});   

Route::group(['namespace' => 'App\Http\Controllers\Transporte'], function() {

    Route::get('transportes/uconsumo/index', 'UnidaddConsumoController@index')->name('transportes.uconsumo.index');
Route::get('transportes/uconsumo/index2', 'UnidaddConsumoController@index2')->name('transportes.uconsumo.index2');
Route::get('transportes/uconsumo/editar/{id}', 'UnidaddConsumoController@editar')->name('transportes.uconsumo.editar');

Route::POST('transportes/uconsumo/update', 'UnidaddConsumoController@update')->name('transportes.uconsumo.update');
Route::get('transportes/uconsumo/create', 'UnidaddConsumoController@create')->name('transportes.uconsumo.create');
Route::POST('transportes/uconsumo/store', 'UnidaddConsumoController@store')->name('transportes.uconsumo.store');

Route::get('transportes/uconsumo/{id}/editardoc', ['uses' => 'UnidaddConsumoController@editardoc','as' => 'uconsumo.editdoc']);
Route::get('transportes/uconsumo/{id}/createdocuconsumo', 'UnidaddConsumoController@createdoc')->name('UnidaddConsumoController.createdoc');
Route::POST('transportes/uconsumo/insertar', 'UnidaddConsumoController@insertar')->name('UnidaddConsumoController.insertar');
Route::get('transportes/uconsumo/aprovar/{id}', 'UnidaddConsumoController@aprovar')
    ->name('transportes.uconsumo.aprovar');

  
    
    Route::get('transportes/tipo/index', 'TipomovilidadController@index')->name('tipo.index')->middleware('can:tipomovilidad_access');
    Route::get('transportes/tipo/list', 'TipomovilidadController@listado')->name('tipo.list')->middleware('can:tipomovilidad_access');
    Route::get('transportes/tipo/{id}/edit', 'TipomovilidadController@editar')->name('tipo.edit')->middleware('can:tipomovilidad_access');
    Route::POST('transportes/tipo/{id}/update', 'TipomovilidadController@update')->name('tipo.update')->middleware('can:tipomovilidad_access');
    Route::get('transportes/tipo/create', 'TipomovilidadController@create')->name('tipo.create')->middleware('can:tipomovilidad_access');
    Route::POST('transportes/tipo/store', 'TipomovilidadController@store')->name('tipo.store')->middleware('can:tipomovilidad_access');
       


    Route::get('transportes/pedido/index', 'SoluconsumoController@index')
    ->name('transportes.pedido.index');
    Route::get('transportes/pedido/index2', 'SoluconsumoController@index2')
    ->name('transportes.pedido.index2');
    Route::get('transportes/pedido/index3', 'SoluconsumoController@index3')
    ->name('transportes.pedido.index3');

    Route::get('transportes/pedido/index4', 'SoluconsumoController@index4')
    ->name('transportes.pedido.index4');

    Route::get('transportes/pedido/editar/{id}', 'SoluconsumoController@editar')->name('transportes.pedido.editar');
    Route::POST('transportes/pedido/update', 'SoluconsumoController@update')->name('transportes.pedido.update');
    Route::get('transportes/pedido/edit/{id}', 'SoluconsumoController@edit')->name('transportes.pedido.edit');
    Route::get('transportes/pedido/editable/{id}', 'SoluconsumoController@editable')->name('transportes.pedido.editable');
    
    Route::get('transportes/pedido/aprovar/{id}', 'SoluconsumoController@aprovar')
    ->name('transportes.pedido.aprovar');

    
    Route::get('transportes/pedidoparcial/index', 'SoluconsumoController2@index')
    ->name('transportes.pedidoparcial.index');

    Route::get('transportes/pedidoparcial/index2', 'SoluconsumoController2@index2')
    ->name('transportes.pedidoparcial.index2');
    
    Route::get('transportes/pedidoparcial/index3', 'SoluconsumoController2@index3')
    ->name('transportes.pedidoparcial.index3');
    

    Route::get('transportes/pedidoparcial/create', 'SoluconsumoController2@create')
    ->name('transportes.pedidoparcial.create');
    
    Route::post('transportes/pedidoparcial/store', 'SoluconsumoController2@store')
    ->name('transportes.pedidoparcial.store');
    
    Route::get('transportes/pedidoparcial/editar/{id}', 'SoluconsumoController2@editar')->name('transportes.pedidoparcial.editar');
    Route::POST('transportes/pedidoparcial/update', 'SoluconsumoController2@update')->name('transportes.pedidoparcial.update');
    
    Route::GET('transportes/pedidoparcial/pdf', 'SoluconsumoController2@pdf')->name('transportes.pedidoparcial.pdf');
    
    Route::get('transportes/pedidoparcial/solicitud/{id}', 'SoluconsumoController2@solicitud')->name('transportes.pedidoparcial.solicitud');
    
    
    Route::post('/ruta7', 'SoluconsumoController2@respuesta7')->name('pregunta7');
    
    
    Route::get('transportes/detalle/index', 'DetalleSoluconsumoController@index')
    ->name('transportes.detalle.index');
    
    Route::get('transportes/detalle/index2', 'DetalleSoluconsumoController@index2')
    ->name('transportes.detalle.index2');
    
    Route::post('transportes/detalle/store', 'DetalleSoluconsumoController@store')
    ->name('transportes.detalle.store');
    
    Route::get('transportes/delete2/{id}', 'DetalleSoluconsumoController@delete')
        ->name('transportes.detalle.delete');
    
    Route::get('transportes/detalle/aprovar/{id}', 'DetalleSoluconsumoController@aprovar')
        ->name('transportes.detalle.aprovar');
    

});   


Route::group(['namespace' => 'App\Http\Controllers\Almacen'], function() {
Route::get('almacenes/localidad/index', 'LocalidadController@index')->name('localidad.index');
Route::get('almacenes/localidad/list', 'LocalidadController@listado')->name('localidad.list');
Route::get('almacenes/localidad/{id}/edit', 'LocalidadController@editar')->name('localidad.edit');
Route::POST('almacenes/localidad/{id}/update', 'LocalidadController@update')->name('localidad.update');
Route::get('almacenes/localidad/create', 'LocalidadController@create')->name('localidad.create');
Route::POST('almacenes/localidad/store', 'LocalidadController@store')->name('localidad.store');


Route::get('almacenes/pedido/index', 'ValeController@index')->name('almacenes.pedido.index');
Route::get('almacenes/pedido/index2', 'ValeController@index2')->name('almacenes.pedido.index2');
Route::get('almacenes/pedido/index3', 'ValeController@index3')->name('almacenes.pedido.index3');

Route::get('almacenes/pedido/create', 'ValeController@create')->name('almacenes.pedido.create');
Route::post('almacenes/pedido/store', 'ValeController@store')->name('almacenes.pedido.store');
Route::get('almacenes/pedido/edit/{id}', 'ValeController@edit')->name('almacenes.pedido.edit');
 Route::get('almacenes/pedido/editar/{id}', 'ValeController@editar')->name('almacenes.pedido.editar');
Route::post('almacenes/pedido/update', 'ValeController@update')->name('almacenes.pedido.update');
Route::get('almacenes/pedido/editable/{id}', 'ValeController@editable')->name('almacenes.pedido.editable');
Route::get('almacenes/pedido/editabletres/{id}', 'ValeController@editabletres')->name('almacenes.pedido.editabletres');


Route::get('almacenes/detalle/index', 'DetalleValeController@index')->name('almacenes.detalle.index');
Route::get('almacenes/detalle/index2', 'DetalleValeController@index2')->name('almacenes.detalle.index2');
Route::get('almacenes/detalle/index3', 'DetalleValeController@index3')->name('almacenes.detalle.index3');

Route::post('almacenes/detalle/store', 'DetalleValeController@store')->name('almacenes.detalle.store');
Route::get('almacenes/detalle/principal/{id}', 'DetalleValeController@crearOrdenxxx')->name('almacenes.detalle.principal');
Route::post('almacenes/detalle/principal/store', 'DetalleValeController@crearOrden')->name('almacenes.detalle.principal.store');
//Route::post('combustibles/detalle/principalorden', 'DetalleValeController@crearOrdendoc')->name('DetalleValeController.crearOrdendoc');
//Route::get('combustibles/detalle/{id}/destroyed2', 'DetalleValeController@destroyed2')->name('DetalleValeController.eliminar2');
Route::get('almacenes/detalle/aprovar/{id}', 'DetalleValeController@aprovar')->name('almacenes.detalle.aprovar');
Route::get('almacenes/detalle/solicitud/{id}', 'DetalleValeController@solicitud')->name('almacenes.detalle.solicitud');

Route::get('almacenes/detalle/delete/{id}', 'DetalleValeController@delete')->name('almacenes.detalle.delete');
Route::get('almacenes/detalle/editar/{id}', 'DetalleValeController@editar')->name('almacenes.detalle.editar');

Route::POST('almacenes/detalle/update', 'DetalleValeController@update')->name('almacenes.detalle.update');

});  

Route::group(['namespace' => 'App\Http\Controllers\Almacen\Ingreso'], function() {

    
 Route::get('almacenes/ingreso/index', 'IngresoController@index')
 ->name('almacenes.ingreso.index');
 
 Route::get('almacenes/ingreso/{id}/editardoc', ['uses' => 'IngresoController@editardoc','as' => 'ingreso.editdoc']);
 Route::get('almacenes/ingreso/{id}/createdocuconsumo', 'IngresoController@createdoc')->name('IngresoController.createdoc');
 Route::POST('almacenes/ingreso/insertar', 'IngresoController@insertar')->name('IngresoController.insertar');
 Route::get('almacenes/ingreso/grafico', 'IngresoController@grafico')->name('almacenes.ingreso.grafico')->middleware('can:combustibles_access');
 
 Route::get('almacenes/ingreso/detalle/{id}', 'IngresoController@detalle')->name('almacenes.ingreso.detalle');
 Route::get('almacenes/ingreso/solicitud/{id}', 'IngresoController@solicitud')->name('almacenes.ingreso.solicitud');
 
 Route::get('almacenes/ingreso/reporte', 'IngresoController@reporte')->name('almacenes.ingreso.reporte');
 Route::post('almacenes/ingreso/store2', 'IngresoController@store2')->name('almacenes.ingreso.store2');
 
 Route::get('almacenes/reporte/index', 'ReporteAreasController@index')
 ->name('almacenes.reporte.index');
 
 Route::post('almacenes/reporte/store', 'ReporteAreasController@store')
 ->name('almacenes.reporte.store');
});  