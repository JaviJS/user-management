<?php
namespace App\Repositories\PersonalAccessTokens;

use App\Repositories\RepositoryInterface;

interface PersonalAccessTokensRepositoryInterface extends RepositoryInterface
{
    public function findByUserToken($id, $tokenable_id, $tokenable_type);
    public function deleteByUser($tokenable_id);
    public function findTokensUser($tokenable_id);
}