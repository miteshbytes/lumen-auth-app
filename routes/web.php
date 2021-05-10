<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {
    // Matches "/api/register
    $router->post('register', 'AuthController@register');

    // Matches "/api/login
    $router->post('login', 'AuthController@login');
});

$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {
   
    $router->get('products', 'ProductController@index');
    $router->post('product/create', 'ProductController@store');
    $router->get('product/{id}', 'ProductController@show');
    $router->delete('product/{id}', 'ProductController@destroy');
    $router->put('product/{id}', 'ProductController@update');
});


/* Step JWT setup*/

// https://jwt-auth.readthedocs.io/en/develop/lumen-installation/

// https://dev.to/ndiecodes/build-a-jwt-authenticated-api-with-lumen-2afm


/* CORS Error Solution  Middleware Create */

//https://www.codementor.io/@chiemelachinedum/steps-to-enable-cors-on-a-lumen-api-backend-e5a0s1ecx


// composer require flipbox/lumen-generator  ||  and register in bootstrap\app.php file  (LumenGeneratorServiceProvider)
