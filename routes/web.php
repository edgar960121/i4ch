<?php
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


/**
 * Rutas de accesos al sistema
 */

/*Consulta de usuarios*/
Route::get('/usuario/inicio/datosusuarios', 'FormularioU@busquedaUsuarios');
Route::post('/usuario/inicio/datosusuarios', 'FormularioU@validacion');

/*Baja de usuarios*/
Route::get('/usuario/inicio/bajas', 'FormularioU@bajausuario');
Route::post('/usuario/inicio/bajas', 'FormularioU@prueba');

/* Estadisticas */
Route::get('/usuario/inicio/estadisticaCredencial', 'FormularioU@estadistica');


/*Descarga de PDF*/
Route::match(['get','post'], '/usuario/inicio/downloadPDF', 'Descargar@enviar');
Route::post('/imprimirpdf','Descargar@obtieneReciboPDFHist');


/*credencial*/
Route::get('/usuario/inicio/credencial', 'Recibos\Archivos@redireccion');
//Route::post('/usuario/inicio/credencial', 'FormularioU@validacion');

Route::match(['get','post'],'/usuario/inicio','ViewRouting@inicio');

Route::get('/usuario/logout','ViewRouting@logout');
Route::get('/','ViewRouting@index');
Route::get('/login','ViewRouting@login');


/* Route::get('/encuesta', 'ViewRouting@encuesta');
Route::post('/dataEncuesta', 'ViewRouting@dataEncuesta'); */

Route::get('/cuestionario', 'ViewRouting@cuestionario');
Route::post('/cuestionarioAjax', 'ViewRouting@cuestionarioAjax');


Route::get('/credencial', 'ViewRouting@foto');
Route::post('/firma', 'ViewRouting@firma');
Route::get('/ocupacion', 'ViewRouting@ocupacion');
 

//ruta credencial
//Route::get('/credencial','Recibos\ViewRouting@firma');
/*
Route::get('/credencial', function () {

  //  return redirect('login');
 
    return view('fotografia');


});

Route::get('/credencial/fotografia', function () {

    return redirect('login');
 
   
});


/**
 * Rutas de Recibos
 */ 
    Route::match(['get','post'], '/usuario/recibo/listado', 'Recibos\ViewRouting@misRecibos');

    Route::group(['middleware'=>'permissions:Recibo_Admin|Recibo_AdminDGADP'],function(){
    Route::get('/usuario/recibo/admin', 'Recibos\ViewRouting@administrador');
    Route::match(['get', 'post'], '/usuario/recibo/buscarEnlace','Recibos\ViewRouting@buscarRecibosEnlace');//se agrega palabraEnlace para poder apuntar al historico)
    Route::get('/usuario/recibo/buscar','Recibos\ViewRouting@buscarRecibosAnio');   
});

    Route::get('/usuario/recibo/vista','Recibos\Archivos@notAllowed');
    Route::get('/usuario/recibo/xml','Recibos\Archivos@notAllowed');
    Route::get('/usuario/recibo/pdf','Recibos\Archivos@notAllowed');
    Route::get('/usuario/recibo/zip','Recibos\Archivos@notAllowed');

    Route::post('searchPdf','Recibos\Archivos@obtieneReciboPDF');
    Route::post('/usuario/recibo/vista','Recibos\Archivos@obtieneReciboVISTA');
    Route::post('/usuario/recibo/xml','Recibos\Archivos@obtieneReciboXML');
    Route::post('/usuario/recibo/pdf','Recibos\Archivos@obtieneReciboPDF');
    Route::post('/usuario/recibo/zip','Recibos\Archivos@obtieneReciboZIP');

/*-----------------------------------------------------------------------------------------------------*/
//Buscar Listado Recibos Enlace
Route::get('/usuario/recibo/buscarEnlace','Recibos\ViewRouting@buscarRecibosAnioEnlace');  
/*-----------------------------------------------------------------------------------------------------------*/

//Nueva vista
Route::get('/usuario/recibo/admin/link', 'Recibos\ViewRouting2@administrador');
Route::match(['get', 'post'], '/usuario/recibo/link','Recibos\ViewRouting2@buscarRecibosEnlace');


/**
 * Rutas de Recibos Historicos
 */ 
Route::match(['get','post'], '/historico/usuario/recibo/listado', 'Recibos\ViewRouting@misRecibosHist');

Route::group(['middleware'=>'permissions:Recibo_Admin|Recibo_AdminDGADP'],function(){
    Route::get('/historico/usuario/recibo/admin', 'Recibos\ViewRouting@administradorHist');
    Route::post('/historico/usuario/recibo/buscar','Recibos\ViewRouting@buscarRecibosHist');
    Route::get('/historico/usuario/recibo/buscar','Recibos\ViewRouting@buscarRecibosAnioHist');   
});

Route::get('/historico/usuario/recibo/vista','Recibos\Archivos@notAllowedHist');
Route::get('/historico/usuario/recibo/xml','Recibos\Archivos@notAllowedHist');
Route::get('/historico/usuario/recibo/pdf','Recibos\Archivos@notAllowedHist');
Route::get('/historico/usuario/recibo/zip','Recibos\Archivos@notAllowedHist');

Route::post('/historico/searchPdf','Recibos\Archivos@obtieneReciboPDFHist');
Route::post('/historico/usuario/recibo/vista','Recibos\Archivos@obtieneReciboVISTAHist');
Route::post('/historico/usuario/recibo/xml','Recibos\Archivos@obtieneReciboXMLHist');
Route::post('/historico/usuario/recibo/pdf','Recibos\Archivos@obtieneReciboPDFHist');
Route::post('/historico/usuario/recibo/zip','Recibos\Archivos@obtieneReciboZIPHist');


/**
 * Rutas de la cuenta
 */ 
Route::get('/usuario/informacion','ViewRouting@informacion');
Route::post('/usuario/cuenta/actualizar','Cuenta@actualizar');

/**
 * Rutas de administración del sistema
 */
Route::group(['middleware'=>'permissions:Admin_roles'],function(){
	Route::get('/usuario/admin/roles','ViewRouting@adminRoles');
	Route::post('/usuario/admin/roles','Admin\Main@getRoles');
	Route::post('/usuario/admin/usuarios','Admin\Main@getUsers');
	Route::post('/usuario/admin/usuariosRoles','Admin\Main@getUserRolesItems');
	Route::post('/usuario/admin/delRoles','Admin\Main@delUserRole');
	Route::post('/usuario/admin/addRoles','Admin\Main@addUserRole');
});

/**
 * Rutas de enlaces relacionados
 */
Route::get('/usuario/scgcdmx','ViewRouting@scgcdmx');

/**
 * Rutas de centro de atención a usuarios
 */
Route::group(['middleware'=>'permissions:Cau_Busqueda'],function(){
    Route::get('/usuario/cau/busqueda','Cau\ViewRouting@busquedaEmpleados');
    Route::post('/usuario/cau/busqueda','Cau\Main@buscaEmpleados');

    Route::get('/usuario/cau/actualizaMail','Cau\ViewRouting@busquedaEmpleados');
    Route::post('/usuario/cau/actualizaMail','Cau\Main@updateMail');
    Route::post('/usuario/cau/activar','Cau\Main@activarUsuario');
});

/**
 * Rutas de registro
 */
Route::get('/servicio/registro','Externo@registro');
Route::post('/servicio/registro','Externo@altaRegistro');
Route::get('/servicio/activacion','Externo@activacion');
Route::post('/servicio/activacion','Externo@activar');
Route::get('/servicio/cancelacion','Externo@cancelacion');
Route::post('/servicio/cancelacion','Externo@cancelar');
Route::get('/servicio/olvido','Externo@olvido');
Route::post('/servicio/olvido','Externo@hacerOlvido');
Route::get('/servicio/reenviar','Externo@reenvio');
Route::post('/servicio/reenviar','Externo@hacerReenvio');
Route::get('/servicio/recuperacion','Externo@recuperacion');
Route::post('/servicio/recuperacion','Externo@recuperar');

/**
 * Rutas de despliegue de información
 */
Route::get('/acerca-de/uso-del-sistema','Informacion@usoSistema');
Route::get('/acerca-de/quejas-y-sugerencias','Informacion@quejasSugerencias');
Route::get('/acerca-de/preguntas-frecuentes','Informacion@preguntasFrecuentes');
Route::get('/aviso-privacidad','Informacion@privacidad');
Route::get('/declaracion-veracidad','Informacion@veracidad');

/**
 * Rutas de Oficina Virtual
 */
Route::group(['middleware'=>'permissions:VirtualOffice_Principal'],function(){
    Route::get('/usuario/virtualoffice/main','VirtualOffice\ViewRouting@index');
    Route::get('/usuario/virtualoffice/logout','VirtualOffice\ViewRouting@logout');
});

Route::get('/virtualoffice/token','VirtualOffice\Main@generateToken');
Route::post('/virtualoffice/getToken','VirtualOffice\Main@getToken');

/**
 * Rutas de Tableros de Control
 */
Route::group(['middleware'=>'permissions:Dashboard_Participante'],function(){
    
});

Route::group(['middleware'=>'permissions:Dashboard_Lider'],function(){
    Route::get('/usuario/dashboard/process','Dashboard\ViewRouting@addProcess');
    Route::post('/usuario/dashboard/process','Dashboard\Main@addProcess');
    
});

Route::group(['middleware'=>'permissions:Dashboard_Lider|Dashboard_Participante'], function(){
    Route::get('/usuario/dashboard/processDetail','Dashboard\ViewRouting@main');
    Route::get('/usuario/dashboard/main','Dashboard\ViewRouting@main');
});















