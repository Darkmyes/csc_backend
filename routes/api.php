<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::get('email/verify/{id}/{hash}','API\UserController@verifyUser')->name('verification.verify');
//Route::get('validar_email/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');

//Route::post('refreshtoken', 'API\UserController@refreshToken');

/* Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
 */

Route::group(['middleware' => ['CheckClientCredentials','auth:api']], function() {
    Route::post('logout', 'API\UserController@logout');
    Route::post('details', 'API\UserController@details');
    Route::post('usuario/cambiar_pass', 'API\UserController@cambiarPass');
});
// TIPOS DE USUARIO
Route::resource('tipo_usuario','TipoUsuarioController',  ['only' => [
    'index','show','store','update','destroy'
]]);

// ACTIVIDADES DE LA CUARENTENA
Route::resource('actividades_cuarentena','ActividadesCuarentenaController',  ['only' => [
    'index','store','update','destroy'
]]);
Route::get('actividades_cuarentena/{id}','ActividadesCuarentenaController@byUsuario');

// ALIMENTOS DE LA CUARENTENA
Route::resource('alimentos_cuarentena','AlimentosCuarentenaController',  ['only' => [
    'index','store','update','destroy'
]]);
Route::get('alimentos_cuarentena/{id}','AlimentosCuarentenaController@byUsuario');

// ALERGIAS
Route::resource('alergias','AlergiasController',  ['only' => [
    'index','show','store','update','destroy'
]]);
Route::get('alergias/nombre/{busq}','AlergiasController@porNombre');

// ENFERMEDADES
Route::resource('enfermedades','EnfermedadesController',  ['only' => [
    'index','show','store','update','destroy'
]]);
Route::get('enfermedades/nombre/{busq}','EnfermedadesController@porNombre');

// ESTILOS DE VIDA
Route::resource('estilos_vida','EstilosVidaController',  ['only' => [
    'index','show','store','update','destroy'
]]);
Route::get('estilos_vida/nombre/{busq}','EstilosVidaController@porNombre');

// CATEGORIAS DE ALIMENTOS
Route::resource('categorias_alimento','CategoriaAlimentoController',  ['only' => [
    'index','show','store','update','destroy'
]]);
Route::get('categorias_alimento/nombre/{busq}','CategoriaAlimentoController@porNombre');

// PREFERENCIAS
Route::resource('preferencias','PreferenciasController',  ['only' => [
    'index','store'
]]);
Route::put('preferencias/usuario/{id_usuario}/categoria/{id_cat_al}','PreferenciasController@update');
Route::delete('preferencias/usuario/{id_usuario}/categoria/{id_cat_al}','PreferenciasController@destroy');
Route::get('preferencias/usuario/{id_usuario}/categoria/{id_cat_al}','PreferenciasController@show');
Route::get('preferencias/usuario/{id_usuario}','PreferenciasController@porUsuario');

// ALERGIAS DEL USUARIO
Route::resource('alergias_usuario','AlergiasUsuarioController',  ['only' => [
    'index','store'
]]);
Route::delete('alergias_usuario/usuario/{id_usuario}/alergia/{id_cat_al}','AlergiasUsuarioController@destroy');
Route::get('alergias_usuario/usuario/{id_usuario}/alergia/{id_cat_al}','AlergiasUsuarioController@show');
Route::get('alergias_usuario/usuario/{id_usuario}','AlergiasUsuarioController@porUsuario');

// ENFERMEDADES DEL USUARIO
Route::resource('enfermedades_usuario','EnfermedadesUsuarioController',  ['only' => [
    'index','store'
]]);
Route::delete('enfermedades_usuario/usuario/{id_usuario}/enfermedad/{id_cat_al}','EnfermedadesUsuarioController@destroy');
Route::get('enfermedades_usuario/usuario/{id_usuario}/enfermedad/{id_cat_al}','EnfermedadesUsuarioController@show');
Route::get('enfermedades_usuario/usuario/{id_usuario}','EnfermedadesUsuarioController@porUsuario');

// ESTILOS DE VIDA DEL USUARIO
Route::resource('estilos_vida_usuario','EstilosVidaUsuarioController',  ['only' => [
    'index','store'
]]);
Route::delete('estilos_vida_usuario/usuario/{id_usuario}/estilo_vida/{id_cat_al}','EstilosVidaUsuarioController@destroy');
Route::get('estilos_vida_usuario/usuario/{id_usuario}/estilo_vida/{id_cat_al}','EstilosVidaUsuarioController@show');
Route::get('estilos_vida_usuario/usuario/{id_usuario}','EstilosVidaUsuarioController@porUsuario');

// BAR
Route::resource('bares','BarController',  ['only' => [
    'index','show','store','destroy'
]]);
Route::post('bares/update/{id}','BarController@update');
Route::get('bares/nombre/{busq}','BarController@porNombre');
Route::get('bares/usuario/{id_usuario}','BarController@porUsuario');

// PRODUCTO
Route::resource('productos','ProductoController',  ['only' => [
    'index','show','store','update','destroy'
]]);
Route::get('productos/nombre/{busq}','ProductoController@porNombre');

// CALIFICACION
Route::resource('calificaciones','CalificacionController',  ['only' => [
    'index','store'
]]);
Route::put('calificaciones','CalificacionController@update');
Route::delete('calificaciones/bar/{id_bar}/usuario/{id_usuario}','CalificacionController@destroy');
Route::get('calificaciones/bar/{id_bar}/usuario/{id_usuario}','CalificacionController@show');
Route::get('calificaciones/bar/{id_bar}','CalificacionController@porBar');

// LISTA PRODUCTOS DEL BAR
Route::resource('lista_productos','ListaProductosController',  ['only' => [
    'index','store'
]]);
Route::put('lista_productos','ListaProductosController@update');
Route::delete('lista_productos/bar/{id_bar}/producto/{id_producto}','ListaProductosController@destroy');
Route::delete('lista_productos/bar/{id_bar}/producto/{id_producto}','ListaProductosController@destroy');
Route::get('lista_productos/bar/{id_bar}/producto/{id_producto}','ListaProductosController@show');
Route::get('lista_productos/bar/{id_bar}','ListaProductosController@porBar');

// MENÚ DEL DÍA
Route::resource('menu_diario','MenuDiarioController',  ['only' => [
    'index','store','update','destroy'
]]);
Route::get('menu_diario/bar/{id_bar}/fecha/{fecha}','MenuDiarioController@porBarFecha');
Route::get('menu_diario/bar/{id_bar}','MenuDiarioController@porBar');
Route::get('menu_diario/fecha/{fecha}','MenuDiarioController@porFecha');

// PRODUCTO CATEGORIA
Route::resource('productos_categoria','ProductoCategoriaController',  ['only' => [
    'index','store'
]]);
Route::delete('productos_categoria/categoria/{id_categoria}/producto/{id_producto}','ProductoCategoriaController@destroy');
Route::get('productos_categoria/categoria/{id_categoria}/producto/{id_producto}','ProductoCategoriaController@show');
Route::get('productos_categoria/categoria/{id_categoria}','ProductoCategoriaController@porCategoria');
Route::get('productos_categoria/producto/{id_producto}','ProductoCategoriaController@porProducto');

// COMPONENTES
Route::resource('componentes','ComponenteController',  ['only' => [
    'index','store','update','show','destroy'
]]);
Route::get('componentes/nombre/{busq}','ComponenteController@porNombre');

// COMPONENTES PRODUCTO
Route::resource('componentes_producto','ProductosComponentesController',  ['only' => [
    'index','store'
]]);
Route::delete('componentes_producto/producto/{id_producto}/componente/{id_componente}','ProductosComponentesController@destroy');
Route::get('componentes_producto/producto/{id_producto}/componente/{id_componente}','ProductosComponentesController@show');
Route::get('componentes_producto/producto/{id_producto}','ProductosComponentesController@porProducto');
Route::get('componentes_producto/producto/{id_producto}/nombre/{nombre}','ProductosComponentesController@porProductoNombre');
Route::get('componentes_producto/componente/{id_componente}','ProductosComponentesController@productoPorComponente');
Route::get('componentes_producto/componente/{id_componente}/nombre/{nombre}','ProductosComponentesController@productoPorComponenteNombre');

// RESTRICCIONES
Route::resource('restricciones','RestriccionesController',  ['only' => [
    'index','store','show','update','destroy'
]]);
Route::get('restricciones/causante/{causante}','RestriccionesController@porCausante');
Route::get('restricciones/restriccion/{restriccion}','RestriccionesController@porRestriccion');
Route::get('restricciones/causante/{causante}/nombre/{nombre}','RestriccionesController@porCausanteNombre');
Route::get('restricciones/restriccion/{restriccion}/nombre/{nombre}','RestriccionesController@porRestriccionNombre');
