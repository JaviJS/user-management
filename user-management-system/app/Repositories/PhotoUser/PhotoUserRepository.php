<?php

namespace App\Repositories\PhotoUser;

use App\Repositories\PhotoUser\PhotoUserRepositoryInterface;
use App\Models\PhotoUser;

class PhotoUserRepository implements PhotoUserRepositoryInterface
{
    public function all()
    {
        return PhotoUser::get();
    }
    public function create(array $data)
    {
        return PhotoUser::create($data);
    }
    public function update(array $data, $id)
    {
        $photo_user = PhotoUser::where('id', $id);
        $photo_user->update($data);
        return $photo_user->first();
    }
    public function delete($id)
    {
        return PhotoUser::destroy($id);
    }
    public function find($id)
    {
        $photo_user = PhotoUser::where('id', $id)
            ->first();
        return $photo_user;
    }
}