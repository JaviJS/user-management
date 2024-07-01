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
    public function logIn(LoginRequest $request)
    {
        $data = $this->authService->logIn($request);
        return response()->json($data->data, $data->status);
    }
    public function logOut(Request $request)
    {
        $data = $this->authService->logOut($request);
        return response()->json($data->data, $data->status); 
    }
}
