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

    /**
     * Listar todos los usuarios.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->userService->all();
        return response()->json($data->data, $data->status);
    }

    /**
     * Mostrar un usuario.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->userService->find($id);
        return response()->json($data->data, $data->status);
    }

    public function create()
    {
    }

    /**
     * Crear un usuario.
     *
     * @param CreateUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $data = $this->userService->create($request);
        return response()->json($data->data, $data->status);
    }

    public function edit($id)
    {
        //
    }

    /**
     * Modificar un usuario.
     *
     * @param  UpdateUserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $data = $this->userService->update($request, $id);
        return response()->json($data->data, $data->status);
    }

    /**
     * Eliminar un usuario.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->userService->delete($id);
        return response()->json($data->data, $data->status);
    }

    /**
     * Listar roles que puede tener un usuario.
     *
     * @return \Illuminate\Http\Response
     */
    public function listRoles()
    {
        $data = $this->userService->listRoles();
        return response()->json($data->data, $data->status);
    }

    /**
     * Listar estados que puede tener un usuario.
     *
     * @return \Illuminate\Http\Response
     */
    public function listStatus()
    {
        $data = $this->userService->listStatus();
        return response()->json($data->data, $data->status);
    }

    /**
     * Cambiar contraseña de usuario
     *
     * @param  \App\Http\Requests\UpdatePasswordRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePassword(UpdatePasswordRequest $request, $id)
    {
        $data = $this->userService->changePassword($request, $id);
        return response()->json($data->data, $data->status);
    }
}
