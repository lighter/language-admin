<?php

namespace App\Repositories;

use App\Model\User;
use Illuminate\Database\QueryException;

class UserRepository
{
    public function createNewUser($userData) {
        try {
            return User::create($userData);
        } catch (QueryException $e) {

        }
    }
}