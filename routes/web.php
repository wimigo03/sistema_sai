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
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\CorrespondenciaController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\CorrespondenciaLocalController;
use App\Http\Controllers\ControllerEvent2;
use App\Http\Controllers\ControllerAgendaEjecutivo;
use App\Http\Controllers\CanastaBeneficiariosController;
use App\Http\Controllers\ExpoController;
/* use App\Http\Controllers\Fexpo\SolicitudController; */
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

Route::get('/', function () {
    //return redirect()->away('https://www.granchaco.gob.bo');
    if (Auth::check()) {
        return redirect()->route('home.index');
    }
    return view('auth.login');
});

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');

Route::middleware(['auth'])->group(function () {
    Route::get('admin/', 'Admin\HomeController@index')->name('home.index');

    Route::group(['as' => 'admin.'], function () {
        //Route::get('admin/roles/index', 'Admin\RoleController@index')->name('roles.index');
        //Route::get('admin/roles/create', 'Admin\RoleController@create')->name('roles.create');
    });

    Route::get('/compras/medidas/create', [MedidaController::class, 'create'])->name('medidas.create');
    Route::get('rechumanos/planta/lista2', [PlantaController::class, 'detallePlanta'])->name('planta.listageneral');
    Route::get('rechumanos/planta/lista2/show/{id}', [PlantaController::class, 'detallePlantaShow'])->name('planta.listageneral.show');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    //Route::get('/', [HomeController::class, 'index'])->name('home');
    //////////////////////////////////////  MEDIDAS  //////////////////////////////////////////////////////////////////////

    Route::get('compras/medidas/index', [MedidaController::class,'index'])->name('medidas.index')->middleware('can:medidas_access');
    Route::get('compras/medidas/list', [MedidaController::class,'listado'])->name('medidas.list');
    Route::get('compras/medidas/{id}/edit', [MedidaController::class,'editar'])->name('medidas.edit');
    Route::post('compras/medidas/{id}/update', [MedidaController::class,'update'])->name('medidas.update');
    Route::get('compras/medidas/create',[MedidaController::class,'create'])->name('medidas.create');
    Route::post('compras/medidas/store', [MedidaController::class,'store'])->name('medidas.store');

    /////////////////////////--COMPRAS PEDIDO--////////////////////////////////////////////////////////////////////////////

    Route::get('compras/pedido/index', [CompraController::class,'index'])->name('compras.pedido.index');
    Route::get('compras/pedido/index2', [CompraController::class,'index2'])->name('compras.pedido.index2');
    Route::get('compras/pedido/create', [CompraController::class,'create'])->name('compras.pedido.create');
    Route::post('compras/pedido/store', [CompraController::class,'store'])->name('compras.pedido.store');
    Route::get('compras/pedido/edit/{id}', [CompraController::class,'edit'])->name('compras.pedido.edit');
    Route::get('compras/pedido/editar/{id}', [CompraController::class,'editar'])->name('compras.pedido.editar');
    Route::post('compras/pedido/update', [CompraController::class,'update'])->name('compras.pedido.update');

    ///////////////////////////////--COMPRAS DETALLE--///////////////////////////////////////////////////////////////////////
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

    ////////////////////////////--COMPRAS PRODUCTO--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    Route::get('compras/productos/index', [ProdServController::class,'index'])->name('productos.index');
    Route::get('compras/productos/list', [ProdServController::class,'list'])->name('producto.list');
    Route::get('compras/productos/{id}/edit', [ProdServController::class,'editar'])->name('productos.edit');
    Route::POST('compras/productos/{id}/update', [ProdServController::class,'update'])->name('productos.update');
    Route::get('compras/productos/create', [ProdServController::class,'create'])->name('productos.create');
    Route::POST('compras/productos/store', [ProdServController::class,'store'])->name('productos.store');

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
    Route::get('Activo/oficina/create/{id}', [OficinaController::class, 'create'])->name('activo.oficina.create')->middleware('can:oficina_access');

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


    /* Route::get('Activo/configuracion', [ConfiguracionController::class, 'index'])->name('activo.configuracion.index');
    Route::post('Activo/configuracion/general', [ConfiguracionController::class, 'guardarConfiguracionGeneral'])->name('configuracion.general.guardar');
    Route::get('Activo/configuracion/usuarios', [ConfiguracionController::class, 'usuarios'])->name('configuracion.usuarios'); */

});

Route::get('activosFijos/activos', 'ActivosController@index')->name('activos.index');
////////////////////////////////--DISCAPACIDAD--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('canasta/entrega/index', [CanastaEntregaController::class,'index'])->name('canasta.entrega.index');//->middleware('can:canasta.entrega.index');
Route::get('canasta/entrega/search', [CanastaEntregaController::class,'search'])->name('canasta.entrega.search');//->middleware('can:canasta.entrega.index');

Route::get('activosvsiaf/index', [ActivosVsiafController::class,'index'])->name('activos.vsiaf.index');//->middleware('can:canasta.entrega.index');
Route::get('activosvsiaf/search', [ActivosVsiafController::class,'search'])->name('activos.vsiaf.search');//->middleware('can:canasta.entrega.index');

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

/**CANASTA V2*/
Route::get('distritos/', 'Canasta_v2\DistritosV2Controller@index')->name('distritos.index');
   Route::get('personerias/index', [PersoneriasController::class,'index'])->name('personerias.index');
   Route::get('personerias/index2', [PersoneriasController::class,'indexantiguo'])->name('personerias.index2');
   Route::get('personerias/index3', [PersoneriasController::class,'indexActualizada'])->name('personerias.index3');
   Route::post('personerias/index2/{id}', [PersoneriasController::class,'update'])->name('personerias.update');
   Route::get('personerias/index3/{id}', [PersoneriasController::class,'borrar'])->name('personerias.destroy');
   Route::post('personerias/index4', [PersoneriasController::class,'create'])->name('personerias.create');
   Route::post('personerias/index5/{id}', [PersoneriasController::class,'create2'])->name('personerias.create2');
});
