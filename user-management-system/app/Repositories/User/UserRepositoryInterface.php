<?php
namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface{
    public function listStatus();
    public function listRoles();
    public function findByEmail($email);
}