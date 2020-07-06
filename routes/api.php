<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
//Route::post('refreshtoken', 'API\UserController@refreshToken');

Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');

//Auth::routes(['verify' => true]);

Route::get('/unauthorized', 'API\UserController@unauthorized');

Route::group(['middleware' => ['CheckClientCredentials','auth:api']], function() {
    Route::post('logout', 'API\UserController@logout');
    Route::post('details', 'API\UserController@details');

    Route::post('planes','PlanesController@store');
    Route::put('planes','PlanesController@update');
    Route::delete('planes','PlanesController@destroy');

    Route::post('negocios','NegociosController@store');
    Route::put('negocios','NegociosController@update');
    Route::delete('negocios','NegociosController@destroy');

    Route::post('productos','ProductosController@store');
    Route::put('productos','ProductosController@update');
    Route::delete('productos','ProductosController@destroy');
});

Route::resource('planes','PlanesController',  ['only' => [
    'index', 'show'
]]);

Route::resource('negocios','NegociosController', ['only' => [
    'index', 'show'
]]);

Route::resource('productos','ProductosController', ['only' => [
    'index', 'show'
]]);
/* 
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */
