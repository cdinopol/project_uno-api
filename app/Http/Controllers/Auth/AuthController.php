<?php

namespace App\Http\Controllers\Auth;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use App\Repositories\User\UserRepository;

class AuthController extends BaseController
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;
    private $rUser;

    public function __construct(JWTAuth $jwt, UserRepository $rUser)
    {
        $this->jwt = $jwt;
        $this->rUser = $rUser;
    }

    public function postRegister()
    {
        $user_data = $this->rUser->createUser();
        return response()->json($user_data);
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'serial_token'    => 'required|max:255',
        ]);

        try {
            if (!$token = $this->jwt->attempt($request->only(['serial_token', 'password']))) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], 500);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], 500);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent' => $e->getMessage()], 500);
        }

        // server
        $server = $this->rUser->getLastServer($request->input('serial_token'));

        return response()->json(compact('token', 'server'));
    }

    
}