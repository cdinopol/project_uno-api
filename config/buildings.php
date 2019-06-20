<?php

/*
|--------------------------------------------------------------------------
| Building Configurations
|--------------------------------------------------------------------------
|
| Author: Carlo
| Created: 18 Jun 2019
| Updated: 18 Jun 2019
| Desc: Static configurations for buildings
|
*/

return [
    'GHQ' => [
		'name' 			=> 'General Head Quarter',
		'description' 	=> 'Manages all buiders and workers.',
		'start_level' 	=> 1,
		'max_level' 	=> 5,
		'build_time_data' => [
			60, 120, 200, 400, 500,
		] 
	],
	'FARM' => [
		'name' 			=> 'Farm',
		'description' 	=> 'Produces food.',
		'start_level' 	=> 1,
		'max_level' 	=> 3,
		'build_time_data' => [
			60, 120, 200,
		] 
	],
];