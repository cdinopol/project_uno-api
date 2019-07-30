<?php
namespace App\Repositories\User;

use App\User;
use Illuminate\Support\Facades\DB;


class UserRepositoryImpl implements UserRepository
{
    public function __construct()
    {
    }

    public function createUser()
    {
    	$serial_token = $this->generateSerialToken();
    	$last_server = $this->getLatestServer();

    	$user_id = User::create([
            'serial_token' => $serial_token,
            'last_server' => $last_server,
            'role' => 1
        ])->id;

    	return compact('serial_token', 'user_id', 'last_server');
    }

    public function getLastServer($id)
    {
    	return User::where('id', $id)
    			->orWhere('serial_token', $id)
    			->value('last_server');
    }

    private function generateSerialToken() 
    {
    	$serial_token = mt_rand(10000000, 99999999) . uniqid();
        if (User::whereSerialToken($serial_token)->exists()) {
            return generateSerialToken();
        }

        return $serial_token;
    }

    private function getLatestServer() {
        return 's1';
    }
}