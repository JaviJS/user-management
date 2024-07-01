<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Services\UserService;
class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $data = $this->userService->all();
        return response()->json($data->data, $data->status);
    }

    public function show($id)
    {
        $data = $this->userService->find($id);
        return response()->json($data->data, $data->status);
    }
    
    public function create()
    {
    }


    public function store(CreateUserRequest $request)
    {
        $data = $this->userService->create($request);
        return response()->json($data->data, $data->status);
    }

    public function edit($id)
    {
      //
    }

  
    public function update(UpdateUserRequest $request, $id)
    {
        $data = $this->userService->update($request, $id);
        return response()->json($data->data, $data->status);
    }

    public function destroy($id)
    {
        $data = $this->userService->delete($id);
        return response()->json($data->data, $data->status); 
    }

    public function listRoles()
    {
        $data = $this->userService->listRoles();
        return response()->json($data->data, $data->status);
    }
    public function listStatus()
    {
        $data = $this->userService->listStatus();
        return response()->json($data->data, $data->status); 
    }
    public function changePassword(UpdatePasswordRequest $request, $id)
    {
        $data = $this->userService->changePassword($request, $id);
        return response()->json($data->data, $data->status); 
    }
}
