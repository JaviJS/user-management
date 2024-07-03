<?php

namespace App\Repositories\PersonalAccessTokens;

use App\Repositories\PersonalAccessTokens\PersonalAccessTokensRepositoryInterface;
use App\Models\PersonalAccessTokens;

class PersonalAccessTokensRepository implements PersonalAccessTokensRepositoryInterface
{
    public function all()
    {
        return PersonalAccessTokens::get();
    }
    public function create(array $data)
    {
        return PersonalAccessTokens::create($data);
    }
    public function update(array $data, $id)
    {
        $personal_access_tokens = PersonalAccessTokens::where('id', $id);
        $personal_access_tokens->update($data);
        return $personal_access_tokens->first();
    }
    public function delete($id)
    {
        return PersonalAccessTokens::destroy($id);
    }
    public function find($id)
    {
        $personal_access_tokens = PersonalAccessTokens::where('id', $id)
            ->first();
        return $personal_access_tokens;
    }
    public function findByUserToken($id, $tokenable_id, $tokenable_type)
    {
        $personal_access_tokens = PersonalAccessTokens::where('id', $id)
            ->where('tokenable_id', $tokenable_id)
            ->where('tokenable_type', $tokenable_type)
            ->first();
        return $personal_access_tokens;
    }

    public function deleteByUser($tokenable_id)
    {
        return PersonalAccessTokens::where('tokenable_id', $tokenable_id)->delete();
    }

    public function findTokensUser($tokenable_id)
    {
        return PersonalAccessTokens::where('tokenable_id', $tokenable_id)->get();
    }
}