<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/registro', 'Registro@registro');
Route::get('/registro/entidades', 'Registro@entidadesMunicipios');
Route::get('/get/poblacion/{idCandidato}', 'Controller@getPoblacion');
Route::get('/get/simpatizantes/{idCandidato}', 'Controller@getSimpatizantes');

# Funciona para coordinadores NO FUNCIONA CORRECTAMENTE
Route::get('/get/municipios/{idEntidad}/{idCandidato}', 'Controller@getMunicipios');


Route::get('/get/secciones/{entidad}/{claveMunicipio}/{candidato}', 'Controller@getSecciones');
Route::get('/get/municipio/candidato/{id}', 'Controller@getMunicipiosCandidato');

#demarcaciones por municipio
Route::get('/get/demarcaciones/{municipio_id}', 'Controller@consultaDemarcacionesCandidato');

Route::get('/get/candidatos/all', 'Controller@getCandidatos');
Route::post('/login', 'Users\UsersController@login');
Route::get('/comprueba/cve/electoral', 'Simpatizantes@compruebaClave');

//busqueda dinámica en el padrón
Route::get('/padron', 'Simpatizantes@busquedaPadron');


# USUARIO
Route::get('/secciones/usuario/{id}', 'Busquedas\BusquedasCandidatos@getSeccionesUsuario');
Route::get('/demarcaciones/usuario/{id}', 'Busquedas\BusquedasCandidatos@getDemarcacionesUsuario');

Route::get('/entidades', 'Busquedas\BusquedasCandidatos@entidadesFederativas');
Route::post('/solicita/cambio/pass', 'Controller@solicitaCambioPass');
Route::post('/cambiar/password', 'Controller@cambiarContrasena');

# CANDIDATO
Route::get('/candidato/{id}/{entidad}/grafica/municipios/{filter}', 'Graficas@candidatoMunicipios');
Route::get('/candidato/{id}/{entidad}/{municipio_id}/secciones', 'Busquedas\BusquedasCandidatos@candidatoSecciones');

/** TEST ROUTES FOR GOAL */
Route::get('/tipos-simpatizantes', 'TypeSympathizerController@index');

    #Exportación
Route::get('/candidato/{id}/encuesta/exportar', 'ExportController@exportarEncuestaBy');
Route::get('/candidato/{id}/descargar/layout', 'ExportController@descargarLayout');
    #Importacion de datos
Route::post('/candidato/{id}/padron/importar', 'ImportController@importPadron');

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/logout', 'Users\UsersController@logout');
    
    Route::get('/colonias/{cve_municipio}', 'Busquedas\BusquedasCandidatos@getColonias');
    Route::get('/municipios/{entidad}', 'Busquedas\BusquedasCandidatos@getMunicip');
    Route::get('/secciones/{cve_municipio}/{colonia}', 'Busquedas\BusquedasCandidatos@getColoniasSecciones');


    Route::post('/registro/poblacion', 'Simpatizantes@registroPoblacion');
    Route::delete('/poblacion/{id}', 'Simpatizantes@delete');
    Route::put('/poblacion/{cve}', 'Simpatizantes@updatePoblacion');
    Route::post('/registro/simpatizante', 'Simpatizantes@registroSimpatizante');
    
    # catalogo relacionado al candidato
    Route::get('/candidato/{id}/entidades', 'Busquedas\BusquedasCandidatos@candidatoEntidades');
    Route::get('/candidato/{id}/{entidad}/municipios', 'Busquedas\BusquedasCandidatos@candidatoMunicipios');
    Route::get('/candidato/{id}/{entidad}/{municipio_id}/secciones', 'Busquedas\BusquedasCandidatos@candidatoSecciones');
    Route::get('/candidato/{id}/{entidad}/{municipio_id}/{seccion_id}/poblacion', 'Busquedas\BusquedasCandidatos@candidatoPoblacion');

    Route::get('/candidato/{id}/coordinadores', 'Busquedas\BusquedasCandidatos@getCoordinadores');
    Route::get('/candidato/{id}/simpatizantes', 'Busquedas\BusquedasCandidatos@getSimpatizan');
    
    
    //GRAFICAS
    Route::get('/candidato/{id}/{entidad}/grafica/municipios/{municipio}/{filter}', 'Graficas@candidatoMunicipiosFiltro');
    Route::get('/candidato/{id}/{entidad}/{municipio_id}/{seccion_id}/graficas/{filter}', 'Graficas@consultaSimpatizantesDataSeccion');

    Route::get('/candidato/{id}/simpatizantesBy', 'GoalController@getSimpatizantesByType');
    Route::get('/candidato/{id}/countSimpatizantes', 'GoalController@countSimpatizantes');
    

    //GOALS
    Route::post('/usuario/{id}/metas', 'GoalController@store');    
    Route::delete('/metas/{id}', 'GoalController@destroy');
    Route::put('/metas/{id}', 'GoalController@update');
    Route::get('/candidato/{id}/metas/seccion', 'GoalController@getMetasPorSeccion');
    Route::get('/candidato/{id}/metas/demarcacion', 'GoalController@getMetasPorDemarcacion');
    Route::get('/candidato/{id}/metas', 'GoalController@goalCounter');

    //TEAMS
    Route::get('/teams', 'TeamController@index');
    Route::get('/teams/{id}', 'TeamController@show');
    Route::post('/teams', 'TeamController@store');
    Route::put('/teams/{id}', 'TeamController@update');
    Route::post('/teams/{id}', 'TeamController@destroy');
    #special routes for teams
    Route::get('candidato/{candidato_id}/teams', 'TeamController@showTeamsByCandidato');
    Route::get('candidato/{candidato_id}/teams/{team_id}', 'TeamController@showTeamMembers');
    Route::put('candidato/{candidato_id}/teams/{team_id}/add', 'TeamController@addToTeam');
    Route::put('candidato/{candidato_id}/teams/{team_id}/dettach', 'TeamController@dettachToTeam');


    #graficas de productividad
    Route::get('candidato/{candidato_id}/productivity', 'ProductivityController@getEncuestadores');
    Route::get('/candidato/{id}/entidad/{entidad_id}/municipio/{municipio_id}/simpatizantes/seccion', 'GoalController@getSimpatizantesMetas');
    Route::get('/candidato/{id}/entidad/{entidad_id}/municipio/{municipio_id}/simpatizantes/demarcacion', 'GoalController@getSimpatizantesMetasDemarcacion');

    #Imports 
    Route::get('/candidato/{id}/logs', 'ImportController@byCandidato');
});
