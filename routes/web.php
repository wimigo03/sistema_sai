<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\MedidaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\CompraController2;
use App\Http\Controllers\DetalleCompraController;
use App\Http\Controllers\DetalleCompraController2;
use App\Http\Controllers\PartidaController;
use App\Http\Controllers\ProdServController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\PlantaController;
use App\Http\Controllers\ContratoController;
//use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\CatProgController;
use App\Http\Controllers\ActivosController;
use App\Http\Controllers\CanastaEntregaController;
use App\Http\Controllers\ActivosVsiafController;
use App\Http\Controllers\ArchivosController;
use App\Http\Controllers\ArchivosController2;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\RecepcionController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ControllerCalendar;
use App\Http\Controllers\Recepcion2Controller;
use App\Http\Controllers\ControllerEvent2;
use App\Http\Controllers\ControllerEvent;
use App\Http\Controllers\CanastaBeneficiariosController;
use App\Http\Controllers\ExpoController;
use App\Http\Controllers\Fexpo\SolicitudController;
use App\Http\Controllers\Personerias\PersoneriasController;

/*use App\Http\Controllers\MedidaController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\PrartidaController;
use App\Http\Controllers\ProdServController;
use App\Http\Controllers\DetalleCompraController;*/
use App\Http\Controllers\Activo\ActivoArchivoController;
use App\Http\Controllers\Activo\ActualController;
use App\Http\Controllers\Activo\AdeudoController;
use App\Http\Controllers\Activo\UbicacionController;
use App\Http\Controllers\Activo\FormularioController;
use App\Http\Controllers\Activo\FormularioActivoController;

use App\Http\Controllers\Activo\ReportesController;
use App\Http\Controllers\Activo\CodigoBarrasController;
use App\Http\Controllers\Activo\ImagenesController;
use App\Http\Controllers\Activo\ArchivoAdjuntoController;
use App\Http\Controllers\Activo\OrganismofinController;
use App\Http\Controllers\Activo\AuxiliarController;
use App\Http\Controllers\Activo\EntidadController;
use App\Http\Controllers\Activo\OficinaController;
use App\Http\Controllers\Activo\UnidadAdminController;
use App\Http\Controllers\Activo\CodcontController;
use App\Http\Controllers\Activo\GrupocontController;
use App\Http\Controllers\Activo\CargoController;
use App\Http\Controllers\Activo\CheckListController;
use App\Http\Controllers\Activo\FiltrosController;
use App\Http\Controllers\Activo\ResponsableActivoController;
use App\Http\Controllers\Activo\ResponsableArchivoController;
use App\Http\Controllers\Activo\ResponsableController;
use App\Http\Controllers\Activo\ResponsableImagenController;
use App\Http\Controllers\Activo\UbicacionesController;
use App\Http\Controllers\Activo\VehiculoController;

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

/*Route::get('/', function () {
    return view('/auth/login');
});*/

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');

Route::middleware(['auth'])->group(function () {
    Route::group(['name' => 'admin.'], function () {
        Route::get('admin/', 'Admin\HomeController@index')->name('home');
        //Route::get('admin/roles/index', 'Admin\RoleController@index')->name('roles.index');
        //Route::get('admin/roles/create', 'Admin\RoleController@create')->name('roles.create');
    });
    //Route::get('/', [HomeController::class, 'index'])->name('home');
    /*Route::get('admin/users/index', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('admin/users/search', [UserController::class, 'search'])->name('admin.users.search');
    Route::get('admin/users/excel', [UserController::class, 'excel'])->name('admin.users.excel');
    Route::get('admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('admin/users/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('admin/users/edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('admin/users/update', [UserController::class, 'update'])->name('admin.users.update');
    Route::get('admin/users/baja/{id}', [UserController::class, 'baja'])->name('admin.users.baja');
    Route::get('admin/users/alta/{id}', [UserController::class, 'alta'])->name('admin.users.alta');*/

    Route::get('/compras/medidas/create', [MedidaController::class, 'create'])->name('medidas.create');

    Route::get('rechumanos/planta/lista2', [PlantaController::class, 'detallePlanta'])->name('planta.listageneral');
    Route::get('rechumanos/planta/lista2/show/{id}', [PlantaController::class, 'detallePlantaShow'])->name('planta.listageneral.show');
});

Auth::routes();





Route::middleware(['auth'])->group(function () {
    //Route::get('/', [HomeController::class, 'index'])->name('home');

//////////////////////////////////////  MEDIDAS  ////////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('compras/medidas/index', [MedidaController::class,'index'])->name('medidas.index')->middleware('can:medidas_access');
    Route::get('compras/medidas/list', [MedidaController::class,'listado'])->name('medidas.list');
    Route::get('compras/medidas/{id}/edit', [MedidaController::class,'editar'])->name('medidas.edit');
    Route::post('compras/medidas/{id}/update', [MedidaController::class,'update'])->name('medidas.update');
    Route::get('compras/medidas/create',[MedidaController::class,'create'])->name('medidas.create');
    Route::post('compras/medidas/store', [MedidaController::class,'store'])->name('medidas.store');


    Route::get('admin/users/baja/{id}', [Admin\UserController::class,'baja'])->name('users.baja');
    Route::get('admin/users/alta/{id}', [Admin\UserController::class,'alta'])->name('users.alta');
    Route::get('admin/users//index', [Admin\UserController::class,'index'])->name('users.index');

/////////////////////////--COMPRAS PEDIDO--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('compras/pedido/index', [CompraController::class,'index'])->name('compras.pedido.index');
Route::get('compras/pedido/index2', [CompraController::class,'index2'])->name('compras.pedido.index2');
Route::get('compras/pedido/create', [CompraController::class,'create'])->name('compras.pedido.create');
Route::post('compras/pedido/store', [CompraController::class,'store'])->name('compras.pedido.store');
Route::get('compras/pedido/edit/{id}', [CompraController::class,'edit'])->name('compras.pedido.edit');
Route::get('compras/pedido/editar/{id}', [CompraController::class,'editar'])->name('compras.pedido.editar');
Route::post('compras/pedido/update', [CompraController::class,'update'])->name('compras.pedido.update');

/////////////////////////--COMPRAS PEDIDO PARCIAL--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*Route::get('compras/pedidoparcial/index', [CompraController2::class,'index'])->name('compras.pedidoparcial.index');
Route::get('compras/pedidoparcial/create', [CompraController2::class,'create'])->name('compras.pedidoparcial.create');
Route::post('compras/pedidoparcial/store', [CompraController2::class,'store'])->name('compras.pedidoparcial.store');
Route::get('compras/pedidoparcial/editar/{id}', [CompraController2::class,'editar'])->name('compras.pedidoparcial.editar');
Route::post('compras/pedidoparcial/update', [CompraController2::class,'update'])->name('compras.pedidoparcial.update');
Route::get('compras/pedidoparcial/edit/{id}', [CompraController2::class,'edit'])->name('compras.pedidoparcial.edit');*/

///////////////////////////////--COMPRAS DETALLE--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('compras/detalle/index', [DetalleCompraController::class,'index'])->name('compras.detalle.index');
Route::post('compras/detalle/store', [DetalleCompraController::class,'store'])->name('compras.detalle.store');
Route::get('compras/detalle/principal/{id}', [DetalleCompraController::class,'crearOrdenxxx'])->name('compras.detalle.principal');
Route::post('compras/detalle/principal/store', [DetalleCompraController::class,'crearOrden'])->name('compras.detalle.principal.store');
Route::get('compras/detalle/{id}/principalorden', [DetalleCompraController::class,'crearOrdendocxx'])->name('compras.detalle.principalorden');
Route::get('compras/detalle/show', [DetalleCompraController::class,'show'])->name('compras.detalle.show');
Route::post('compras/detalle/principalorden', [DetalleCompraController::class,'crearOrdendoc'])->name('DetalleCompraController.crearOrdendoc');
Route::get('compras/detalle/{id}/destroyed2', [DetalleCompraController::class,'destroyed2'])->name('DetalleCompraController.eliminar2');
Route::get('compras/delete/{id}', [DetalleCompraController::class,'delete'])->name('compras.detalle.delete');
Route::get('compras/aprovar/{id}', [DetalleCompraController::class,'aprovar'])->name('compras.detalle.aprovar');

Route::get('compras/detalle/invitacion/{id}', [DetalleCompraController::class,'invitacion'])->name('compras.detalle.principal.invitacion');
Route::get('compras/detalle/aceptacion/{id}', [DetalleCompraController::class,'aceptacion'])->name('compras.detalle.principal.aceptacion');
Route::get('compras/detalle/cotizacion/{id}', [DetalleCompraController::class,'cotizacion'])->name('compras.detalle.principal.cotizacion');
Route::get('compras/detalle/adjudicacion/{id}', [DetalleCompraController::class,'adjudicacion'])->name('compras.detalle.principal.adjudicacion');
Route::get('compras/detalle/orden/{id}', [DetalleCompraController::class,'orden'])->name('compras.detalle.principal.orden');




    ///////////////////////////////--COMPRAS DETALLE PARCIAL--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    Route::get('compras/detalleparcial/index', [DetalleCompraController2::class,'index'])->name('compras.detalleparcial.index');
    Route::post('compras/detalleparcial/store', [DetalleCompraController2::class,'store'])->name('compras.detalleparcial.store');
    Route::get('compras/detalleparcial/principal/{id}', [DetalleCompraController2::class,'crearOrdenxxx'])->name('compras.detalleparcial.principal');
    Route::post('compras/detalleparcial/principal/store', [DetalleCompraController2::class,'crearOrden'])->name('compras.detalleparcial.principal.store');
    Route::get('compras/detalleparcial/{id}/principalorden', [DetalleCompraController2::class,'crearOrdendocxx'])->name('compras.detalleparcial.principalorden');
    Route::get('compras/detalleparcial/show', [DetalleCompraController2::class,'show'])->name('compras.detalleparcial.show');
    Route::post('compras/detalleparcial/principalorden', [DetalleCompraController::class,'crearOrdendoc'])->name('DetalleCompraController2.crearOrdendoc');
    Route::get('compras/detalleparcial/{id}/destroyed2', [DetalleCompraController2::class,'destroyed2'])->name('DetalleCompraController2.eliminar2');
    Route::get('compras/delete2/{id}', [DetalleCompraController2::class,'delete'])->name('compras.detalleparcial.delete');

    Route::get('compras/detalleparcial/invitacion/{id}', [DetalleCompraController2::class,'invitacion'])->name('compras.detalleparcial.principal.invitacion');
    Route::get('compras/detalleparcial/aceptacion/{id}', [DetalleCompraController2::class,'aceptacion'])->name('compras.detalleparcial.principal.aceptacion');
    Route::get('compras/detalleparcial/cotizacion/{id}', [DetalleCompraController2::class,'cotizacion'])->name('compras.detalleparcial.principal.cotizacion');
    Route::get('compras/detalleparcial/adjudicacion/{id}', [DetalleCompraController2::class,'adjudicacion'])->name('compras.detalleparcial.principal.adjudicacion');
    Route::get('compras/detalleparcial/orden/{id}', [DetalleCompraController2::class,'orden'])->name('compras.detalleparcial.principal.orden');

///////////////////////////--COMPRAS PARTIDA--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//dilsonRoute::get('compras/partida/index', [PartidaController::class,'index'])->name('partida.index');
//dilsonRoute::get('compras/partida/listado', [PartidaController::class,'listado'])->name('partida.list');

////////////////////////////--COMPRAS PRODUCTO--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('compras/productos/index', [ProdServController::class,'index'])->name('productos.index');
Route::get('compras/productos/list', [ProdServController::class,'list'])->name('producto.list');
Route::get('compras/productos/{id}/edit', [ProdServController::class,'editar'])->name('productos.edit');
Route::POST('compras/productos/{id}/update', [ProdServController::class,'update'])->name('productos.update');
Route::get('compras/productos/create', [ProdServController::class,'create'])->name('productos.create');
Route::POST('compras/productos/store', [ProdServController::class,'store'])->name('productos.store');

///////////////////////////--EMPLEADOS--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('compras/empleados/index', [EmpleadosController::class,'index'])->name('empleados.index');
Route::get('compras/empleados/list', [EmpleadosController::class,'list'])->name('empleados.list');


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
   Route::get('rechumanos/contrato/index', [ContratoController::class,'index'])->name('contrato.index');
   Route::get('rechumanos/contrato/list', [ContratoController::class,'list'])->name('contrato.list');
   Route::get('rechumanos/contrato/detalle/{id}', [ContratoController::class,'detalle'])->name('contrato_detalle');
   Route::get('rechumanos/contrato/edit/{id}', [ContratoController::class,'edit'])->name('contrato.edit');
   Route::get('rechumanos/contrato/lista/{id}', [ContratoController::class,'lista'])->name('contrato.lista');
   Route::get('rechumanos/contrato/create/{id}', [ContratoController::class,'contratonuevo'])->name('contrato.crear');
   Route::get('rechumanos/contrato/edit/{id}', [ContratoController::class,'editarcontrato'])->name('contrato.editar');
   Route::POST('rechumanos/contrato/guardarcontrato', [ContratoController::class,'guardarcontrato'])->name('contrato.guardar');
   Route::POST('rechumanos/contrato/actualizarcontrato', [ContratoController::class,'actualizarcontrato'])->name('contrato.actualizar');
   Route::GET('rechumanos/contrato/lista2', [ContratoController::class,'detallecontrato'])->name('contrato.listageneral');



    /*COMPRAS PROVEEDORES*/
    /*Route::get('compras/proveedores/index', [ProveedoresController::class,'index'])->name('proveedores.index')->middleware('can:proveedores_access');
    Route::get('compras/proveedores/list', [ProveedoresController::class,'list'])->name('proveedores.list')->middleware('can:proveedores_access');
    Route::get('compras/proveedores/{id}/edit', [ProveedoresController::class,'edit'])->name('proveedores.edit')->middleware('can:proveedores_access');
    Route::POST('compras/proveedores/{id}/update', [ProveedoresController::class,'update'])->name('proveedores.update')->middleware('can:proveedores_access');
    Route::get('compras/proveedores/create', [ProveedoresController::class,'create'])->name('proveedores.create')->middleware('can:proveedores_access');
    Route::POST('compras/proveedores/store', [ProveedoresController::class,'store'])->name('proveedores.store')->middleware('can:proveedores_access');
    Route::get('compras/proveedores/{id}/editardoc', ['uses' => 'ProveedoresController@editardoc','as' => 'Proveedores.editdoc'])->middleware('can:proveedores_access');
    Route::get('compras/proveedores/{id}/createdocproveedor', [ProveedoresController::class,'createdoc'])->name('ProveedoresController.createdoc')->middleware('can:proveedores_access');
    Route::POST('compras/proveedores/insertar', [ProveedoresController::class,'insertar'])->name('ProveedoresController.insertar')->middleware('can:proveedores_access');*/

        /*COMPRAS AREAS*/
        Route::get('compras/areas/index', [AreasController::class,'index'])->name('areas.index')->middleware('can:areas_access');
        Route::get('compras/areas/list', [AreasController::class,'listado'])->name('areas.list')->middleware('can:areas_access');
        Route::get('compras/areas/create', [AreasController::class,'create'])->name('areas.create')->middleware('can:areas_access');
        Route::get('compras/areas/{id}/edit', [AreasController::class,'edit'])->name('areas.edit')->middleware('can:areas_access');
        Route::POST('compras/areas/{id}/update', [AreasController::class,'update'])->name('areas.update')->middleware('can:areas_access');
        Route::POST('compras/areas/store', [AreasController::class,'store'])->name('areas.store')->middleware('can:areas_access');
        Route::get('compras/areas/{id}/file', [AreasController::class,'file'])->name('areas.file')->middleware('can:areas_access');
        Route::get('compras/areas/{id}/crearFile', [AreasController::class,'crearFile'])->name('areas.crearFile')->middleware('can:areas_access');
        Route::POST('compras/areas/guardarfile', [AreasController::class,'guardarfile'])->name('areas.guardarfile')->middleware('can:areas_access');
        Route::get('compras/areas/{id}/actualizarfile', [AreasController::class,'editfile'])->name('file.edit')->middleware('can:areas_access');
        Route::POST('compras/areas/updatefile', [AreasController::class,'updatefile'])->name('file.update')->middleware('can:areas_access');
        Route::get('compras/areas/{id}/file2', [AreasController::class,'file2'])->name('areas.file2')->middleware('can:areas_access');
        Route::get('compras/areas/{id}/crearFile2', [AreasController::class,'crearFile2'])->name('areas.crearFile2')->middleware('can:areas_access');
        Route::POST('compras/areas/guardarfile2', [AreasController::class,'guardarfile2'])->name('areas.guardarfile2')->middleware('can:areas_access');
        Route::get('compras/areas/{id}/actualizarfile2', [AreasController::class,'editfile2'])->name('file2.edit')->middleware('can:areas_access');
        Route::POST('compras/areas/updatefile2', [AreasController::class,'updatefile2'])->name('file2.update')->middleware('can:areas_access');


        //////////////////////////////--COMPRAS PROGRAMAS--////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('compras/programas/index', [ProgramaController::class,'index'])->name('programas.index')->middleware('can:programas_access');
    Route::get('compras/programas/list', [ProgramaController::class,'listado'])->name('programas.list')->middleware('can:programas_access');
    Route::get('compras/programas/{id}/edit', [ProgramaController::class,'edit'])->name('programas.edit')->middleware('can:programas_access');
    Route::POST('compras/programas/{id}/update', [ProgramaController::class,'update'])->name('programas.update')->middleware('can:programas_access');
    Route::get('compras/programas/create', [ProgramaController::class,'create'])->name('programas.create')->middleware('can:programas_access');
    Route::POST('compras/programas/store', [ProgramaController::class,'store'])->name('programas.store')->middleware('can:programas_access');



////////////////////////////////--COMPRAS CATEGORIAS PROGRAMATICAS--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('compras/catprog/index', [CatProgController::class,'index'])->name('catprog.index')->middleware('can:catprog_access');
Route::get('compras/catprog/list', [CatProgController::class,'listado'])->name('catprog.list')->middleware('can:catprog_access');
Route::get('compras/catprog/{id}/edit', [CatProgController::class,'editar'])->name('catprog.edit')->middleware('can:catprog_access');
Route::POST('compras/catprog/{id}/update', [CatProgController::class,'update'])->name('catprog.update')->middleware('can:catprog_access');
Route::get('compras/catprog/create', [CatProgController::class,'create'])->name('catprog.create')->middleware('can:catprog_access');
Route::POST('compras/catprog/store', [CatProgController::class,'store'])->name('catprog.store')->middleware('can:catprog_access');

////////////////////////////////--ACTIVOS FIJOS--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('activosFijos/activos', [ActivosController::class,'index'])->name('activos.index');

  //  Route::get('activosFijos/activos', 'ActivosController@index')->name('activos.index');
  Route::group(['namespace' => 'App\Http\Controllers\Activo'], function () {

    Route::get('Activo/organismo/index', [OrganismofinController::class, 'index'])->name('activo.organismo.index')->middleware('can:organismo_access');
    Route::get('Activo/organismo/list', [OrganismofinController::class, 'listado'])->name('activo.organismo.list')->middleware('can:organismo_access');
    Route::get('Activo/organismo/{id}/edit', [OrganismofinController::class, 'editar'])->name('activo.organismo.edit')->middleware('can:organismo_access');
    Route::POST('Activo/organismo/{id}/update', [OrganismofinController::class, 'update'])->name('activo.organismo.update')->middleware('can:organismo_access');
    Route::get('Activo/organismo/create', [OrganismofinController::class, 'create'])->name('activo.organismo.create')->middleware('can:organismo_access');
    Route::POST('Activo/organismo/store', [OrganismofinController::class, 'store'])->name('activo.organismo.store')->middleware('can:organismo_access');

    Route::get('Activo/auxiliar/index/{id}', [AuxiliarController::class, 'index'])->name('activo.auxiliar.index')->middleware('can:auxiliar_access');
    Route::get('Activo/auxiliar/listado/{id}', [AuxiliarController::class, 'listado'])->name('activo.auxiliar.listado')->middleware('can:auxiliar_access');
    Route::get('Activo/auxiliar/{id}/edit', [AuxiliarController::class, 'editar'])->name('activo.auxiliar.edit')->middleware('can:auxiliar_access');
    Route::POST('Activo/auxiliar/{id}/update', [AuxiliarController::class, 'update'])->name('activo.auxiliar.update')->middleware('can:auxiliar_access');
    Route::get('Activo/auxiliar/create/{id}', [AuxiliarController::class, 'create'])->name('activo.auxiliar.create')->middleware('can:auxiliar_access');
    Route::POST('Activo/auxiliar/store', [AuxiliarController::class, 'store'])->name('activo.auxiliar.store')->middleware('can:auxiliar_access');

    Route::get('Activo/auxiliar/show', [AuxiliarController::class, 'show'])->name('activo.auxiliar.show')->middleware('can:auxiliar_access');



    Route::get('Activo/entidad/index', [EntidadController::class, 'index'])->name('activo.entidad.index')->middleware('can:entidad_access');
    Route::get('Activo/entidad/list', [EntidadController::class, 'listado'])->name('activo.entidad.list')->middleware('can:entidad_access');
    Route::get('Activo/entidad/{id}/edit', [EntidadController::class, 'editar'])->name('activo.entidad.edit')->middleware('can:entidad_access');
    Route::POST('Activo/entidad/{id}/update', [EntidadController::class, 'update'])->name('activo.entidad.update')->middleware('can:entidad_access');
    Route::get('Activo/entidad/create', [EntidadController::class, 'create'])->name('activo.entidad.create')->middleware('can:entidad_access');
    Route::POST('Activo/entidad/store', [EntidadController::class, 'store'])->name('activo.entidad.store')->middleware('can:entidad_access');

    Route::get('Activo/unidadadmin/index', [UnidadAdminController::class, 'index'])->name('activo.unidadadmin.index')->middleware('can:unidadadmin_access');
    Route::get('Activo/unidadadmin/list', [UnidadAdminController::class, 'listado'])->name('activo.unidadadmin.list')->middleware('can:unidadadmin_access');
    Route::get('Activo/unidadadmin/{id}/edit', [UnidadAdminController::class, 'editar'])->name('activo.unidadadmin.edit')->middleware('can:unidadadmin_access');
    Route::POST('Activo/unidadadmin/{id}/update', [UnidadAdminController::class, 'update'])->name('activo.unidadadmin.update')->middleware('can:unidadadmin_access');
    Route::get('Activo/unidadadmin/create', [UnidadAdminController::class, 'create'])->name('activo.unidadadmin.create')->middleware('can:unidadadmin_access');
    Route::POST('Activo/unidadadmin/store', [UnidadAdminController::class, 'store'])->name('activo.unidadadmin.store')->middleware('can:unidadadmin_access');
    Route::put('Activo/unidadadmin/{id}/estado', [UnidadAdminController::class, 'estado'])->name('activo.unidadadmin.estado')->middleware('can:unidadadmin_access');

    Route::get('Activo/oficina/', [OficinaController::class, 'index'])->name('oficina.index');
    Route::get('Activo/oficina/list', [OficinaController::class, 'list'])->name('oficina.list');
    Route::get('Activo/oficina/detalle/{id}', [OficinaController::class, 'detalle'])->name('detalle');
    // Puedes descomentar la siguiente ruta si necesitas usarla
    // Route::get('oficina/contratonuevo/{id}', [OficinaController::class, 'contratonuevo'])->name('activo.oficina_contratonuevo');
    Route::get('Activo/oficina/lista/{idarea}', [OficinaController::class, 'lista'])->name('activo.oficina.lista');


    // Filtros
    Route::get('Activo/reportes/filtroUnidad', [FiltrosController::class, 'filtroUnidad'])->name('activo.filtros.unidad');
    Route::get('Activo/reportes/filtroTodos', [FiltrosController::class, 'filtroTodos'])->name('activo.filtros.todos');

    // Route::get('Activo/oficina', [OficinaController::class, 'index'])->name('activo.oficina.index');
    // Route::get('Activo/oficina/list', [OficinaController::class, 'list'])->name('activo.oficina.list');
    // Route::get('Activo/oficina/{idarea}/responsables', [OficinaController::class, 'responsables'])->name('oficina.responsables');
    // Route::post('Activo/oficina/{idarea}/guardar-responsable', [OficinaController::class, 'guardarResponsable'])->name('oficina.guardar_responsable');



    //         // Rutas existentes para 'oficina'
    // Route::get('Activo/oficina/index', [OficinaController::class,'index'])->name('activo.oficina.index')->middleware('can:oficina_access');
    // Route::get('Activo/oficina/list', [OficinaController::class,'listado'])->name('activo.oficina.list')->middleware('can:oficina_access');
    // Route::get('Activo/oficina/{id}/edit', [OficinaController::class,'editar'])->name('activo.oficina.edit')->middleware('can:oficina_access');
    // Route::POST('Activo/oficina/{id}/update', [OficinaController::class,'update'])->name('activo.oficina.update')->middleware('can:oficina_access');
    Route::get('Activo/oficina/create/{id}', [OficinaController::class, 'create'])->name('activo.oficina.create')->middleware('can:oficina_access');
    // Route::POST('Activo/oficina/store', [OficinaController::class,'store'])->name('activo.oficina.store')->middleware('can:oficina_access');
    // Route::get('Activo/oficina/{idarea}/crear-responsable', [OficinaController::class,'crearResponsable'])->name('activo.oficina.crearResponsable');
    // Route::post('Activo/oficina/guardar-responsable', [OficinaController::class,'guardarResponsable'])->name('activo.oficina.guardarResponsable');



    // Activos del responsable
    Route::get('Activo/responsable/index/{id}/activo', [ResponsableActivoController::class, 'index'])->name('activo.responsable.activo.index')->middleware('can:oficina_access');
    Route::get('Activo/responsable/search/{id}/activo', [ResponsableActivoController::class, 'search'])->name('activo.responsable.activo.search')->middleware('can:oficina_access');
    Route::get('Activo/responsable/listado/{id}/activo', [ResponsableActivoController::class, 'listado'])->name('activo.responsable.activo.listado')->middleware('can:oficina_access');
    Route::POST('Activo/responsable/update/activo', [ResponsableActivoController::class, 'update'])->name('activo.responsable.activo.update')->middleware('can:oficina_access');
    // Archivos del responsable
    Route::get('Activo/responsable/index/{id}/archivos', [ResponsableArchivoController::class, 'index'])->name('activo.responsable.archivos.index')->middleware('can:oficina_access');
    Route::get('Activo/responsable/listado/{id}/archivos', [ResponsableArchivoController::class, 'listado'])->name('activo.responsable.archivos.listado')->middleware('can:oficina_access');
    Route::POST('Activo/responsable/store/archivos', [ResponsableArchivoController::class, 'store'])->name('activo.responsable.archivos.store')->middleware('can:oficina_access');
    Route::POST('Activo/responsable/update/{id}/archivos', [ResponsableArchivoController::class, 'update'])->name('activo.responsable.archivos.update')->middleware('can:oficina_access');
    // Imagenes del responsable
    Route::get('Activo/responsable/index/{id}/imagen', [ResponsableImagenController::class, 'index'])->name('activo.responsable.imagen.index')->middleware('can:oficina_access');
    Route::get('Activo/responsable/listado/{id}/imagen', [ResponsableImagenController::class, 'listado'])->name('activo.responsable.imagen.listado')->middleware('can:oficina_access');
    Route::POST('Activo/responsable/store/imagen', [ResponsableImagenController::class, 'store'])->name('activo.responsable.imagen.store')->middleware('can:oficina_access');
    Route::POST('Activo/responsable/update/{id}/imagen', [ResponsableImagenController::class, 'update'])->name('activo.responsable.imagen.update')->middleware('can:oficina_access');
    // Archivos del activo
    Route::get('Activo/index/{id}/archivo', [ActivoArchivoController::class, 'index'])->name('activo.archivo.index')->middleware('can:oficina_access');
    Route::get('Activo/listado/{id}/archivo', [ActivoArchivoController::class, 'listado'])->name('activo.archivo.listado')->middleware('can:oficina_access');
    Route::POST('Activo/store/archivo', [ActivoArchivoController::class, 'store'])->name('activo.archivo.store')->middleware('can:oficina_access');
    Route::POST('Activo/update/{id}/archivo', [ActivoArchivoController::class, 'update'])->name('activo.archivo.update')->middleware('can:oficina_access');
    // Ubicaciones Activos
    Route::get('Activo/ubicaciones/index/{id}', [UbicacionesController::class, 'index'])->name('activo.ubicaciones.index')->middleware('can:oficina_access');
    Route::get('Activo/ubicaciones/listado/{id}', [UbicacionesController::class, 'listado'])->name('activo.ubicaciones.listado')->middleware('can:oficina_access');


    Route::get('Activo/responsable/index/{id}', [ResponsableController::class, 'index'])->name('activo.responsable.index')->middleware('can:oficina_access');
    Route::get('Activo/responsable/listado/{id}', [ResponsableController::class, 'listado'])->name('activo.responsable.listado')->middleware('can:oficina_access');
    Route::get('Activo/responsable/{id}/edit', [ResponsableController::class, 'editar'])->name('activo.responsable.edit')->middleware('can:oficina_access');
    Route::POST('Activo/responsable/{id}/update', [ResponsableController::class, 'update'])->name('activo.responsable.update')->middleware('can:oficina_access');
    Route::get('Activo/responsable/create/{id}', [ResponsableController::class, 'create'])->name('activo.responsable.create')->middleware('can:oficina_access');
    Route::POST('Activo/responsable/store', [ResponsableController::class, 'store'])->name('activo.responsable.store')->middleware('can:oficina_access');




    Route::get('Activo/ubicacion/index', [UbicacionController::class, 'index'])->name('activo.ubicacion.index')->middleware('can:ubicacion_access');
    Route::get('Activo/ubicacion/list', [UbicacionController::class, 'listado'])->name('activo.ubicacion.list')->middleware('can:ubicacion_access');
    Route::get('Activo/ubicacion/{id}/edit', [UbicacionController::class, 'editar'])->name('activo.ubicacion.edit')->middleware('can:ubicacion_access');
    Route::POST('Activo/ubicacion/{id}/update', [UbicacionController::class, 'update'])->name('activo.ubicacion.update')->middleware('can:ubicacion_access');
    Route::get('Activo/ubicacion/create', [UbicacionController::class, 'create'])->name('activo.ubicacion.create')->middleware('can:ubicacion_access');
    Route::POST('Activo/ubicacion/store', [UbicacionController::class, 'store'])->name('activo.ubicacion.store')->middleware('can:ubicacion_access');


    Route::get('Activo/codcont/index', [CodcontController::class, 'index'])->name('activo.codcont.index')->middleware('can:codcont_access');
    Route::get('Activo/codcont/list', [CodcontController::class, 'listado'])->name('activo.codcont.list')->middleware('can:codcont_access');
    Route::get('Activo/codcont/{id}/edit', [CodcontController::class, 'editar'])->name('activo.codcont.edit')->middleware('can:codcont_access');
    Route::POST('Activo/codcont/{id}/update', [CodcontController::class, 'update'])->name('activo.codcont.update')->middleware('can:codcont_access');
    Route::get('Activo/codcont/create', [CodcontController::class, 'create'])->name('activo.codcont.create')->middleware('can:codcont_access');
    Route::POST('Activo/codcont/store', [CodcontController::class, 'store'])->name('activo.codcont.store')->middleware('can:codcont_access');
    Route::get('Activo/codcont/show/{id}', [CodcontController::class, 'show'])->name('activo.codcont.show')->middleware('can:codcont_access');

    Route::get('Activo/gruposcont/index', [GrupocontController::class, 'index'])->name('activo.gruposcont.index')->middleware('can:gruposcont_access');
    Route::get('Activo/gruposcont/list', [GrupocontController::class, 'listado'])->name('activo.gruposcont.list')->middleware('can:gruposcont_access');
    Route::get('Activo/gruposcont/{id}/edit', [GrupocontController::class, 'editar'])->name('activo.gruposcont.edit')->middleware('can:gruposcont_access');
    Route::POST('Activo/gruposcont/{id}/update', [GrupocontController::class, 'update'])->name('activo.gruposcont.update')->middleware('can:gruposcont_access');
    Route::get('Activo/gruposcont/create', [GrupocontController::class, 'create'])->name('activo.gruposcont.create')->middleware('can:gruposcont_access');
    Route::POST('Activo/gruposcont/store', [GrupocontController::class, 'store'])->name('activo.gruposcont.store')->middleware('can:gruposcont_access');


    Route::get('Activo/cargo/index', [CargoController::class, 'index'])->name('activo.cargo.index')->middleware('can:cargo_access');
    Route::get('Activo/cargo/list', [CargoController::class, 'listado'])->name('activo.cargo.list')->middleware('can:cargo_access');
    Route::get('Activo/cargo/{id}/edit', [CargoController::class, 'editar'])->name('activo.cargo.edit')->middleware('can:cargo_access');
    Route::POST('Activo/cargo/{id}/update', [CargoController::class, 'update'])->name('activo.cargo.update')->middleware('can:cargo_access');
    Route::get('Activo/cargo/create', [CargoController::class, 'create'])->name('activo.cargo.create')->middleware('can:cargo_access');
    Route::POST('Activo/cargo/store', [CargoController::class, 'store'])->name('activo.cargo.store')->middleware('can:cargo_access');


    Route::get('Activo/imagenes/index', [ImagenesController::class, 'index'])->name('activo.imagenes.index')->middleware('can:imagen_access');
    Route::get('Activo/imagenes/list', [ImagenesController::class, 'listado'])->name('activo.imagenes.list')->middleware('can:imagen_access');
    Route::get('Activo/imagenes/{id}/edit', [ImagenesController::class, 'editar'])->name('activo.imagenes.edit')->middleware('can:imagen_access');
    Route::POST('Activo/imagenes/{id}/update', [ImagenesController::class, 'update'])->name('activo.imagenes.update')->middleware('can:imagen_access');
    Route::get('Activo/imagenes/create', [ImagenesController::class, 'create'])->name('activo.imagenes.create')->middleware('can:imagen_access');
    Route::POST('Activo/imagenes\store', [ImagenesController::class, 'store'])->name('activo.imagenes.store')->middleware('can:imagen_access');

    Route::get('Activo/archivoadjunto/index', [ArchivoAdjuntoController::class, 'index'])->name('activo.archivoadjunto.index')->middleware('can:archivoadjunto_access');
    Route::get('Activo/archivoadjunto/list', [ArchivoAdjuntoController::class, 'listado'])->name('activo.archivoadjunto.list')->middleware('can:archivoadjunto_access');
    Route::get('Activo/archivoadjunto/{id}/edit', [ArchivoAdjuntoController::class, 'editar'])->name('activo.archivoadjunto.edit')->middleware('can:archivoadjunto_access');
    Route::POST('Activo/archivoadjunto/{id}/update', [ArchivoAdjuntoController::class, 'update'])->name('activo.archivoadjunto.update')->middleware('can:archivoadjunto_access');
    Route::get('Activo/archivoadjunto/create', [ArchivoAdjuntoController::class, 'create'])->name('activo.archivoadjunto.create')->middleware('can:archivoadjunto_access');
    Route::POST('Activo/arcchivoadjunto\store', [ArchivoAdjuntoController::class, 'store'])->name('activo.archivoadjunto.store')->middleware('can:archivoadjunto_access');


    Route::get('Activo/gestionactivo/index', [ActualController::class, 'index'])->name('activo.gestionactivo.index')->middleware('can:actual_access');
    Route::get('Activo/gestionactivo/search', [ActualController::class, 'search'])->name('activo.gestionactivo.search')->middleware('can:actual_access');
    Route::get('Activo/gestionactivo/list', [ActualController::class, 'listado'])->name('activo.gestionactivo.list')->middleware('can:actual_access');
    Route::get('Activo/gestionactivo/{id}/edit', [ActualController::class, 'editar'])->name('activo.gestionactivo.edit')->middleware('can:actual_access');
    Route::get('Activo/gestionactivo/{id}/show', [ActualController::class, 'show'])->name('activo.gestionactivo.show')->middleware('can:actual_access');
    Route::POST('Activo/gestionactivo/{id}/update', [ActualController::class, 'update'])->name('activo.gestionactivo.update')->middleware('can:actual_access');
    Route::get('Activo/gestionactivo/create', [ActualController::class, 'create'])->name('activo.gestionactivo.create')->middleware('can:actual_access');
    Route::POST('Activo/gestionactivo\store', [ActualController::class, 'store'])->name('activo.gestionactivo.store')->middleware('can:actual_access');
    Route::get('/gestionactivo/getAuxiliar', [ActualController::class, 'getAuxiliar'])->name('activo.gestionactivo.getAuxiliar');
    Route::get('/gestionactivo/getLastAuxiliar', [ActualController::class, 'getLastAuxiliar'])->name('activo.gestionactivo.getLastAuxiliar');
    Route::get('/gestionactivo/getResponsables', [ActualController::class, 'getResponsables'])->name('activo.gestionactivo.getResponsables');
    Route::get('/gestionactivo/getCargo', [ActualController::class, 'getCargo'])->name('activo.gestionactivo.getCargo');

    // VEHICULO
    Route::get('Activo/vehiculo/index', [VehiculoController::class, 'index'])->name('activo.vehiculo.index')->middleware('can:actual_access');
    Route::get('Activo/vehiculo/search', [VehiculoController::class, 'search'])->name('activo.vehiculo.search')->middleware('can:actual_access');
    Route::get('Activo/vehiculo/list', [VehiculoController::class, 'listado'])->name('activo.vehiculo.list')->middleware('can:actual_access');
    Route::get('Activo/vehiculo/{id}/edit', [VehiculoController::class, 'editar'])->name('activo.vehiculo.edit')->middleware('can:actual_access');
    Route::get('Activo/vehiculo/{id}/show', [VehiculoController::class, 'show'])->name('activo.vehiculo.show')->middleware('can:actual_access');
    Route::POST('Activo/vehiculo/{id}/update', [VehiculoController::class, 'update'])->name('activo.vehiculo.update')->middleware('can:actual_access');
    Route::get('Activo/vehiculo/create', [VehiculoController::class, 'create'])->name('activo.vehiculo.create')->middleware('can:actual_access');
    Route::POST('Activo/vehiculo\store', [VehiculoController::class, 'store'])->name('activo.vehiculo.store')->middleware('can:actual_access');
    Route::get('/Activo/vehiculo/getCodigo', [VehiculoController::class, 'getCodigo'])->name('activo.vehiculo.getCodigo')->middleware('can:actual_access');

    // CHECKLIST
    Route::get('Activo/index/{id}/checklist', [CheckListController::class, 'index'])->name('vehiculo.checklist.index')->middleware('can:oficina_access');
    Route::get('Activo/listado/{id}/checklist', [CheckListController::class, 'listado'])->name('vehiculo.checklist.listado')->middleware('can:oficina_access');
    Route::POST('Activo/store/checklist', [CheckListController::class, 'store'])->name('vehiculo.checklist.store')->middleware('can:oficina_access');
    Route::POST('Activo/update/{id}/checklist', [CheckListController::class, 'update'])->name('vehiculo.checklist.update')->middleware('can:oficina_access');

    // NO ADEUDO
    Route::get('Activo/adeudo/index', [AdeudoController::class, 'index'])->name('activo.adeudo.index')->middleware('can:actual_access');
    Route::get('Activo/adeudo/search', [AdeudoController::class, 'search'])->name('activo.adeudo.search')->middleware('can:actual_access');
    Route::get('Activo/adeudo/list', [AdeudoController::class, 'listado'])->name('activo.adeudo.list')->middleware('can:actual_access');
    Route::get('Activo/adeudo/{id}/edit', [AdeudoController::class, 'editar'])->name('activo.adeudo.edit')->middleware('can:actual_access');
    Route::get('Activo/adeudo/{id}/show', [AdeudoController::class, 'show'])->name('activo.adeudo.show')->middleware('can:actual_access');
    Route::POST('Activo/adeudo/{id}/update', [AdeudoController::class, 'update'])->name('activo.adeudo.update')->middleware('can:actual_access');
    Route::get('Activo/adeudo/create', [AdeudoController::class, 'create'])->name('activo.adeudo.create')->middleware('can:actual_access');
    Route::POST('Activo/adeudo/store', [AdeudoController::class, 'store'])->name('activo.adeudo.store')->middleware('can:actual_access');
    Route::get('/Activo/adeudo/getCi', [AdeudoController::class, 'getCi'])->name('activo.adeudo.getCi')->middleware('can:actual_access');


        // FORMULARIO
        Route::get('Activo/formulario/index', [FormularioController::class, 'index'])->name('activo.formulario.index')->middleware('can:actual_access');
        Route::get('Activo/formulario/search', [FormularioController::class, 'search'])->name('activo.formulario.search')->middleware('can:actual_access');
        Route::get('Activo/formulario/list', [FormularioController::class, 'listado'])->name('activo.formulario.list')->middleware('can:actual_access');
        Route::get('Activo/formulario/{id}/edit', [FormularioController::class, 'editar'])->name('activo.formulario.edit')->middleware('can:actual_access');
        Route::get('Activo/formulario/{id}/show', [FormularioController::class, 'show'])->name('activo.formulario.show')->middleware('can:actual_access');
        Route::POST('Activo/formulario/{id}/update', [FormularioController::class, 'update'])->name('activo.formulario.update')->middleware('can:actual_access');
        Route::get('Activo/formulario/create', [FormularioController::class, 'create'])->name('activo.formulario.create')->middleware('can:actual_access');
        Route::POST('Activo/formulario/store', [FormularioController::class, 'store'])->name('activo.formulario.store')->middleware('can:actual_access');
        Route::get('/Activo/formulario/getCi', [FormularioController::class, 'getEmleadoByCi'])->name('activo.formulario.getCi')->middleware('can:actual_access');
        // Activos del formulario
        Route::get('Activo/listado/{id}/formulario', [FormularioActivoController::class, 'listado'])->name('activo.formulario.activo.listado')->middleware('can:oficina_access');
        Route::POST('Activo/store/formulario', [FormularioActivoController::class, 'store'])->name('activo.formulario.activo.store')->middleware('can:oficina_access');
        Route::POST('Activo/update/{id}/formulario', [FormularioActivoController::class, 'update'])->name('activo.formulario.activo.update')->middleware('can:oficina_access');
        Route::POST('Activo/destroy/{id}/formulario', [FormularioActivoController::class, 'destroy'])->name('activo.formulario.activo.destroy')->middleware('can:oficina_access');

    Route::get('/reportes/rep1-pdf', [ReportesController::class, 'reporte1Pdf'])->name('rep1.pdf');
    Route::get('/reportes/rep2-pdf', [ReportesController::class, 'reporte2Pdf'])->name('rep2.pdf');
    Route::get('/reportes/rep3-pdf', [ReportesController::class, 'reporte3Pdf'])->name('rep3.pdf');
    Route::get('/reportes/rep4-pdf', [ReportesController::class, 'reporte4Pdf'])->name('rep4.pdf');
    Route::get('/reportes/rep5-pdf', [ReportesController::class, 'reporte5Pdf'])->name('rep5.pdf');
    Route::get('/reportes/rep6-pdf', [ReportesController::class, 'reporte6Pdf'])->name('rep6.pdf');
    Route::get('/reportes/rep7-pdf', [ReportesController::class, 'reporte7Pdf'])->name('rep7.pdf');
    Route::get('/reportes/rep8-pdf', [ReportesController::class, 'reporte8Pdf'])->name('rep8.pdf');
    Route::get('/reportes/rep10-pdf', [ReportesController::class, 'reporte10Pdf'])->name('rep10.pdf');
    Route::get('/reportes/rep13-pdf', [ReportesController::class, 'reporte13Pdf'])->name('rep13.pdf');
    Route::get('/reportes/rep15-pdf', [ReportesController::class, 'reporte15Pdf'])->name('rep15.pdf');
    Route::get('/reportes/rep16-pdf', [ReportesController::class, 'reporte16Pdf'])->name('rep16.pdf');
    Route::get('/reportes/rep17-pdf', [ReportesController::class, 'reporte17Pdf'])->name('rep17.pdf');
    Route::get('/reportes/rep18-pdf', [ReportesController::class, 'reporte18Pdf'])->name('rep18.pdf');



    Route::get('/reportes/asignacion', [ReportesController::class, 'asignacion'])->name('asignacion');
    Route::get('/reportes/devolucion', [ReportesController::class, 'devolucion'])->name('devolucion');
    Route::get('/reportes/kardex', [ReportesController::class, 'kardex'])->name('kardex');
    Route::get('/reportes/certificado/{empleado_id}', [ReportesController::class, 'certificado'])->name('certificado');
    Route::get('/reportes/formulario/{empleado_id}', [ReportesController::class, 'formulario'])->name('formulario');


    Route::get('/reportes/rep1-excel', [ReportesController::class, 'reporte1Excel'])->name('rep1.excel');
    Route::get('/reportes/rep5-excel', [ReportesController::class, 'reporte5Excel'])->name('rep5.excel');
    Route::get('/reportes/rep7-excel', [ReportesController::class, 'reporte7Excel'])->name('rep7.excel');
    Route::get('/reportes/rep13-excel', [ReportesController::class, 'reporte13Excel'])->name('rep13.excel');
    Route::get('/reportes/rep16-excel', [ReportesController::class, 'reporte16Excel'])->name('rep16.excel');



    Route::get('activo/archivoadjunto', [ArchivoAdjuntoController::class, 'index'])->name('activo.archivoadjunto.index');
    Route::get('activo/archivoadjunto/create', [ArchivoAdjuntoController::class, 'create'])->name('activo.archivoadjunto.create');
    Route::post('activo/archivoadjunto', [ArchivoAdjuntoController::class, 'store'])->name('activo.archivoadjunto.store');
    Route::delete('activo/archivoadjunto/{archivo}', [ArchivoAdjuntoController::class, 'destroy'])->name('activo.archivoadjunto.destroy');






    Route::get('Activo/reportes', [ReportesController::class, 'index'])->name('activo.reportes.index');
    Route::get('Activo/reportes/generar', [ReportesController::class, 'generar'])->name('reportes.generar');
    Route::get('Activo/reportes/inventario', [ReportesController::class, 'inventario'])->name('reportes.inventario');
    Route::get('Activo/reportes/estado', [ReportesController::class, 'estado'])->name('reportes.estado');
    Route::get('Activo/reportes/valoracion', [ReportesController::class, 'valoracion'])->name('reportes.valoracion');





    Route::get('Activo/codigo-barras', [CodigoBarrasController::class, 'index'])->name('activo.codigos_barras.index');
    Route::post('Activo/codigo-barras', [CodigoBarrasController::class, 'store'])->name('activo.codigos_barras.store');
    Route::put('Activo/codigo-barras/{id}', [CodigoBarrasController::class, 'update'])->name('activo.codigos_barras.update');
    Route::delete('Activo/codigo-barras/{id}', [CodigoBarrasController::class, 'delete'])->name('activo.codigos_barras.delete');
    Route::get('Activo/codigo-barras/{id}', [CodigoBarrasController::class, 'show'])->name('activo.codigos_barras.show');
    Route::post('Activo/codigo-barras/generar', [CodigoBarrasController::class, 'generar'])->name('codigos_barras.generar');
    Route::get('Activo/etiquetas/{id}/imprimir/{cantidad}', [CodigoBarrasController::class, 'imprimirEtiquetas'])->name('etiquetas.imprimir');
    Route::post('Activo/configuracion/guardar', [CodigoBarrasController::class, 'guardarConfiguracion'])->name('configuracion.guardar');

    Route::get('Activo/codigo-barras/{codigo}/buscar', [CodigoBarrasController::class, 'buscar'])->name('activo.codigos_barras.buscar');


    Route::get('Activo/configuracion', [ConfiguracionController::class, 'index'])->name('activo.configuracion.index');
    Route::post('Activo/configuracion/general', [ConfiguracionController::class, 'guardarConfiguracionGeneral'])->name('configuracion.general.guardar');
    Route::get('Activo/configuracion/usuarios', [ConfiguracionController::class, 'usuarios'])->name('configuracion.usuarios');

});
    Route::get('activosFijos/activos', 'ActivosController@index')->name('activos.index');




////////////////////////////////--DISCAPACIDAD--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('canasta/entrega/index', [CanastaEntregaController::class,'index'])->name('canasta.entrega.index');//->middleware('can:canasta.entrega.index');
Route::get('canasta/entrega/search', [CanastaEntregaController::class,'search'])->name('canasta.entrega.search');//->middleware('can:canasta.entrega.index');
Route::get('canasta/pendientes/index', [CanastaPendientesController::class,'index'])->name('canasta.pendientes.index');//->middleware('can:canasta.entrega.index');
Route::get('canasta/pendientes/search', [CanastaPendientesController::class,'search'])->name('canasta.pendientes.search');//->middleware('can:canasta.entrega.index');
Route::get('canasta/pendientes/search-detalle', [CanastaPendientesController::class,'searchdetalle'])->name('canasta.pendientes.search.detalle');//->middleware('can:canasta.entrega.index');
Route::get('canasta/pendientes/search-detalle-pdf', [CanastaPendientesController::class,'searchdetallepdf'])->name('canasta.pendientes.search.detallepdf');//->middleware('can:canasta.entrega.index');

Route::get('activosvsiaf/index', [ActivosVsiafController::class,'index'])->name('activos.vsiaf.index');//->middleware('can:canasta.entrega.index');
Route::get('activosvsiaf/search', [ActivosVsiafController::class,'search'])->name('activos.vsiaf.search');//->middleware('can:canasta.entrega.index');

/////////////////////////--ENCARGADOS--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*Route::get('compras/pedidoparcial/responsable', [CompraController2::class,'listadoResponsables'])->name('compras.pedidoparcial.listadoResponsables');
Route::get('compras/pedidoparcial/responsableCreate', [CompraController2::class,'crearEncargado'])->name('compras.pedidoparcial.crearEncargado')->middleware('can:compras_encargados_create');
Route::POST('compras/pedidoparcial/store2', [CompraController2::class,'storeEncargado'])->name('compras.pedidoparcial.storeEncargado')->middleware('can:compras_encargados_create');
Route::get('compras/pedidoparcial/responsableEdit/{id}', [CompraController2::class,'responsableEdit'])->name('compras.pedidoparcial.responsableEdit')->middleware('can:compras_encargados_edit');
Route::post('compras/pedidoparcial/responsableUpdate', [CompraController2::class,'UpdateResponsable'])->name('compras.pedidoparcial.UpdateResponsable')->middleware('can:compras_encargados_edit');*/


////////////////////////////--ARCHIVOS--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('archivos/index', [ArchivosController::class,'index'])->name('archivos.index');
Route::get('archivos/createArchivo', [ArchivosController::class,'createArchivo'])->name('archivos.create');
Route::get('archivos/create', [ArchivosController::class,'create'])->name('archivos.create');
Route::POST('archivos/insertar', [ArchivosController::class,'insertar'])->name('archivos.insertar');

Route::get('archivos/{id}/edit', [ArchivosController::class,'editar'])->name('archivos.edit');
Route::POST('archivos/{id}/update', [ArchivosController::class,'update'])->name('archivos.update');


////////////////////////////--ARCHIVOS2--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('archivos2/index', [ArchivosController2::class,'index'])->name('archivos2.index');
Route::get('archivos2/createArchivo', [ArchivosController2::class,'createArchivo'])->name('archivos2.create');
Route::get('archivos2/create', [ArchivosController2::class,'create'])->name('archivos2.create');
Route::POST('archivos2/insertar', [ArchivosController2::class,'insertar'])->name('archivos2.insertar');

Route::get('archivos2/{id}/edit', [ArchivosController2::class,'editar'])->name('archivos2.edit');
Route::POST('archivos2/{id}/update', [ArchivosController2::class,'update'])->name('archivos2.update');

Route::get('archivos2/index2', [ArchivosController2::class,'index2'])->name('archivos2.index2');
Route::get('/archivos2/index22', [ArchivosController2::class,'index22'])->name('archivos2.index22');

Route::get('archivos2/tipoarchivo', [ArchivosController2::class,'tipo'])->name('archivos2.tipo');
Route::POST('archivos2/tipoarchivo', [ArchivosController2::class,'guardartipoarea'])->name('archivos2.guardartipo');
Route::get('archivos2/delete{id}', [ArchivosController2::class,'delete'])->name('archivos2.delete');

Route::get('archivos2/createtipo', [ArchivosController2::class,'createtipoarchivo'])->name('archivos2.createtipo');
Route::POST('archivos2/createtipoarchivo', [ArchivosController2::class,'guardartipoarchivo'])->name('archivos2.storecreatetipo');

/////////////////////////--ALMACEN--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('almacen/index', [AlmacenController::class,'index'])->name('almacen.index');
//Route::get('compras/pedido/index2', 'CompraController@index2')->name('compras.pedido.index2');
//oute::get('compras/pedido/create', 'CompraController@create')->name('compras.pedido.create');
//Route::post('compras/pedido/store', 'CompraController@store')->name('compras.pedido.store');
//Route::get('compras/pedido/edit/{id}', 'CompraController@edit')->name('compras.pedido.edit');
//Route::get('compras/pedido/editar/{id}', 'CompraController@editar')->name('compras.pedido.editar');
//Route::post('compras/pedido/update', 'CompraController@update')->name('compras.pedido.update');

/////////////////////////--CORRESPONDENCIA--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('correspondencia/index', [RecepcionController::class,'index'])->name('recepcion.index');
Route::get('correspondencia/createRecepcion', [RecepcionController::class,'create'])->name('recepcion.create');
Route::get('correspondencia/indexUnidad', [RecepcionController::class,'indexUnidad'])->name('recepcion.unidadIndex');
Route::get('correspondencia/indexRemitente', [RecepcionController::class,'indexRemitente'])->name('recepcion.remitenteIndex');
Route::get('correspondencia/createUnidad', [RecepcionController::class,'createLugar'])->name('crear.lugar');
Route::post('correspondencia/storeLugar', [RecepcionController::class,'storeLugar'])->name('guardar.lugar');
Route::get('correspondencia/createRemitente', [RecepcionController::class,'createRemitente'])->name('crear.remitente');
Route::post('correspondencia/storeRemitente', [RecepcionController::class,'storeRemitente'])->name('guardar.remitente');
Route::get('correspondencia/createRecepcion', [RecepcionController::class,'createRecepcion'])->name('crear.recepcion');
Route::post('correspondencia/storeRecepcion', [RecepcionController::class,'storeRecepcion'])->name('guardar.recepcion');
Route::get('correspondencia/{id}/edit', [RecepcionController::class,'editarCodigo'])->name('correspondencia.edit');
Route::POST('correspondencia/{id}/updateCodigo', [RecepcionController::class,'updateCodigo'])->name('correspondencia.update');


////////////////////////////--AGENDA--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


Route::get('agenda/index', [AgendaController::class,'index'])->name('agenda.index');
//Route::get('archivos2/createArchivo', [ArchivosController::class,'createArchivo'])->name('agenda.create');
Route::get('agenda/create', [AgendaController::class,'create'])->name('agenda.create');
Route::POST('agenda/insertar', [AgendaController::class,'insertar'])->name('agenda.insertar');

Route::get('agenda/{id}/edit', [AgendaController::class,'editar'])->name('agenda.edit');
Route::POST('agenda/{id}/update', [AgendaController::class,'update'])->name('agenda.update');

Route::get('agenda/{id}/edit2', [AgendaController::class,'editar2'])->name('agenda.edit2');
Route::POST('agenda/{id}/update2', [AgendaController::class,'update2'])->name('agenda.update2');

Route::get('agenda/indexayer', [AgendaController::class,'indexayer'])->name('agenda.indexayer');
Route::get('agenda/indexhoy', [AgendaController::class,'indexhoy'])->name('agenda.indexhoy');
Route::get('agenda/indexmaniana', [AgendaController::class,'indexmaniana'])->name('agenda.indexmaniana');
Route::get('agenda/delete/{id}', [AgendaController::class,'delete'])->name('agenda.delete');



////evento////
Route::get('Calendar/event',[ControllerCalendar::class,'index']);
Route::get('Calendar/event/{mes}',[ControllerCalendar::class,'index_month']);

// formulario
Route::get('Evento/form/{mes}',[ControllerEvent::class,'form']);
Route::post('Evento/create', [ControllerEvent::class,'create']);
// Detalles de evento
Route::get('Evento/details/{id},{id2},{id3}',[ControllerEvent::class,'details']);
Route::get('Evento/details2/{id}',[ControllerEvent::class,'details2']);
// Calendario
Route::get('Evento/index',[ControllerEvent::class,'index']);
Route::get('Evento/index/{month}',[ControllerEvent::class,'index_month']);

// editar
Route::get('Evento/actualizar/{id}',[ControllerEvent::class,'editar']);
Route::post('Evento/actualizar2/{id}',[ControllerEvent::class,'actualizar']);


/////////////////////////--CORRESPONDENCIA 2--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('correspondencia2/index', [Recepcion2Controller::class,'index'])->name('recepcion2.index');
Route::get('correspondencia2/{id}/edit', [Recepcion2Controller::class,'editarCodigo'])->name('correspondencia2.edit');
Route::POST('correspondencia2/{id}/updateCodigo', [Recepcion2Controller::class,'updateCodigo'])->name('correspondencia2.update');
Route::get('correspondencia2/createRecepcion', [Recepcion2Controller::class,'createRecepcion'])->name('crear2.recepcion');
Route::post('correspondencia2/storeRecepcion', [Recepcion2Controller::class,'storeRecepcion'])->name('guardar2.recepcion');
Route::get('correspondencia2/indexUnidad', [Recepcion2Controller::class,'indexUnidad'])->name('recepcion2.unidadIndex');
Route::get('correspondencia2/createUnidad', [Recepcion2Controller::class,'createLugar'])->name('crear2.lugar');
Route::post('correspondencia2/storeLugar', [Recepcion2Controller::class,'storeLugar'])->name('guardar2.lugar');
Route::get('correspondencia2/indexRemitente', [Recepcion2Controller::class,'indexRemitente'])->name('recepcion2.remitenteIndex');
Route::get('correspondencia2/createRemitente', [Recepcion2Controller::class,'createRemitente'])->name('crear2.remitente');
Route::post('correspondencia2/storeRemitente', [Recepcion2Controller::class,'storeRemitente'])->name('guardar2.remitente');
Route::get('correspondencia2/createTipo', [Recepcion2Controller::class,'createTipo'])->name('crear2.tipo');
Route::post('correspondencia2/storeTipo', [Recepcion2Controller::class,'storeTipo'])->name('guardar2.tipo');

Route::get('correspondencia2/buscarRemitentes', [Recepcion2Controller::class,'buscarRemitentes'])->name('crear2.buscarRemitentes');

//////////////////
Route::get('correspondencia2/{id}/gestionarCorrespondencia', [Recepcion2Controller::class,'gestionarCorrespondencia'])->name('correspondencia2.gestionar');
Route::get('correspondencia2/{id}/cargarpdf', [Recepcion2Controller::class,'cargarpdf'])->name('correspondencia2.cargarpdf');
Route::post('correspondencia2/storepdf', [Recepcion2Controller::class,'storepdf'])->name('correspondencia2.storepdf');
Route::get('correspondencia2/{id}/derivar', [Recepcion2Controller::class,'derivar'])->name('correspondencia2.derivar');
Route::get('correspondencia2/derivar2', [Recepcion2Controller::class,'guardarderivacion'])->name('correspondencia2.guardarderivacion');
Route::get('correspondencia2/delete{id}', [Recepcion2Controller::class,'delete'])->name('correspondencia2.delete');
Route::get('correspondencia2/urlfile/{id}', [Recepcion2Controller::class,'urlfile'])->name('correspondencia2.urlfile');
Route::get('correspondencia2/{id}/actualizarpdf', [Recepcion2Controller::class,'actualizarpdf'])->name('correspondencia2.actualizarpdf');
Route::post('correspondencia2/updatepdf', [Recepcion2Controller::class,'updatepdf'])->name('correspondencia2.updatepdf');

Route::post('/ruta', [Recepcion2Controller::class,'respuesta'])->name('pregunta');


////evento2////

// formulario
Route::get('Evento2/form/{mes}',[ControllerEvent2::class,'form']);
Route::post('Evento2/create',[ControllerEvent2::class,'create']);
// Detalles de evento
Route::get('Evento2/details/{id},{id2},{id3}',[ControllerEvent2::class,'details']);
Route::get('Evento2/details2/{id}',[ControllerEvent2::class,'details2']);
// Calendario
Route::get('Evento2/index',[ControllerEvent2::class,'index']);
Route::get('Evento2/index/{month}',[ControllerEvent2::class,'index_month']);

// editar
Route::get('Evento2/actualizar/{id}',[ControllerEvent2::class,'editar']);
Route::post('Evento2/actualizar2/{id}',[ControllerEvent2::class,'actualizar']);

Route::get('Evento2/{id}/cargarpdf', [ControllerEvent2::class,'cargarpdf'])->name('evento2.cargarpdf');
Route::post('Evento2/storepdf', [ControllerEvent2::class,'storepdf'])->name('evento2.storepdf');
Route::get('Evento2/{id}/actualizarpdf', [ControllerEvent2::class,'actualizarpdf'])->name('evento2.actualizarpdf');
Route::POST('Evento2/updatepdf', [ControllerEvent2::class,'updatepdf'])->name('evento2.updatepdf');
Route::get('Evento2/urlfile/{id}', [ControllerEvent2::class,'urlfile'])->name('evento2.urlfile');

/////////////////////////--CANASTA--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('almacen/detalle/{id}','AlmacenController@detalle')->name('almacen.detalle');

Route::get('canasta/beneficiarios/index', 'Canasta\BeneficiariosController@index')->name('canasta.beneficiarios.index');
Route::get('canasta/beneficiarios/search', 'Canasta\BeneficiariosController@search')->name('canasta.beneficiarios.search');
Route::get('canasta/beneficiarios/excel', 'Canasta\BeneficiariosController@excel')->name('canasta.beneficiarios.excel');
Route::get('canasta/beneficiarios/show/{usuario_id}', 'Canasta\BeneficiariosController@show')->name('canasta.beneficiarios.show');
Route::get('canasta/beneficiarios/show/pdf/{usuario_id}', 'Canasta\BeneficiariosController@show_pdf')->name('canasta.beneficiarios.show.pdf');
Route::get('canasta/barrios/index', 'Canasta\BarriosController@index')->name('canasta.barrios.index');
Route::get('canasta/barrios/search', 'Canasta\BarriosController@search')->name('canasta.barrios.search');
Route::get('canasta/barrios/excel', 'Canasta\BarriosController@excel')->name('canasta.barrios.excel');
Route::get('canasta/periodos/index', 'Canasta\PeriodosController@index')->name('canasta.periodos.index');
Route::get('canasta/periodos/search', 'Canasta\PeriodosController@search')->name('canasta.periodos.search');
Route::get('canasta/entregas/index', 'Canasta\EntregasController@index')->name('canasta.entregas.index');

/**CANASTA V2*/
Route::get('distritos/', 'Canasta_v2\DistritosV2Controller@index')->name('distritos.index');


//Route::get('compras/pedido/index2', 'CompraController@index2')->name('compras.pedido.index2');
//oute::get('compras/pedido/create', 'CompraController@create')->name('compras.pedido.create');
//Route::post('compras/pedido/store', 'CompraController@store')->name('compras.pedido.store');
//Route::get('almacen/temporal/{id}','AlmacenController@temporal')->name('almacen.temporal');
//Route::get('compras/pedido/editar/{id}', 'CompraController@editar')->name('compras.pedido.editar');
//Route::post('compras/pedido/update', 'CompraController@update')->name('compras.pedido.update');


/////////////////////////--EXPOCHACO SUDAMERICANO--//////////////////////
//Route::get('expochaco/index', [ExpoController::class,'index'])->name('expochaco.index');


//Route::get('expochaco/createrubro', [ExpoController::class,'createrubro'])->name('expochaco.createrubro');
//Route::post('expochaco/storerubro', [ExpoController::class,'storerubro'])->name('expochaco.storerubro');


//Route::get('expochaco/index', [SolicitudController::class,'index'])
//->name('expochaco.index');



//Route::get('qrcode', function () {
  // return QrCode::size(300)->generate('A basic example of QR code!');
//})->name('qrr');

    //////PERSONERIAS/////
   Route::get('personerias/index', [PersoneriasController::class,'index'])
   ->name('personerias.index');

   Route::get('personerias/index2', [PersoneriasController::class,'indexantiguo'])
   ->name('personerias.index2');

   Route::get('personerias/index3', [PersoneriasController::class,'indexActualizada'])
   ->name('personerias.index3');

   Route::post('personerias/index2/{id}', [PersoneriasController::class,'update'])
   ->name('personerias.update');

   Route::get('personerias/index3/{id}', [PersoneriasController::class,'borrar'])
   ->name('personerias.destroy');

   Route::post('personerias/index4', [PersoneriasController::class,'create'])
   ->name('personerias.create');

   Route::post('personerias/index5/{id}', [PersoneriasController::class,'create2'])
   ->name('personerias.create2');

});
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Route::group(['namespace' => 'App\Http\Controllers'], function() {

//});





Route::group(['namespace' => 'App\Http\Controllers\Fexpo'], function() {


    Route::get('expochaco/create', 'SolicitudController@create')
    ->name('expochaco.create');

    Route::post('expochaco/store', 'SolicitudController@store')
    ->name('expochaco.store');

    Route::get('expochaco/generarqr/{id}', 'SolicitudController@codigoqr')
    ->name('expochaco.generarqr');
    Route::post('/ruta2', 'SolicitudController@respuesta2')->name('pregunta2');
});



Route::group(['namespace' => 'App\Http\Controllers\Compra'], function() {

    Route::get('combustibles/producto/index', 'ProdCombController@index')->name('producto.index')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/producto/create', 'ProdCombController@create')->name('producto.create')->middleware('can:comprascomb_janeth_access');
    Route::post('combustibles/producto/store', 'ProdCombController@store')->name('producto.store')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/producto/list', 'ProdCombController@list')->name('producto.list')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/producto/{id}/edit', 'ProdCombController@editar')->name('producto.edit')->middleware('can:comprascomb_janeth_access');
    Route::POST('combustibles/producto/{id}/update', 'ProdCombController@update')->name('producto.update')->middleware('can:comprascomb_janeth_access');

    Route::post('/ruta3', 'ProdCombController@respuesta3')->name('pregunta3');


    Route::get('combustibles/proveedor/index', 'ProveedorController@index')->name('proveedor.index')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/proveedor/create', 'ProveedorController@create')->name('proveedor.create')->middleware('can:comprascomb_janeth_access');
    Route::post('combustibles/proveedor/store', 'ProveedorController@store')->name('proveedor.store')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/proveedor/list', 'ProveedorController@list')->name('proveedor.list')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/proveedor/{id}/edit', 'ProveedorController@editar')->name('proveedor.edit')->middleware('can:comprascomb_janeth_access');
    Route::POST('combustibles/proveedor/{id}/update', 'ProveedorController@update')->name('proveedor.update')->middleware('can:comprascomb_janeth_access');


    Route::get('combustibles/proveedor/{id}/editardoc', ['uses' => 'ProveedorController@editardoc','as' => 'proveedor.editdoc'])->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/proveedor/{id}/createdocproveedor', 'ProveedorController@createdoc')->name('ProveedorController.createdoc')->middleware('can:comprascomb_janeth_access');
    Route::POST('combustibles/proveedor/insertar', 'ProveedorController@insertar')->name('ProveedorController.insertar')->middleware('can:comprascomb_janeth_access');

    Route::get('combustibles/proveedor/{id}/editararchivo', 'ProveedorController@editararchivo')->name('ProveedorController.editararchivo')->middleware('can:comprascomb_janeth_access');
    Route::POST('combustibles/proveedor/{id}/updatearchivoproveedor', 'ProveedorController@updatearchivoproveedor')->name('ProveedorController.updatearchivoproveedor')->middleware('can:comprascomb_janeth_access');


    Route::post('/ruta2', 'ProveedorController@respuesta2')->name('pregunta2')->middleware('can:comprascomb_janeth_access');


     Route::get('combustibles/programa/index', 'ProgramaCombController@index')->name('programa.index')->middleware('can:comprascomb_janeth_access');
     Route::get('combustibles/programa/list', 'ProgramaCombController@listado')->name('programa.list')->middleware('can:comprascomb_janeth_access');
     Route::get('combustibles/programa/{id}/edit', 'ProgramaCombController@edit')->name('programa.edit')->middleware('can:comprascomb_janeth_access');
    Route::POST('combustibles/programa/{id}/update', 'ProgramaCombController@update')->name('programa.update')->middleware('can:comprascomb_janeth_access');
     Route::get('combustibles/programa/create', 'ProgramaCombController@create')->name('programa.create')->middleware('can:comprascomb_janeth_access');
    Route::POST('combustibles/programa/store', 'ProgramaCombController@store')->name('programa.store')->middleware('can:comprascomb_janeth_access');

    Route::get('combustibles/partida/index', 'PartidaCombController@index')->name('partidacomb.index')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/partida/listado', 'PartidaCombController@listado')->name('partidacomb.list')->middleware('can:comprascomb_janeth_access');


    Route::get('combustibles/catprog/index', 'CatProgController@index')->name('catprogcomb.index')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/catprogc/list', 'CatProgController@listado')->name('catprogcomb.list')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/catprog/{id}/edit', 'CatProgController@editar')->name('catprogcomb.edit')->middleware('can:comprascomb_janeth_access');
    Route::POST('combustibles/catprog/{id}/update', 'CatProgController@update')->name('catprogcomb.update')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/catprog/create', 'CatProgController@create')->name('catprogcomb.create')->middleware('can:comprascomb_janeth_access');
    Route::POST('combustibles/catprog/store', 'CatProgController@store')->name('catprogcomb.store')->middleware('can:comprascomb_janeth_access');


    Route::get('combustibles/pedido/index', 'CompraCombController@index')->name('combustibles.pedido.index')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/pedido/index2', 'CompraCombController@index2')->name('combustibles.pedido.index2')->middleware('can:comprasalmacen_aprovadas_access');
    Route::get('combustibles/pedido/create', 'CompraCombController@create')->name('combustibles.pedido.create')->middleware('can:comprascomb_janeth_access');
    Route::post('combustibles/pedido/store', 'CompraCombController@store')->name('combustibles.pedido.store')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/pedido/edit/{id}', 'CompraCombController@edit')->name('combustibles.pedido.edit')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/pedido/editar/{id}', 'CompraCombController@editar')->name('combustibles.pedido.editar')->middleware('can:comprascomb_janeth_access');
    Route::post('combustibles/pedido/update', 'CompraCombController@update')->name('combustibles.pedido.update')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/pedido/editable/{id}', 'CompraCombController@editable')->name('combustibles.pedido.editable')->middleware('can:comprasalmacen_aprovadas_access');
    Route::get('combustibles/pedido/editabledos/{id}', 'CompraCombController@editabledos')->name('combustibles.pedido.editabledos')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/pedido/editabletres/{id}', 'CompraCombController@editabletres')->name('combustibles.pedido.editabletres')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/pedido/editablecuatro/{id}', 'CompraCombController@editablecuatro')->name('combustibles.pedido.editablecuatro')->middleware('can:comprascomb_janeth_access');

    Route::post('/ruta5', 'CompraCombController@respuesta5')->name('pregunta5')->middleware('can:comprascomb_janeth_access');
    Route::post('/ruta6', 'CompraCombController@respuesta6')->name('pregunta6')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/pedido/ver/{id}', 'CompraCombController@ver')->name('combustibles.pedido.ver')->middleware('can:comprascomb_janeth_access');



    Route::get('combustibles/pedidoparcial/index', 'CompraCombController2@index')
    ->name('combustibles.pedidoparcial.index')->middleware('can:comprascomb_panel_access');

    Route::get('combustibles/pedidoparcial/index2', 'CompraCombController2@index2')
    ->name('combustibles.pedidoparcial.index2')->middleware('can:comprascomb_panel_access');

    Route::get('combustibles/pedidoparcial/create', 'CompraCombController2@create')
    ->name('combustibles.pedidoparcial.create')->middleware('can:comprascomb_panel_access');

    Route::post('combustibles/pedidoparcial/store', 'CompraCombController2@store')
    ->name('combustibles.pedidoparcial.store')->middleware('can:comprascomb_panel_access');


    Route::post('combustibles/pedidoparcial/update', 'CompraCombController2@update')
    ->name('combustibles.pedidoparcial.update')->middleware('can:comprascomb_panel_access');

    Route::get('combustibles/pedidoparcial/editar/{id}', 'CompraCombController2@editar')
    ->name('combustibles.pedidoparcial.editar')->middleware('can:comprascomb_panel_access');

    Route::get('combustibles/pedidoparcial/editable/{id}', 'CompraCombController2@editable')
    ->name('combustibles.pedidoparcial.editable')->middleware('can:comprascomb_panel_access');

     Route::get('combustibles/pedidoparcial/edit/{id}', 'CompraCombController2@edit')
     ->name('combustibles.pedidoparcial.edit')->middleware('can:comprascomb_panel_access');

    Route::post('/ruta4', 'CompraCombController2@respuesta4')->name('pregunta4')->middleware('can:comprascomb_panel_access');




    Route::get('combustibles/pedidoparcial/ver/{id}', 'CompraCombController2@ver')
    ->name('combustibles.pedidoparcial.ver')->middleware('can:comprascomb_panel_access');
    Route::get('combustibles/pedidoparcial/editrecha/{id}', 'CompraCombController2@editrecha')
    ->name('combustibles.pedidoparcial.editrecha')->middleware('can:comprascomb_panel_access');
    Route::get('combustibles/pedidoparcial/editalma/{id}', 'CompraCombController2@editalma')
    ->name('combustibles.pedidoparcial.editalma')->middleware('can:comprascomb_panel_access');

    Route::get('combustibles/detalle/index', 'DetalleCompraCombController@index')->name('combustibles.detalle.index')->middleware('can:comprascomb_janeth_access');

    Route::get('combustibles/detalle/index2', 'DetalleCompraCombController@index2')->name('combustibles.detalle.index2')->middleware('can:comprasalmacen_aprovadas_access');


    Route::get('combustibles/detalle/index3', 'DetalleCompraCombController@index3')->name('combustibles.detalle.index3')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/detalle/index4', 'DetalleCompraCombController@index4')->name('combustibles.detalle.index4');
    Route::get('combustibles/detalle/index5', 'DetalleCompraCombController@index5')->name('combustibles.detalle.index5')->middleware('can:comprascomb_janeth_access');

    Route::post('combustibles/detalle/store', 'DetalleCompraCombController@store')->name('combustibles.detalle.store')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/detalle/principal/{id}', 'DetalleCompraCombController@crearOrdenxxx')->name('combustibles.detalle.principal')->middleware('can:comprascomb_janeth_access');
    Route::post('combustibles/detalle/principal/store', 'DetalleCompraCombController@crearOrden')->name('combustibles.detalle.principal.store')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/detalle/{id}/principalorden', 'DetalleCompraCombController@crearOrdendocxx')->name('combustibles.detalle.principalorden')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/detalle/show', 'DetalleCompraCombController@show')->name('combustibles.detalle.show')->middleware('can:comprascomb_janeth_access');
    Route::post('combustibles/detalle/principalorden', 'DetalleCompraCombController@crearOrdendoc')->name('DetalleCompraCombController.crearOrdendoc')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/detalle/{id}/destroyed2', 'DetalleCompraCombController@destroyed2')->name('DetalleCompraCombController.eliminar2')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/delete/{id}', 'DetalleCompraCombController@delete')->name('combustibles.detalle.delete')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/aprovar/{id}', 'DetalleCompraCombController@aprovar')->name('combustibles.detalle.aprovar')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/rechazar/{id}', 'DetalleCompraCombController@rechazar')->name('combustibles.detalle.rechazar')->middleware('can:comprascomb_janeth_access');

    Route::get('combustibles/almacen/{id}', 'DetalleCompraCombController@almacen')->name('combustibles.detalle.almacen')->middleware('can:comprasalmacen_aprovadas_access');

    Route::get('combustibles/detalle/invitacion/{id}', 'DetalleCompraCombController@invitacion')->name('combustibles.detalle.principal.invitacion')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/detalle/aceptacion/{id}', 'DetalleCompraCombController@aceptacion')->name('combustibles.detalle.principal.aceptacion')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/detalle/cotizacion/{id}', 'DetalleCompraCombController@cotizacion')->name('combustibles.detalle.principal.cotizacion')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/detalle/adjudicacion/{id}', 'DetalleCompraCombController@adjudicacion')->name('combustibles.detalle.principal.adjudicacion')->middleware('can:comprascomb_janeth_access');
    Route::get('combustibles/detalle/orden/{id}', 'DetalleCompraCombController@orden')->name('combustibles.detalle.principal.orden')->middleware('can:comprascomb_janeth_access');






    Route::get('combustibles/detalleparcial/index', 'DetalleCompraCombController2@index')
    ->name('combustibles.detalleparcial.index')->middleware('can:comprascomb_panel_access');

    Route::get('combustibles/detalleparcial/index2', 'DetalleCompraCombController2@index2')
    ->name('combustibles.detalleparcial.index2')->middleware('can:comprascomb_panel_access');


    Route::get('combustibles/detalleparcial/index3', 'DetalleCompraCombController2@index3')
    ->name('combustibles.detalleparcial.index3')->middleware('can:comprascomb_panel_access');
    Route::get('combustibles/detalleparcial/index4', 'DetalleCompraCombController2@index4')
    ->name('combustibles.detalleparcial.index4')->middleware('can:comprascomb_panel_access');
    Route::post('combustibles/detalleparcial/store', 'DetalleCompraCombController2@store')
    ->name('combustibles.detalleparcial.store')->middleware('can:comprascomb_panel_access');

    Route::get('combustibles/detalleparcial/show/{id}', 'DetalleCompraCombController2@show')
    ->name('combustibles.detalleparcial.show')->middleware('can:comprascomb_panel_access');

    Route::get('combustibles/detalleparcial/{id}/destroyed2', 'DetalleCompraCombController2@destroyed2')
    ->name('DetalleCompraController2.eliminar2')->middleware('can:comprascomb_panel_access');

    Route::get('combustibles/delete2/{id}', 'DetalleCompraCombController2@delete')
    ->name('combustibles.detalleparcial.delete')->middleware('can:comprascomb_panel_access');



});

Route::group(['namespace' => 'App\Http\Controllers\Transporte'], function() {

    Route::get('transportes/uconsumo/index', 'UnidaddConsumoController@index')->name('transportes.uconsumo.index')->middleware('can:transportescombvehiculo_access');
Route::get('transportes/uconsumo/index2', 'UnidaddConsumoController@index2')->name('transportes.uconsumo.index2')->middleware('can:transportescombvehiculo_access');
Route::get('transportes/uconsumo/editar/{id}', 'UnidaddConsumoController@editar')->name('transportes.uconsumo.editar')->middleware('can:transportescombvehiculo_access');

Route::POST('transportes/uconsumo/update', 'UnidaddConsumoController@update')->name('transportes.uconsumo.update')->middleware('can:transportescombvehiculo_access');
Route::get('transportes/uconsumo/create', 'UnidaddConsumoController@create')->name('transportes.uconsumo.create')->middleware('can:transportescombvehiculo_access');
Route::POST('transportes/uconsumo/store', 'UnidaddConsumoController@store')->name('transportes.uconsumo.store')->middleware('can:transportescombvehiculo_access');

Route::get('transportes/uconsumo/{id}/editardoc', ['uses' => 'UnidaddConsumoController@editardoc','as' => 'uconsumo.editdoc'])->middleware('can:transportescombvehiculo_access');
Route::get('transportes/uconsumo/{id}/createdocuconsumo', 'UnidaddConsumoController@createdoc')->name('UnidaddConsumoController.createdoc')->middleware('can:transportescombvehiculo_access');
Route::POST('transportes/uconsumo/insertar', 'UnidaddConsumoController@insertar')->name('UnidaddConsumoController.insertar')->middleware('can:transportescombvehiculo_access');
Route::get('transportes/uconsumo/aprovar/{id}', 'UnidaddConsumoController@aprovar')
    ->name('transportes.uconsumo.aprovar')->middleware('can:transportescombvehiculo_access');



    Route::get('transportes/tipo/index', 'TipomovilidadController@index')->name('tipo.index')->middleware('can:transportescombtipo_access');
    Route::get('transportes/tipo/list', 'TipomovilidadController@listado')->name('tipo.list')->middleware('can:transportescombtipo_access');
    Route::get('transportes/tipo/{id}/edit', 'TipomovilidadController@editar')->name('tipo.edit')->middleware('can:transportescombtipo_access');
    Route::POST('transportes/tipo/{id}/update', 'TipomovilidadController@update')->name('tipo.update')->middleware('can:transportescombtipo_access');
    Route::get('transportes/tipo/create', 'TipomovilidadController@create')->name('tipo.create')->middleware('can:transportescombtipo_access');
    Route::POST('transportes/tipo/store', 'TipomovilidadController@store')->name('tipo.store')->middleware('can:transportescombtipo_access');



    Route::get('transportes/pedido/index', 'SoluconsumoController@index')
    ->name('transportes.pedido.index')->middleware('can:vehiculocombu_pendiente');
    Route::get('transportes/pedido/index2', 'SoluconsumoController@index2')
    ->name('transportes.pedido.index2')->middleware('can:vehiculocombu_pendiente');
    Route::get('transportes/pedido/index3', 'SoluconsumoController@index3')
    ->name('transportes.pedido.index3')->middleware('can:vehiculocomb_solicitud_janeth');

    Route::get('transportes/pedido/index4', 'SoluconsumoController@index4')
    ->name('transportes.pedido.index4')->middleware('can:vehiculocomb_solicitud_janeth');

    Route::get('transportes/pedido/editar/{id}', 'SoluconsumoController@editar')->name('transportes.pedido.editar')->middleware('can:vehiculocomb_solicitud_janeth');

    Route::POST('transportes/pedido/update', 'SoluconsumoController@update')->name('transportes.pedido.update');
    Route::get('transportes/pedido/edit/{id}', 'SoluconsumoController@edit')->name('transportes.pedido.edit');
    Route::get('transportes/pedido/editable/{id}', 'SoluconsumoController@editable')->name('transportes.pedido.editable');

    Route::get('transportes/pedido/aprovar/{id}', 'SoluconsumoController@aprovar')
    ->name('transportes.pedido.aprovar')->middleware('can:vehiculocomb_solicitud_janeth');
    Route::get('transportes/pedido/rechazar/{id}', 'SoluconsumoController@rechazar')
    ->name('transportes.pedido.rechazar')->middleware('can:vehiculocomb_solicitud_janeth');

    Route::get('transportes/pedido/rechazartr/{id}', 'SoluconsumoController@rechazartr')
    ->name('transportes.pedido.rechazartr');


    Route::get('transportes/pedidoparcial/index', 'SoluconsumoController2@index')
    ->name('transportes.pedidoparcial.index')->middleware('can:vehiculocomb_solicitud_access');


    Route::get('transportes/pedidoparcial/index2', 'SoluconsumoController2@index2')
    ->name('transportes.pedidoparcial.index2')->middleware('can:vehiculocomb_solicitud_access');

    Route::get('transportes/pedidoparcial/index3', 'SoluconsumoController2@index3')
    ->name('transportes.pedidoparcial.index3')->middleware('can:vehiculocomb_solicitud_access');


    Route::get('transportes/pedidoparcial/create', 'SoluconsumoController2@create')
    ->name('transportes.pedidoparcial.create')->middleware('can:vehiculocomb_solicitud_access');

    Route::post('transportes/pedidoparcial/store', 'SoluconsumoController2@store')
    ->name('transportes.pedidoparcial.store')->middleware('can:vehiculocomb_solicitud_access');

    Route::get('transportes/pedidoparcial/editar/{id}', 'SoluconsumoController2@editar')->name('transportes.pedidoparcial.editar')->middleware('can:vehiculocomb_solicitud_access');

    Route::get('transportes/pedidoparcial/editrechazado/{id}', 'SoluconsumoController2@editrechazado')->name('transportes.pedidoparcial.editrechazado')->middleware('can:vehiculocomb_solicitud_access');

    Route::POST('transportes/pedidoparcial/update', 'SoluconsumoController2@update')->name('transportes.pedidoparcial.update')->middleware('can:vehiculocomb_solicitud_access');

    Route::GET('transportes/pedidoparcial/pdf', 'SoluconsumoController2@pdf')->name('transportes.pedidoparcial.pdf')->middleware('can:vehiculocomb_solicitud_access');

    Route::get('transportes/pedidoparcial/solicitud/{id}', 'SoluconsumoController2@solicitud')->name('transportes.pedidoparcial.solicitud')->middleware('can:vehiculocomb_solicitud_access');


    Route::post('/ruta7', 'SoluconsumoController2@respuesta7')->name('pregunta7')->middleware('can:vehiculocomb_solicitud_access');


    Route::get('transportes/detalle/index', 'DetalleSoluconsumoController@index')
    ->name('transportes.detalle.index')->middleware('can:vehiculocombu_pendiente');

    Route::get('transportes/detalle/index2', 'DetalleSoluconsumoController@index2')
    ->name('transportes.detalle.index2')->middleware('can:vehiculocombu_pendiente');

    Route::post('transportes/detalle/store', 'DetalleSoluconsumoController@store')
    ->name('transportes.detalle.store')->middleware('can:vehiculocombu_pendiente');

    Route::get('transportes/delete2/{id}', 'DetalleSoluconsumoController@delete')
        ->name('transportes.detalle.delete')->middleware('can:vehiculocombu_pendiente');

    Route::get('transportes/detalle/aprovar/{id}', 'DetalleSoluconsumoController@aprovar')
        ->name('transportes.detalle.aprovar')->middleware('can:vehiculocombu_pendiente');


});


Route::group(['namespace' => 'App\Http\Controllers\Almacen'], function() {
Route::get('almacenes/localidad/index', 'LocalidadController@index')->name('localidad.index')->middleware('can:almacen_ingreso_access');
Route::get('almacenes/localidad/list', 'LocalidadController@listado')->name('localidad.list')->middleware('can:almacen_ingreso_access');
Route::get('almacenes/localidad/{id}/edit', 'LocalidadController@editar')->name('localidad.edit')->middleware('can:almacen_ingreso_access');
Route::POST('almacenes/localidad/{id}/update', 'LocalidadController@update')->name('localidad.update')->middleware('can:almacen_ingreso_access');
Route::get('almacenes/localidad/create', 'LocalidadController@create')->name('localidad.create')->middleware('can:almacen_ingreso_access');
Route::POST('almacenes/localidad/store', 'LocalidadController@store')->name('localidad.store')->middleware('can:almacen_ingreso_access');


Route::get('almacenes/pedido/index', 'ValeController@index')->name('almacenes.pedido.index')->middleware('can:almacen_ingreso_access');
Route::get('almacenes/pedido/index2', 'ValeController@index2')->name('almacenes.pedido.index2')->middleware('can:almacen_ingreso_access');
Route::get('almacenes/pedido/index3', 'ValeController@index3')->name('almacenes.pedido.index3')->middleware('can:almacen_ingreso_access');

//Route::get('almacenes/pedido/create', 'ValeController@create')->name('almacenes.pedido.create');
//Route::post('almacenes/pedido/store', 'ValeController@store')->name('almacenes.pedido.store');
Route::get('almacenes/pedido/edit/{id}', 'ValeController@edit')->name('almacenes.pedido.edit')->middleware('can:almacen_ingreso_access');
 Route::get('almacenes/pedido/editar/{id}', 'ValeController@editar')->name('almacenes.pedido.editar')->middleware('can:almacen_ingreso_access');
//Route::post('almacenes/pedido/update', 'ValeController@update')->name('almacenes.pedido.update');
Route::get('almacenes/pedido/editable/{id}', 'ValeController@editable')->name('almacenes.pedido.editable')->middleware('can:almacen_ingreso_access');
Route::get('almacenes/pedido/editabletres/{id}', 'ValeController@editabletres')->name('almacenes.pedido.editabletres')->middleware('can:almacen_ingreso_access');


Route::get('almacenes/detalle/index', 'DetalleValeController@index')->name('almacenes.detalle.index')->middleware('can:almacen_ingreso_access');
Route::get('almacenes/detalle/index2', 'DetalleValeController@index2')->name('almacenes.detalle.index2')->middleware('can:almacen_ingreso_access');
Route::get('almacenes/detalle/index3', 'DetalleValeController@index3')->name('almacenes.detalle.index3')->middleware('can:almacen_ingreso_access');

Route::post('almacenes/detalle/store', 'DetalleValeController@store')->name('almacenes.detalle.store')->middleware('can:almacen_ingreso_access');
Route::get('almacenes/detalle/principal/{id}', 'DetalleValeController@crearOrdenxxx')->name('almacenes.detalle.principal')->middleware('can:almacen_ingreso_access');
Route::post('almacenes/detalle/principal/store', 'DetalleValeController@crearOrden')->name('almacenes.detalle.principal.store')->middleware('can:almacen_ingreso_access');
//Route::post('combustibles/detalle/principalorden', 'DetalleValeController@crearOrdendoc')->name('DetalleValeController.crearOrdendoc');
//Route::get('combustibles/detalle/{id}/destroyed2', 'DetalleValeController@destroyed2')->name('DetalleValeController.eliminar2');
Route::get('almacenes/detalle/aprovar/{id}', 'DetalleValeController@aprovar')->name('almacenes.detalle.aprovar')->middleware('can:almacen_ingreso_access');
Route::get('almacenes/detalle/solicitud/{id}', 'DetalleValeController@solicitud')->name('almacenes.detalle.solicitud')->middleware('can:almacen_ingreso_access');

Route::get('almacenes/detalle/delete/{id}', 'DetalleValeController@delete')->name('almacenes.detalle.delete')->middleware('can:almacen_ingreso_access');
Route::get('almacenes/detalle/editar/{id}', 'DetalleValeController@editar')->name('almacenes.detalle.editar')->middleware('can:almacen_ingreso_access');

Route::POST('almacenes/detalle/update', 'DetalleValeController@update')->name('almacenes.detalle.update')->middleware('can:almacen_ingreso_access');

});

Route::group(['namespace' => 'App\Http\Controllers\Almacen\Ingreso'], function() {


 Route::get('almacenes/ingreso/index', 'IngresoController@index')
 ->name('almacenes.ingreso.index')->middleware('can:almacen_ingreso_access');

 Route::get('almacenes/ingreso/{id}/editardoc', ['uses' => 'IngresoController@editardoc','as' => 'ingreso.editdoc'])->middleware('can:almacen_ingreso_access');
 Route::get('almacenes/ingreso/{id}/editararchivo', 'IngresoController@editararchivo')->name('IngresoController.editararchivo')->middleware('can:almacen_ingreso_access');
 Route::POST('almacenes/ingreso/{id}/updatearchivonota', 'IngresoController@updatearchivonota')->name('IngresoController.updatearchivonota')->middleware('can:almacen_ingreso_access');



 Route::get('almacenes/ingreso/{id}/createdocuconsumo', 'IngresoController@createdoc')->name('IngresoController.createdoc')->middleware('can:almacen_ingreso_access');
 Route::POST('almacenes/ingreso/insertar', 'IngresoController@insertar')->name('IngresoController.insertar')->middleware('can:almacen_ingreso_access');
 Route::get('almacenes/ingreso/grafico', 'IngresoController@grafico')->name('almacenes.ingreso.grafico')->middleware('can:almacen_ingreso_access');

 Route::get('almacenes/ingreso/detalle/{id}', 'IngresoController@detalle')->name('almacenes.ingreso.detalle')->middleware('can:almacen_ingreso_access');
 Route::get('almacenes/ingreso/solicitud/{id}', 'IngresoController@solicitud')->name('almacenes.ingreso.solicitud')->middleware('can:almacen_ingreso_access');

 Route::get('almacenes/ingreso/reporte', 'IngresoController@reporte')->name('almacenes.ingreso.reporte')->middleware('can:almacen_ingreso_access');
 Route::post('almacenes/ingreso/store2', 'IngresoController@store2')->name('almacenes.ingreso.store2')->middleware('can:almacen_ingreso_access');

 Route::get('almacenes/ingreso/delete2/{id}', 'IngresoController@delete')
 ->name('almacenes.ingreso.delete')->middleware('can:almacen_ingreso_access');

 Route::get('almacenes/ingreso/delete3/{id}', 'IngresoController@deletedos')
 ->name('almacenes.ingreso.deletedos')->middleware('can:almacen_ingreso_access');

 Route::get('almacenes/reporte/index', 'ReporteAreasController@index')
 ->name('almacenes.reporte.index')->middleware('can:almacen_ingreso_access');

 Route::post('almacenes/reporte/store', 'ReporteAreasController@store')
 ->name('almacenes.reporte.store')->middleware('can:almacen_ingreso_access');

 Route::get('almacenes/reporte/solicitud/{id}', 'ReporteAreasController@solicitud')->name('almacenes.reporte.solicitud')->middleware('can:almacen_ingreso_access');

 Route::get('almacenes/reporte/index2', 'ReporteAreasController@index2')
 ->name('almacenes.reporte.index2')->middleware('can:almacen_ingreso_access');

 Route::post('almacenes/reporte/store2', 'ReporteAreasController@store2')
 ->name('almacenes.reporte.store2')->middleware('can:almacen_ingreso_access');

 Route::get('almacenes/reporte/solicituddos/{id}', 'ReporteAreasController@solicituddos')->name('almacenes.reporte.solicituddos')->middleware('can:almacen_ingreso_access');

});


Route::group(['namespace' => 'Fexpo'], function() {


    Route::get('expochaco/pdf-reporte', 'SolicitudController@reporte')
    ->name('expochaco.reporte');



    Route::get('expochaco/index2', 'SolicitudController@index2')
    ->name('expochaco.index2');

    Route::get('expochaco/create', 'SolicitudController@create')
    ->name('expochaco.create');

    Route::post('expochaco/store', 'SolicitudController@store')
    ->name('expochaco.store');

    Route::get('expochaco/{id}/editar', 'SolicitudController@editar')
    ->name('expochaco.editar');


    Route::get('expochaco/imprimir/{id}', 'SolicitudController@imprimirboleta')
    ->name('expochaco.imprimir');

    Route::post('expochaco/update', 'SolicitudController@update')
    ->name('expochaco.update');

    Route::get('expochaco/delete2/{id}', 'SolicitudController@delete')
    ->name('expochaco.delete');

    Route::get('expochaco/aprovar/{id}', 'SolicitudController@aprovar')
    ->name('expochaco.aprovar');

    Route::get('expochaco/credenciales/{id}', 'SolicitudController@credencial')
    ->name('expochaco.credencial');

    Route::get('expochaco/credenciales/{id}', 'SolicitudController@credencial')
    ->name('expochaco.credencial');


    Route::get('expochaco/createcredencial/{id}', 'SolicitudController@createcredencial')->name('credencial.create');
    Route::POST('expochaco/insertarcredencial', 'SolicitudController@insertarcredencial')->name('credencial.insertarcredencial');

    Route::get('expochaco/generarqr/{id}', 'SolicitudController@codigoqr')
    ->name('expochaco.generarqr');


    Route::post('/ruta2', 'SolicitudController@respuesta2')->name('pregunta2');

    //Route::get('qrcode', function () {
       // return QrCode::size(300)->generate('A basic example of QR code!');
   // })->name('qrr');



   Route::get('expochaco3/index', 'SolicitudController2@index')
   ->name('expochaco3.index');

   Route::post('expochaco3/index2/{id}', 'SolicitudController2@update')
   ->name('employees.update');

   Route::get('expochaco3/index3/{id}', 'SolicitudController2@borrar')
   ->name('employees.destroy');

///////////
Route::get('derivacion/index', 'Recepcion2Controller@indexderivacion')->name('derivacion.index');
Route::get('derivacion/{id}/gestionarCorrespondencia', 'Recepcion2Controller@gestionarCorrespondencia2')->name('derivacion.gestionar');
Route::get('correspondencia2/urlfilederivacion/{id}', 'Recepcion2Controller@urlfile')->name('derivacion.urlfilederivacion');
Route::get('correspondencia2/pregunta', 'Recepcion2Controller@pregunta2')->name('derivacion.pregunta');
Route::get('/get-users', 'Recepcion2Controller@getUsers')->name('get-users');
Route::post('/ruta', 'Recepcion2Controller@respuesta')->name('pregunta');

});
