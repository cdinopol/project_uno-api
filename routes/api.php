<?php

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

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

	// Auth - public access
	$api->group([
		'namespace' => 'App\Http\Controllers\Auth',
	], function($api) {

	    $api->post('/auth/register', [
	        'as' => 'api.auth.register',
	        'uses' => 'AuthController@postRegister',
	    ]);

		$api->post('/auth/login', [
	        'as' => 'api.auth.login',
	        'uses' => 'AuthController@postLogin',
	    ]);
	});

	// Functions - secured access
	$api->group([
		'middleware' => ['api.auth', 'select_server'],
		'namespace' => 'App\Http\Controllers',
		'prefix' => '{game_server}',
	], function($api) {

		$api->get('/test', 'ExampleController@test');

		$api->get('/user_test', 'ExampleController@get_user_id');
	});


	// tests
	$api->post('/test', 'App\Http\Controllers\ExampleController@test');
});