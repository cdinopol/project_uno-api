<?php

namespace App\Http\Controllers;

require_once base_path('app/Libraries/Constants.php');

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Auth;

class ApiController extends BaseController
{
    protected $user;
    protected $player_id;
    protected $db;

    private $status_code;

    /*
    * Auth: Carlo
    * Desc: create conroller instance, set user
    */
    public function __construct(Request $request)
    {
    	try {
        	$this->user = Auth::userOrFail();
            $this->player_id = $this->user->id;
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
        	return response()->json(['user_not_found'], 404);
        }

        // set default
        $this->status_code = 200;
    }

    /*
    * Auth: Carlo
    * Desc: standard response for get requests
    */
    protected function respond($data, $headers = [])
    {
    	return response()->json($data, $this->status_code, $headers);
    }

    /*
    * Auth: Carlo
    * Desc: set status code
    */
    protected function setstatusCode($status_code)
    {
        $this->status_code = $status_code;
        return $this;
    }

    /*
    * Auth: Carlo
    * Desc: successful post, put, delete operations
    */
    protected function respondSuccess($data = [], $message = '')
	{
		return $this->setstatusCode(201)->respond([
			'message' => $message,
			'data' => $data
		]);
	}

	/*
    * Auth: Carlo
    * Desc: failed post, put, delete operations
    */
    protected function respondFailed($message = 'Failed!', $data = [])
	{
		return $this->setstatusCode(202)->respond([
			'message' => $message,
			'data' => $data
		]);
	}

	/*
    * Auth: Carlo
    * Desc: invalid input format
    */
	protected function respondError($message = 'Dont do that boi!')
	{
		return $this->setstatusCode(422)->respond([
			'message' => $message,
			'data' => ""
		]);
	}
}
