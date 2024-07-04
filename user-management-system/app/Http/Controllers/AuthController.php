<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Login de un usuario.
     *
     * @param  LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function logIn(LoginRequest $request)
    {
        $data = $this->authService->logIn($request);
        return response()->json($data->data, $data->status);
    }
    /**
     * Logout de un usuario.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logOut(Request $request)
    {
        $data = $this->authService->logOut($request);
        return response()->json($data->data, $data->status);
    }
}
