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
		'prefix' => 'auth'
	], function($api) {

	    $api->post('/register', 'AuthController@postRegister');
		$api->post('/login', 'AuthController@postLogin');
	});

	// Functions - secured access
	$api->group([
		'middleware' => ['api.auth', 'select_server'],
		'namespace' => 'App\Http\Controllers',
		'prefix' => '{game_server}',
	], function($api) {

		// Player
		$api->get('players', 'PlayerController@getPlayers');
		$api->get('player[/{id}]', 'PlayerController@getPlayer');

		// Campaign
		$api->get('campaigns', 'CampaignController@getCampaigns');
		$api->get('campaign[/{id}]', 'CampaignController@getCampaign');
		$api->get('campaign/verify_win', 'CampaignController@verifyWin');

		// Characters
		$api->get('chars', 'CharController@getChars');
		$api->get('char[/{id}]', 'CharController@getChar');
	});
});