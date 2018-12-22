<?php

namespace App\Repositories;

use App\Model\User;
use Illuminate\Database\QueryException;

/**
 * Class UserRepository
 *
 * @property User model
 * @package App\Repositories
 */
class UserRepository
{
    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user) {
        $this->model = $user;
    }

    /**
     * @param $userData
     *
     * @return mixed
     */
    public function createNewUser($userData) {
        try {
            return $this->model->create($userData);
        } catch (QueryException $e) {

        }
    }

    public function getUserProjects($userId)
    {
        try {
            return $this->model->find($userId)->projects()->get();
        } catch (QueryException $e) {

        }
    }
}
