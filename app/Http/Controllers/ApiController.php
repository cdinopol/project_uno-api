<?php

namespace App\Http\Controllers;

require_once base_path('app/Libraries/Constants.php');

use Laravel\Lumen\Routing\Controller as BaseController;
use Auth;

class ApiController extends BaseController
{
    protected $user;

    private $statusCode;

    /*
    * Auth: Carlo
    * Desc: create conroller instance, set user
    */
    public function __construct()
    {
    	try {
        	$this->user = Auth::userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
        	return response()->json(['user_not_found'], 404);
        }

        // set default
        $this->statusCode = 200;
    }

    /*
    * Auth: Carlo
    * Desc: set status code
    */
    protected function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;
		return $this;
	}

    /*
    * Auth: Carlo
    * Desc: standard response
    */
    protected function respond($data, $headers = [])
    {
    	return response()->json($data, $this->statusCode, $headers);
    }

    /*
    * Auth: Carlo
    * Desc: successful create, update, delete operations
    */
    protected function respondSuccess($message, $data = [])
	{
		return $this->setStatusCode(201)->respond([
			'message' => $message,
			'data' => $data
		]);
	}

	/*
    * Auth: Carlo
    * Desc: failed create, update, delete operations
    */
    protected function respondFailed($message, $data = [])
	{
		return $this->setStatusCode(202)->respond([
			'message' => $message,
			'data' => $data
		]);
	}

	/*
    * Auth: Carlo
    * Desc: invalid input format
    */
	protected function respondError($message)
	{
		return $this->setStatusCode(422)->respond([
			'message' => $message,
			'data' => ""
		]);
	}
}
