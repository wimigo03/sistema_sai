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



Route::group(['prefix'=>"admin",'as' => 'admin.','namespace' => 'App\Http\Controllers\Admin','middleware' => ['auth','AdminPanelAccess']], function () {

    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('/users', 'UserController');
    //Route::resource('/roles', 'RoleController');
    Route::get('roles/index', 'RoleController@index')->name('roles.index');
    Route::get('roles/indexAjax', 'RoleController@indexAjax')->name('roles.index.ajax');
    Route::get('roles/show/{id}', 'RoleController@show')->name('roles.show');
    Route::get('roles/edit/{id}', 'RoleController@edit')->name('roles.edit');
    Route::post('roles/udpate', 'RoleController@update')->name('roles.update');
    Route::put('roles/destroy', 'RoleController@destroy')->name('roles.destroy');
    Route::get('roles/create', 'RoleController@create')->name('roles.create');
    Route::post('roles/store', 'RoleController@store')->name('roles.store');
    Route::resource('/permissions', 'PermissionController')->except(['show']);

});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::group(['namespace' => 'App\Http\Controllers'], function() {
    //Compras medidas
    Route::get('compras/medidas/index', 'MedidaController@index')->name('medidas.index')->middleware('can:medidas_access');
    Route::get('compras/medidas/list', 'MedidaController@listado')->name('medidas.list');
    Route::get('compras/medidas/{id}/edit', 'MedidaController@editar')->name('medidas.edit');
    Route::post('compras/medidas/{id}/update', 'MedidaController@update')->name('medidas.update');
    Route::get('compras/medidas/create', 'MedidaController@create')->name('medidas.create');
    Route::post('compras/medidas/store', 'MedidaController@store')->name('medidas.store');


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Compras pedido
    /*Route::resource('compras/pedido', 'CompraController');*/
    Route::get('compras/pedido/index', 'CompraController@index')->name('compras.pedido.index');
    Route::get('compras/pedido/create', 'CompraController@create')->name('compras.pedido.create');
    Route::post('compras/pedido/store', 'CompraController@store')->name('compras.pedido.store');
    Route::get('compras/pedido/edit/{id}', 'CompraController@edit')->name('compras.pedido.edit');
    Route::get('compras/pedido/editar/{id}', 'CompraController@editar')->name('compras.pedido.editar');
    Route::post('compras/pedido/update', 'CompraController@update')->name('compras.pedido.update');
    //Compras detalle
    //Route::resource('compras/detalle', 'DetalleCompraController');
    //compras orden de compra

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    Route::get('compras/detalle/index', 'DetalleCompraController@index')->name('compras.detalle.index');
    Route::post('compras/detalle/store', 'DetalleCompraController@store')->name('compras.detalle.store');
    Route::get('compras/detalle/principal/{id}', 'DetalleCompraController@crearOrdenxxx')->name('compras.detalle.principal');
    Route::post('compras/detalle/principal/store', 'DetalleCompraController@crearOrden')->name('compras.detalle.principal.store');
    Route::get('compras/detalle/{id}/principalorden', 'DetalleCompraController@crearOrdendocxx')->name('compras.detalle.principalorden');
    Route::get('compras/detalle/show', 'DetalleCompraController@show')->name('compras.detalle.show');
    Route::post('compras/detalle/principalorden', 'DetalleCompraController@crearOrdendoc')->name('DetalleCompraController.crearOrdendoc');
    Route::get('compras/detalle/{id}/destroyed2', 'DetalleCompraController@destroyed2')->name('DetalleCompraController.eliminar2');
    Route::get('compras/delete/{id}', 'DetalleCompraController@delete')->name('compras.detalle.delete');

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Compras pedido
    Route::get('compras/detalle/invitacion/{id}', 'DetalleCompraController@invitacion')->name('compras.detalle.principal.invitacion');
    Route::get('compras/detalle/aceptacion/{id}', 'DetalleCompraController@aceptacion')->name('compras.detalle.principal.aceptacion');
    Route::get('compras/detalle/cotizacion/{id}', 'DetalleCompraController@cotizacion')->name('compras.detalle.principal.cotizacion');
    Route::get('compras/detalle/adjudicacion/{id}', 'DetalleCompraController@adjudicacion')->name('compras.detalle.principal.adjudicacion');
    Route::get('compras/detalle/orden/{id}', 'DetalleCompraController@orden')->name('compras.detalle.principal.orden');
    
    
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //compras partida
   // Route::resource('compras/partida', 'PartidaController');
    Route::get('compras/partida/index', 'PartidaController@index')->name('partida.index');
    Route::get('compras/partida/listado', 'PartidaController@listado')->name('partida.list');

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //compras producto
    //Route::resource('compras/productos', 'ProdServController');
    //Route::get('compras/productos/{id}/edit', ['uses' => 'ProdServController@editar','as' => 'productos.edit']);
    Route::get('compras/productos/index', 'ProdServController@index')->name('productos.index');
    Route::get('compras/productos/list', 'ProdServController@list')->name('producto.list');
    
    Route::get('compras/productos/{id}/edit', 'ProdServController@editar')->name('productos.edit');
    Route::POST('compras/productos/{id}/update', 'ProdServController@update')->name('productos.update');
    Route::get('compras/productos/create', 'ProdServController@create')->name('productos.create');
    Route::POST('compras/productos/store', 'ProdServController@store')->name('productos.store');

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //compras empleados
    //Route::resource('compras/empleados', 'EmpleadosController');
    Route::get('compras/empleados/index', 'EmpleadosController@index')->name('empleados.index');
    Route::get('compras/empleados/list', 'EmpleadosController@list')->name('empleados.list');
    //Route::get('compras/empleados/detalle/{id}', 'EmpleadosController@detalle')->name('empleados_detalle');
    // Route::get('compras/empleados/{id}/edit', 'EmpleadosController@edit')->name('empleados.edit');
    // Route::POST('compras/empleados/{id}/update', 'EmpleadosController@update')->name('empleados.update');
    // Route::get('compras/empleados/create', 'EmpleadosController@create')->name('empleados.create');
    //Route::POST('compras/empleados/store', 'EmpleadosController@store')->name('empleados.store');


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //rechumanos empleados planta
    //Route::resource('compras/empleados', 'EmpleadosController');
    Route::get('rechumanos/planta/index', 'PlantaController@index')->name('planta.index');
    Route::get('rechumanos/planta/list', 'PlantaController@list')->name('planta.list');
    Route::get('rechumanos/planta/detalle/{id}', 'PlantaController@detalle')->name('planta_detalle');
    Route::get('rechumanos/planta/edit/{id}', 'PlantaController@edit')->name('planta.edit');
    Route::get('rechumanos/planta/lista/{id}', 'PlantaController@lista')->name('planta.lista');
    Route::get('rechumanos/planta/create/{id}', 'PlantaController@plantanuevo')->name('planta.crear');
    Route::get('rechumanos/planta/edit/{id}', 'PlantaController@editarplanta')->name('planta.editar');
    Route::POST('rechumanos/planta/guardarplanta', 'PlantaController@guardarplanta')->name('planta.guardar');
    Route::POST('rechumanos/planta/actualizarplanta', 'PlantaController@actualizarPlanta')->name('planta.actualizar');
    Route::GET('rechumanos/planta/lista2', 'PlantaController@detallePlanta')->name('planta.listageneral');

    Route::get('rechumanos/planta/delete/{id}', 'PlantaController@editarplanta2')->name('planta.editar2');
    Route::POST('rechumanos/planta/deletePlanta', 'PlantaController@deletePlanta')->name('planta.delete');
   
    // Route::POST('rechumanos/planta/{id}/update', 'EmpleadosController@update')->name('empleados.update');
    // Route::get('rechumanos/planta/create', 'EmpleadosController@create')->name('empleados.create');
    //Route::POST('rechumanos/planta/store', 'EmpleadosController@store')->name('empleados.store');

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//rechumanos empleados contrato
   //Route::resource('compras/empleados', 'EmpleadosController');
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

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //compras proveedores
    // Route::get('compras/proveedores/{id}/createdoc', 'ProveedoresController@createdoc');
    //Route::get('compras/proveedores/{id}/createdocproveedor', 'ProveedoresController@createdoc');
    //Route::get('compras/proveedores/{id}/editardoc', 'ProveedoresController@editardoc');
    //Route::POST('insertar', [ProveedoresController::class,'insertar']);
    //Route::resource('compras/proveedores', 'ProveedoresController');

    Route::get('compras/proveedores/index', 'ProveedoresController@index')->name('proveedores.index')->middleware('can:proveedores_access');
    Route::get('compras/proveedores/list', 'ProveedoresController@list')->name('proveedores.list')->middleware('can:proveedores_access');
    Route::get('compras/proveedores/{id}/edit', 'ProveedoresController@edit')->name('proveedores.edit')->middleware('can:proveedores_access');
    Route::POST('compras/proveedores/{id}/update', 'ProveedoresController@update')->name('proveedores.update')->middleware('can:proveedores_access');
    Route::get('compras/proveedores/create', 'ProveedoresController@create')->name('proveedores.create')->middleware('can:proveedores_access');
    Route::POST('compras/proveedores/store', 'ProveedoresController@store')->name('proveedores.store')->middleware('can:proveedores_access');
    Route::get('compras/proveedores/{id}/editardoc', ['uses' => 'ProveedoresController@editardoc','as' => 'Proveedores.editdoc'])->middleware('can:proveedores_access');
    Route::get('compras/proveedores/{id}/createdocproveedor', 'ProveedoresController@createdoc')->name('ProveedoresController.createdoc')->middleware('can:proveedores_access');
    Route::POST('compras/proveedores/insertar', 'ProveedoresController@insertar')->name('ProveedoresController.insertar')->middleware('can:proveedores_access');

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //compras areas
    //Route::resource('compras/areas', 'AreasController');
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
    //Route::Get('productByCategory/{id}', 'AreasController@byCategory');
    
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //compras programas
    //Route::resource('compras/programas', 'ProgramaController');
    Route::get('compras/programas/index', 'ProgramaController@index')->name('programas.index')->middleware('can:programas_access');
    Route::get('compras/programas/list', 'ProgramaController@listado')->name('programas.list')->middleware('can:programas_access');
    Route::get('compras/programas/{id}/edit', 'ProgramaController@edit')->name('programas.edit')->middleware('can:programas_access');
    Route::POST('compras/programas/{id}/update', 'ProgramaController@update')->name('programas.update')->middleware('can:programas_access');
    Route::get('compras/programas/create', 'ProgramaController@create')->name('programas.create')->middleware('can:programas_access');
    Route::POST('compras/programas/store', 'ProgramaController@store')->name('programas.store')->middleware('can:programas_access');

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //compras categorias prograticas
    //Route::resource('compras/catprog', 'CatProgController');
    Route::get('compras/catprog/index', 'CatProgController@index')->name('catprog.index')->middleware('can:catprog_access');
    Route::get('compras/catprog/list', 'CatProgController@listado')->name('catprog.list')->middleware('can:catprog_access');
    Route::get('compras/catprog/{id}/edit', 'CatProgController@editar')->name('catprog.edit')->middleware('can:catprog_access');
    Route::POST('compras/catprog/{id}/update', 'CatProgController@update')->name('catprog.update')->middleware('can:catprog_access');
    Route::get('compras/catprog/create', 'CatProgController@create')->name('catprog.create')->middleware('can:catprog_access');
    Route::POST('compras/catprog/store', 'CatProgController@store')->name('catprog.store')->middleware('can:catprog_access');



    //ACTIVOS FIJOS
    Route::get('activosFijos/activos', 'ActivosController@index')->name('activos.index');

    //Discapacidad
    Route::get('canasta/entrega/index', 'CanastaEntregaController@index')->name('canasta.entrega.index');//->middleware('can:canasta.entrega.index');
    Route::get('canasta/entrega/search', 'CanastaEntregaController@search')->name('canasta.entrega.search');//->middleware('can:canasta.entrega.index');
    Route::get('canasta/pendientes/index', 'CanastaPendientesController@index')->name('canasta.pendientes.index');//->middleware('can:canasta.entrega.index');
    Route::get('canasta/pendientes/search', 'CanastaPendientesController@search')->name('canasta.pendientes.search');//->middleware('can:canasta.entrega.index');
    Route::get('canasta/pendientes/search-detalle', 'CanastaPendientesController@searchdetalle')->name('canasta.pendientes.search.detalle');//->middleware('can:canasta.entrega.index');
    Route::get('canasta/pendientes/search-detalle-pdf', 'CanastaPendientesController@searchdetallepdf')->name('canasta.pendientes.search.detallepdf');//->middleware('can:canasta.entrega.index');

    Route::get('activosvsiaf/index', 'ActivosVsiafController@index')->name('activos.vsiaf.index');//->middleware('can:canasta.entrega.index');
    Route::get('activosvsiaf/search', 'ActivosVsiafController@search')->name('activos.vsiaf.search');//->middleware('can:canasta.entrega.index');
});