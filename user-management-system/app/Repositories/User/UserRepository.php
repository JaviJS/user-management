<?php

namespace App\Repositories\User;

use App\Repositories\User\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function all()
    {
        return User::with('photo_user')->get();
    }
    public function create(array $data)
    {
        return User::create($data);
    }
    public function update(array $data, $id)
    {
        $user = User::where('id', $id);
        $user->update($data);
        return $user->first();
    }
    public function delete($id)
    {
        return User::destroy($id);
    }
    public function find($id)
    {
        $user = User::where('id', $id)
            ->with('photo_user')
            ->first();
        return $user;
    }
    public function listStatus()
    {
        return User::status;
    }
    public function listRoles()
    {
        return User::roles;
    }
    public function findByEmail($email){
        $user = User::where('email', $email)
            ->with('photo_user')
            ->first();
        return $user;
    }
}